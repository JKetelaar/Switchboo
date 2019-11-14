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
     * SwitchManager constructor.
     * @param string $url
     * @param string $apiKey
     */
    public function __construct(string $url, string $apiKey)
    {
        $this->client = new Client(['base_uri' => $url]);
        $this->apiKey = $apiKey;
    }

    public function getSuppliers(string $postcode): array
    {
        $suppliers = [];
        $content = $this->getCurrentSupplies($postcode);

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

    private function getCurrentSupplies(string $postcode): array
    {
        $postcodeRequest = $this->createPostcodeRequest($postcode);
        $currentSupply = $postcodeRequest['links'][2]['uri'];
        $currentSupplyContent = $this->getContent($currentSupply);
        $switchesCurrentSupply = $currentSupplyContent['linked-data'][0]['uri'];
        $content = $this->getContent($switchesCurrentSupply);

        return $content;
    }

    private function createPostcodeRequest(string $postcode): array
    {
        return $this->getContent(
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
                                                    'data' => $postcode,
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

    public function getPaymentMethods(string $postcode, bool $raw = false): array
    {
        $paymentMethods = [];
        $content = $this->getCurrentSupplies($postcode);

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

    public function getFutureSupplies(Quote $quote)
    {
        $postcode = $quote->getPostcode();
        $futureSupplies = [];
        $postcodeRequest = $this->createPostcodeRequest($postcode);
        $currentSupply = $postcodeRequest['links'][0]['uri'];
        $link = parse_url($currentSupply);
        $link['path'] .= '/future-supplies';

        $this->updateUsage($quote, $currentSupply);

        $futureSuppliesResults = $this->getContent($this->unparse_url($link))['results'];

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

    public function updateUsage(Quote $quote, string $link)
    {
        $data = UsageConverter::templateToData($quote);
        $usage = $this->getContent($link)['links'][3]['uri'];
        $this->getContent($usage, 'PUT', $data);
    }

    private function unparse_url($parsed_url)
    {
        $scheme = isset($parsed_url['scheme']) ? $parsed_url['scheme'].'://' : '';
        $host = isset($parsed_url['host']) ? $parsed_url['host'] : '';
        $port = isset($parsed_url['port']) ? ':'.$parsed_url['port'] : '';
        $user = isset($parsed_url['user']) ? $parsed_url['user'] : '';
        $pass = isset($parsed_url['pass']) ? ':'.$parsed_url['pass'] : '';
        $pass = ($user || $pass) ? "$pass@" : '';
        $path = isset($parsed_url['path']) ? $parsed_url['path'] : '';
        $query = isset($parsed_url['query']) ? '?'.$parsed_url['query'] : '';
        $fragment = isset($parsed_url['fragment']) ? '#'.$parsed_url['fragment'] : '';

        return "$scheme$user$pass$host$port$path$query$fragment";
    }
}
