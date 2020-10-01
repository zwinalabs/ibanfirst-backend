<?php

namespace App\Entity;

/**
 * Class FinancialMovements
 */
class FinancialMovements
{
    /**
     * @var string|null
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $bookingDate;

    /**
     * @var \DateTime
     */
    private $valueDate;

    /**
     * @var \App\Wallet
     */
    private $wallet;

    /**
     * @var \stdClass
     */
    private $amount;

    /**
     * @var string
     */
    private $description;

    /**
     * @return null|string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param  null|string $id
     * @return FinancialMovements
     */
    public function setId(?string $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getBookingDate(): \DateTime
    {
        return $this->bookingDate;
    }

    /**
     * @param  \DateTime $bookingDate
     * @return FinancialMovements
     */
    public function setBookingDate(\DateTime $bookingDate): self
    {
        $this->bookingDate = $bookingDate;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getValueDate(): \DateTime
    {
        return $this->valueDate;
    }

    /**
     * @param  \DateTime $valueDate
     * @return FinancialMovements
     */
    public function setValueDate(\DateTime $valueDate): self
    {
        $this->valueDate = $valueDate;
        return $this;
    }

    /**
     * @return \App\Wallet
     */
    public function getWallet(): ?Wallet
    {
        return $this->wallet;
    }

    /**
     * @param  \App\Wallet $wallet
     * @return FinancialMovements
     */
    public function setWallet(?Wallet $wallet): self
    {
        $this->wallet = $wallet;
        return $this;
    }

    /**
     * @return Amount
     */
    public function getAmount(): ?\stdClass
    {
        return $this->amount;
    }

    /**
     * @param  Amount $amount
     * @return FinancialMovements
     */
    public function setAmount(\stdClass $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param  string $description
     * @return FinancialMovements
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }
}
