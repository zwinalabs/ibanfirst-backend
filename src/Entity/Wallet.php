<?php

namespace App\Entity;

use App\Repository\WalletRepository;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Wallet
 */

class Wallet
{
    /**
     * @var string|null
     */
    private $id;
    /**
     * @var string|null
     */
    private $tag;
    /**
     * @var string|null
     */
    private $currency;
    /**
     * @var \DateTime|null
     */
    private $dateLastFinancialMovement;

    /**
     * @var \stdClass
     */
    private $bookingAmount;

    /**
     * @var \stdClass
     */
    private $valueAmount;

    /**
     * @var ArrayCollection
     */
    private $financialMovements;

    /**
     * @return ArrayCollection
     */
    public function getfinancialMovements(): ArrayCollection
    {
        return $this->financialMovements;
    }

    /**
     * @param  ArrayCollection $financialMovements
     * @return Wallet
     */
    public function setfinancialMovements(ArrayCollection $financialMovements): self
    {
        $this->financialMovements = $financialMovements;
        return $this;
    }

    public function __construct()
    {
        $this->financialMovements = new ArrayCollection();
    }
    /**
     * @return null|string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param  null|string $id
     * @return Wallet
     */
    public function setId(?string $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getTag(): ?string
    {
        return $this->tag;
    }

    /**
     * @param  null|string $tag
     * @return Wallet
     */
    public function setTag(?string $tag): self
    {
        $this->tag = $tag;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * @param  null|string $currency
     * @return Wallet
     */
    public function setCurrency(?string $currency): self
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateLastFinancialMovement(): ?\DateTime
    {
        return $this->dateLastFinancialMovement;
    }

    /**
     * @param  \DateTime|null $dateLastFinancialMovement
     * @return Wallet
     */
    public function setDateLastFinancialMovement(?\DateTime $dateLastFinancialMovement): self
    {
        $this->dateLastFinancialMovement = $dateLastFinancialMovement;
        return $this;
    }

    /**
     * @return stdClass
     */
    public function getBookingAmount(): ?\stdClass
    {
        return $this->bookingAmount;
    }

    /**
     * @param  stdClass $bookingAmount
     * @return Wallet
     */
    public function setBookingAmount(?\stdClass $bookingAmount): self
    {
        $this->bookingAmount = $bookingAmount;
        return $this;
    }

    /**
     * @return stdClass
     */
    public function getValueAmount(): ?\stdClass
    {
        return $this->valueAmount;
    }

    /**
     * @param  Amount $valueAmount
     * @return Wallet
     */
    public function setValueAmount(?\stdClass $valueAmount): self
    {
        $this->valueAmount = $valueAmount;
        return $this;
    }

    /**
     * @param  FinancialMovements $financialMovement
     * @return Wallet
     */
    public function addfinancialMovements(FinancialMovements $financialMovement): self
    {
        if (!$this->financialMovements->contains($financialMovement)) {
            $this->financialMovements[] = $financialMovement;
        }
        return $this;
    }

    /**
     * @param  FinancialMovements $financialMovement
     * @return Wallet
     */
    public function removefinancialMovements(FinancialMovements $financialMovement): self
    {
        if ($this->financialMovements->contains($financialMovement)) {
            $this->financialMovements->removeElement($financialMovement);
        }
        return $this;
    }
}