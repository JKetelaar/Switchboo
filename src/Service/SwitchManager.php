<?php
/**
 * @author JKetelaar
 */

namespace App\Service;

use App\Entity\API\Plan;
use App\Entity\API\Supplier;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

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
        $postcodeRequest = $this->createPostcodeRequest($postcode);
        $currentSupply = $postcodeRequest['links'][2]['uri'];
        $currentSupplyContent = $this->getContent($currentSupply);
        $switchesCurrentSupply = $currentSupplyContent['linked-data'][0]['uri'];
        $content = $this->getContent($switchesCurrentSupply);

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
        if ($method === 'POST') {
            $options['json'] = $data;
        }

        try {
            $request = $this->client->request(
                $method,
                $path,
                $options
            );
        } catch (GuzzleException $e) {
            var_dump($e->getMessage()->getBody()->getContents());
            die();
        }

        return json_decode($request->getBody()->getContents(), true);
    }

    public function checkSwitch()
    {

    }
}
