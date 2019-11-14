<?php
/**
 * @author JKetelaar
 */

namespace App\Service;

use App\Entity\Quote;

class UsageConverter
{
    const DATA_TEMPLATE = [
        'data-template' =>
            [
                'groups' =>
                    [
                        [
                            'items' =>
                                [
                                    [
                                        'data' => true,
                                        'name' => 'compareGas',
                                        'type' => 'bool',
                                    ],
                                    [
                                        'data' => true,
                                        'name' => 'compareElec',
                                        'type' => 'bool',
                                    ],
                                ],
                            'name' => 'includedFuels',
                        ],
                        [
                            'items' =>
                                [
                                    [
                                        'data' => 'CHANGE',
                                        'name' => 'usageType',
                                        'type' => 'oneOf',
                                    ],
                                ],
                            'name' => 'gasUsageType',
                        ],
                        [
                            'items' =>
                                [
                                    [
                                        'data' => 'CHANGE',
                                        'name' => 'usageAsSpend',
                                        'type' => 'decimal',
                                    ],
                                    [
                                        'data' => 'CHANGE',
                                        'name' => 'spendPeriod',
                                        'type' => 'oneOf',
                                    ],
                                ],
                            'name' => 'gasSpend',
                        ],
                        [
                            'items' =>
                                [
                                    [
                                        'data' => 'CHANGE',
                                        'name' => 'usageAsKWh',
                                        'type' => 'decimal',
                                    ],
                                    [
                                        'data' => 'CHANGE',
                                        'name' => 'usagePeriod',
                                        'type' => 'oneOf',
                                    ],
                                ],
                            'name' => 'gasKWhUsage',
                        ],
                        [
                            'items' =>
                                [
                                    [
                                        'data' => 'CHANGE',
                                        'name' => 'usageType',
                                        'type' => 'oneOf',
                                    ],
                                ],
                            'name' => 'elecUsageType',
                        ],
                        [
                            'items' =>
                                [
                                    [
                                        'data' => 'CHANGE',
                                        'name' => 'usageAsSpend',
                                        'type' => 'decimal',
                                    ],
                                    [
                                        'data' => 'CHANGE',
                                        'name' => 'spendPeriod',
                                        'type' => 'oneOf',
                                    ],
                                ],
                            'name' => 'elecSpend',
                        ],
                        [
                            'items' =>
                                [
                                    [
                                        'data' => 'CHANGE',
                                        'mandatory' => true,
                                        'name' => 'usageAsKWh',
                                        'prompt' => 'kWh used for electricity',
                                        'type' => 'decimal',
                                    ],
                                    [
                                        'acceptableValues' =>
                                            [
                                                [
                                                    'id' => '1',
                                                    'name' => 'per month',
                                                ],
                                                [
                                                    'id' => '2',
                                                    'name' => 'per quarter',
                                                ],
                                                [
                                                    'id' => '3',
                                                    'name' => 'per year',
                                                ],
                                            ],
                                        'data' => '3',
                                        'name' => 'usagePeriod',
                                        'type' => 'oneOf',
                                    ],
                                ],
                            'name' => 'elecKWhUsage',
                        ],
                        [
                            'items' =>
                                [
                                    [
                                        'data' => 0.42,
                                        'name' => 'nightUsagePercentage',
                                        'type' => 'decimal',
                                    ],
                                    [
                                        'data' => 'CHANGE', // true/false
                                        'name' => 'isElectricitySupplyEconomy7',
                                        'type' => 'bool',
                                    ],
                                ],
                            'name' => 'economy7',
                        ],
                    ],
            ],
    ];

    public static function templateToData(Quote $quote): array
    {
        $groups = self::DATA_TEMPLATE['data-template']['groups'];
        $template = [];
        $removeIndexes = [];

        if ($quote->getGasElectricityType() !== 1) {
            if ($quote->getGasElectricityType() === 2) {
                $groups[0]['items'][1]['data'] = false;
                $removeIndexes[] = 4;
                $removeIndexes[] = 5;
                $removeIndexes[] = 6;
            } elseif ($quote->getGasElectricityType() !== 2) {
                $groups[0]['items'][0]['data'] = false;
                $removeIndexes[] = 1;
                $removeIndexes[] = 2;
                $removeIndexes[] = 3;

            }
        }

        // Gas
        if ($quote->isSelectedGasSpend()) {
            $groups[1]['items'][0]['data'] = 4;
            $groups[2]['items'][0]['data'] = $quote->getGasMoneySpend();
            $groups[2]['items'][1]['data'] = self::periodToInt($quote->getGasMoneyPerType());

            $removeIndexes[] = 3;
        } else {
            $groups[1]['items'][0]['data'] = 3;
            $groups[3]['items'][0]['data'] = $quote->getGasUseKWH();
            $groups[3]['items'][1]['data'] = 3;

            $removeIndexes[] = 2;
        }

        // Electric
        if ($quote->isSelectedElecSpend()) {
            $groups[4]['items'][0]['data'] = 4;
            $groups[5]['items'][0]['data'] = $quote->getElecMoneySpend();
            $groups[5]['items'][1]['data'] = self::periodToInt($quote->getElecMoneyPerType());

            $removeIndexes[] = 6;
        } else {
            $groups[4]['items'][0]['data'] = 3;
            $groups[6]['items'][0]['data'] = $quote->getElecUseKWH();
            $groups[6]['items'][1]['data'] = 3;

            $removeIndexes[] = 5;
        }

        $groups[7]['items'][1]['data'] = $quote->getEconomyMeter();

        foreach ($groups as $index => $group) {
            if (!in_array($index, $removeIndexes)) {
                $template[] = $group;
            }
        }

        return [
            'data-template' =>
                [
                    'groups' => $template,
                ],
        ];
    }

    private static function periodToInt(string $period)
    {
        switch ($period) {
            case 'month':
                return 1;
            case 'quarter':
                return 2;
            default:
            case 'year':
                return 3;
        }
    }
}
