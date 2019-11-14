<?php
/**
 * @author JKetelaar
 */

namespace App\Service;

use App\Entity\API\FutureSupply;
use App\Entity\API\Plan;
use App\Entity\API\Supplier;
use App\Entity\Quote;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

/**
 * Class SwitchManager
 * @package App\Service
 */
class SwitchManager
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var Quote
     */
    private $quote;

    /**
     * SwitchManager constructor.
     * @param string $url
     * @param string $apiKey
     */
    public function __construct(string $url, string $apiKey)
    {
        $this->client = new Client(['base_uri' => $url]);
        $this->apiKey = $apiKey;
    }

    public function getSuppliers(): array
    {
        $suppliers = [];
        $content = $this->getCurrentSupplies();

        foreach ($content['fuels']['electricity']['suppliers'] as $supplierJSON) {
            $supplier = new Supplier($supplierJSON['id'], $supplierJSON['logo']['uri'], $supplierJSON['name']);

            $plans = [];
            foreach ($supplierJSON['supplierTariffs'] as $tariff) {
                $plan = new Plan($tariff['id'], $tariff['name']);
                $plans[] = $plan;
            }
            $supplier->setPlans($plans);

            $suppliers[] = $supplier;
        }

        return $suppliers;
    }

    private function getCurrentSupplies(): array
    {
        $currentSupply = '/domestic/energy/switches/'.$this->getToken().'/current-supply';
        $currentSupplyContent = $this->getContent($currentSupply);
        $switchesCurrentSupply = $currentSupplyContent['linked-data'][0]['uri'];
        $content = $this->getContent($switchesCurrentSupply);

        return $content;
    }

    private function getToken(): string
    {
        if ($this->quote->getToken() !== null) {
            return $this->quote->getToken();
        }

        $content = $this->getContent(
            '/domestic/energy/switches',
            'POST',
            [
                'data-template' =>
                    [
                        'groups' =>
                            [
                                [
                                    'items' =>
                                        [
                                            0 =>
                                                [
                                                    'data' => $this->quote->getPostcode(),
                                                    'name' => 'postcode',
                                                ],
                                        ],
                                    'name' => 'supplyPostcode',
                                ],
                                [
                                    'items' =>
                                        [
                                            0 =>
                                                [
                                                    'data' => $this->apiKey,
                                                    'name' => 'apiKey',
                                                ],
                                        ],
                                    'mandatory' => true,
                                    'name' => 'references',
                                ],
                            ],
                    ],
            ]
        );

        $this->quote->setToken($this->getContent($content['links'][0]['uri'])['id']);

        return $this->quote->getToken();
    }

    private function getContent(string $path, string $method = 'GET', array $data = []): array
    {
        $options = [
            'headers' => [
                'Content-Type' => 'application/vnd-fri-domestic-energy+json;version=2.0',
                'User-Agent' => 'Switchboo',
            ],
        ];
        if ($method === 'POST' || $method === 'PUT') {
            $options['json'] = $data;
        }

        try {
            $request = $this->client->request(
                $method,
                $path,
                $options
            );
        } catch (ClientException $e) {
            throw new \Exception($e->getResponse()->getBody()->getContents());
        }

        return json_decode($request->getBody()->getContents(), true);
    }

    public function getPaymentMethods(bool $raw = false): array
    {
        $paymentMethods = [];
        $content = $this->getCurrentSupplies();

        foreach ($content['paymentMethods'] as $paymentMethod) {
            if (!$raw) {
                $paymentMethods[$paymentMethod['name']] = $paymentMethod['id'];
            } else {
                $paymentMethods[$paymentMethod['id']] = $paymentMethod['name'];
            }
        }

        if (!$raw) {
            ksort($paymentMethods);
        }

        return $paymentMethods;
    }

    public function getFutureSupplies()
    {
        $futureSupplies = [];

        $this->updateUsage();

        $futureSuppliesResults = $this->getContent(
            '/domestic/energy/switches/'.$this->getToken().'/future-supplies'
        )['results'];

        foreach ($futureSuppliesResults as $futureSuppliesResult) {
            foreach ($futureSuppliesResult['energySupplies'] as $futureSupply) {
                if ($futureSupply['canApply'] === true) {
                    if ($futureSupply['expectedAnnualSavings'] > 0) {
                        $futureSupplies[] = FutureSupply::fromSupplierJSON($futureSupply);
                    }
                }
            }
        }

        usort(
            $futureSupplies,
            function ($a, $b) {
                /** @var $a FutureSupply */
                /** @var $b FutureSupply */
                return $a->getSavings() < $b->getSavings();
            }
        );

        return $futureSupplies;
    }

    public function updateUsage()
    {
        $data = UsageConverter::templateToData($this->quote);
        $this->getContent(
            '/domestic/energy/switches/'.$this->getToken().'/usage',
            'PUT',
            $data
        );
    }

    /**
     * @param Quote $quote
     */
    public function setQuote(Quote $quote): void
    {
        $this->quote = $quote;
    }
}
