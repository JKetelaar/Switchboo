<?php
/**
 * @author JKetelaar
 */

namespace App\Entity\API;

class FutureSupply
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var float
     */
    private $savings;

    /**
     * @var int
     */
    private $supplierId;

    /**
     * @var string
     */
    private $supplier;

    /**
     * @var string
     */
    private $logo;

    /**
     * @var string
     */
    private $tariffType;

    /**
     * @var int
     */
    private $paymentType;

    /**
     * @var float
     */
    private $expectedSpend;

    /**
     * FutureSupply constructor.
     * @param string $id
     * @param float $savings
     * @param int $supplierId
     * @param string $supplier
     * @param string $logo
     * @param string $tariffType
     * @param int $paymentType
     */
    public function __construct(string $id, float $savings, int $supplierId, string $supplier, string $logo, string $tariffType, int $paymentType, float $expectedSpend)
    {
        $this->id = $id;
        $this->savings = $savings;
        $this->supplierId = $supplierId;
        $this->supplier = $supplier;
        $this->logo = $logo;
        $this->tariffType = $tariffType;
        $this->paymentType = $paymentType;
        $this->expectedSpend = $expectedSpend;
    }

    public static function fromSupplierJSON(array $json): FutureSupply
    {
        return new FutureSupply(
            $json['id'],
            $json['expectedAnnualSavings'],
            $json['supplier']['id'],
            $json['supplier']['name'],
            $json['supplyDetails']['logo']['uri'],
            $json['tariffType'],
            $json['supplyDetails']['paymentMethod']['id'],
            $json['expectedAnnualSpend']
        );
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getSavings(): float
    {
        return number_format($this->savings, 2);
    }

    /**
     * @return float
     */
    public function getSavingsPerMonth(): float
    {
        return number_format($this->savings / 12, 2);
    }

    /**
     * @return int
     */
    public function getSupplierId(): int
    {
        return $this->supplierId;
    }

    /**
     * @return string
     */
    public function getSupplier(): string
    {
        return $this->supplier;
    }

    /**
     * @return string
     */
    public function getLogo(): string
    {
        return $this->logo;
    }

    /**
     * @return string
     */
    public function getTariffType(): string
    {
        return $this->tariffType;
    }

    /**
     * @return int
     */
    public function getPaymentType(): int
    {
        return $this->paymentType;
    }

    /**
     * @return float
     */
    public function getExpectedSpend(): float
    {
        return number_format($this->expectedSpend, 2);
    }

    /**
     * @return float
     */
    public function getExpectedSpendPerMonth(): float
    {
        return number_format($this->expectedSpend / 12, 2);
    }
}
