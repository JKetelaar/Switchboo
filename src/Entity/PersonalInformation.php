<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PersonalInformationRepository")
 */
class PersonalInformation
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
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $surName;

    /**
     * @ORM\Column(type="date")
     */
    private $dateOfBirth;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="boolean")
     */
    private $smartMeter;

    /**
     * @ORM\Column(type="boolean")
     */
    private $sameBilling;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $specialRequirements;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $holdersName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sortCode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $accountNumber;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Quote", mappedBy="personalInformation")
     */
    private $quotes;

    public function __construct()
    {
        $this->quotes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getSurName(): ?string
    {
        return $this->surName;
    }

    public function setSurName(string $surName): self
    {
        $this->surName = $surName;

        return $this;
    }

    public function getDateOfBirth(): ?DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(DateTimeInterface $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getSmartMeter(): ?bool
    {
        return $this->smartMeter;
    }

    public function setSmartMeter(bool $smartMeter): self
    {
        $this->smartMeter = $smartMeter;

        return $this;
    }

    public function getSameBilling(): ?bool
    {
        return $this->sameBilling;
    }

    public function setSameBilling(bool $sameBilling): self
    {
        $this->sameBilling = $sameBilling;

        return $this;
    }

    public function getSpecialRequirements(): ?string
    {
        return $this->specialRequirements;
    }

    public function setSpecialRequirements(?string $specialRequirements): self
    {
        $this->specialRequirements = $specialRequirements;

        return $this;
    }

    public function getHoldersName(): ?string
    {
        return $this->holdersName;
    }

    public function setHoldersName(string $holdersName): self
    {
        $this->holdersName = $holdersName;

        return $this;
    }

    public function getSortCode(): ?string
    {
        return $this->sortCode;
    }

    public function setSortCode(string $sortCode): self
    {
        $this->sortCode = $sortCode;

        return $this;
    }

    public function getAccountNumber(): ?string
    {
        return $this->accountNumber;
    }

    public function setAccountNumber(string $accountNumber): self
    {
        $this->accountNumber = $accountNumber;

        return $this;
    }

    /**
     * @return Collection|Quote[]
     */
    public function getQuotes(): Collection
    {
        return $this->quotes;
    }

    public function addQuote(Quote $quote): self
    {
        if (!$this->quotes->contains($quote)) {
            $this->quotes[] = $quote;
            $quote->setPersonalInformation($this);
        }

        return $this;
    }

    public function removeQuote(Quote $quote): self
    {
        if ($this->quotes->contains($quote)) {
            $this->quotes->removeElement($quote);
            // set the owning side to null (unless already changed)
            if ($quote->getPersonalInformation() === $this) {
                $quote->setPersonalInformation(null);
            }
        }

        return $this;
    }
}
