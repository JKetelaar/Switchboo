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
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $token;

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

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $gasMoneySpend;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $gasMoneyPerType;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $gasUseKWH;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $elecMoneySpend;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $elecMoneyPerType;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $elecUseKWH;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $chosenSupplier;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PersonalInformation", inversedBy="quotes")
     */
    private $personalInformation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phoneNumber;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $selectedGasSpend;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $selectedElecSpend;

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

    public function getGasMoneySpend(): ?string
    {
        return number_format($this->gasMoneySpend, 2);
    }

    public function setGasMoneySpend(?float $gasMoneySpend): self
    {
        $this->gasMoneySpend = $gasMoneySpend;

        return $this;
    }

    public function getGasMoneyPerType(): ?string
    {
        return $this->gasMoneyPerType;
    }

    public function setGasMoneyPerType(?string $gasMoneyPerType): self
    {
        $this->gasMoneyPerType = $gasMoneyPerType;

        return $this;
    }

    public function getGasUseKWH(): ?float
    {
        return $this->gasUseKWH;
    }

    public function setGasUseKWH(?float $gasUseKWH): self
    {
        $this->gasUseKWH = $gasUseKWH;

        return $this;
    }

    public function getElecMoneySpend(): ?string
    {
        return number_format($this->elecMoneySpend, 2);
    }

    public function setElecMoneySpend(?float $elecMoneySpend): self
    {
        $this->elecMoneySpend = $elecMoneySpend;

        return $this;
    }

    public function getElecMoneyPerType(): ?string
    {
        return $this->elecMoneyPerType;
    }

    public function setElecMoneyPerType(?string $elecMoneyPerType): self
    {
        $this->elecMoneyPerType = $elecMoneyPerType;

        return $this;
    }

    public function getElecUseKWH(): ?float
    {
        return $this->elecUseKWH;
    }

    public function setElecUseKWH(?float $elecUseKWH): self
    {
        $this->elecUseKWH = $elecUseKWH;

        return $this;
    }

    public function getChosenSupplier(): ?string
    {
        return $this->chosenSupplier;
    }

    public function setChosenSupplier(?string $chosenSupplier): self
    {
        $this->chosenSupplier = $chosenSupplier;

        return $this;
    }

    public function getPersonalInformation(): ?PersonalInformation
    {
        return $this->personalInformation;
    }

    public function setPersonalInformation(?PersonalInformation $personalInformation): self
    {
        $this->personalInformation = $personalInformation;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     * @return Quote
     */
    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSelectedGasSpend(): ?bool
    {
        return $this->selectedGasSpend;
    }

    /**
     * @param bool $selectedGasSpend
     * @return Quote
     */
    public function setSelectedGasSpend(?bool $selectedGasSpend): self
    {
        $this->selectedGasSpend = $selectedGasSpend;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSelectedElecSpend(): ?bool
    {
        return $this->selectedElecSpend;
    }

    /**
     * @param bool $selectedElecSpend
     * @return Quote
     */
    public function setSelectedElecSpend(?bool $selectedElecSpend): self
    {
        $this->selectedElecSpend = $selectedElecSpend;

        return $this;
    }

    /**
     * @return string
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return Quote
     */
    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }
}
