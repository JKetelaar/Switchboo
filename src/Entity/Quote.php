<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuoteRepository")
 */
class Quote
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $postcode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $gasElectricityType;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $sameSupplier;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $energySupplier;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $plan;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $economyMeter;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $paymentType;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $planNotSure;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    public function setPostcode(string $postcode): self
    {
        $this->postcode = $postcode;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getGasElectricityType(): ?int
    {
        return $this->gasElectricityType;
    }

    public function setGasElectricityType(?int $gasElectricityType): self
    {
        $this->gasElectricityType = $gasElectricityType;

        return $this;
    }

    public function getSameSupplier(): ?bool
    {
        return $this->sameSupplier;
    }

    public function setSameSupplier(?bool $sameSupplier): self
    {
        $this->sameSupplier = $sameSupplier;

        return $this;
    }

    public function getEnergySupplier(): ?string
    {
        return $this->energySupplier;
    }

    public function setEnergySupplier(?string $energySupplier): self
    {
        $this->energySupplier = $energySupplier;

        return $this;
    }

    public function getPlan(): ?string
    {
        return $this->plan;
    }

    public function setPlan(?string $plan): self
    {
        $this->plan = $plan;

        return $this;
    }

    public function getEconomyMeter(): ?bool
    {
        return $this->economyMeter;
    }

    public function setEconomyMeter(?bool $economyMeter): self
    {
        $this->economyMeter = $economyMeter;

        return $this;
    }

    public function getPaymentType(): ?string
    {
        return $this->paymentType;
    }

    public function setPaymentType(?string $paymentType): self
    {
        $this->paymentType = $paymentType;

        return $this;
    }

    public function getPlanNotSure(): ?bool
    {
        return $this->planNotSure;
    }

    public function setPlanNotSure(?bool $planNotSure): self
    {
        $this->planNotSure = $planNotSure;

        return $this;
    }

    public function getEnergySupplierImage()
    {
        return $this->energySupplier;
    }

    public function setEnergySupplierImage($supplier)
    {
        if ($supplier !== null) {
            return $this->setEnergySupplier($supplier);
        }
    }
}
