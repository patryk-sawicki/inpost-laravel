<?php

namespace PatrykSawicki\InPost\app\Models;

use InvalidArgumentException;

class Cash
{
    private string $currency;
    private float $amount;

    const ALLOWED_CURRENCIES = ['PLN'];

    /**
     * @param string $currency
     * @param float $amount
     */
    public function __construct(float $amount, string $currency = 'PLN')
    {
        $this->validateCurrency($currency);

        $this->currency = $currency;
        $this->amount = $amount;
    }

    /**
     * Validate unit.
     *
     * @param string $currency
     * @return void
     */
    private function validateCurrency(string $currency): void
    {
        if(!in_array($currency, self::ALLOWED_CURRENCIES))
            throw new InvalidArgumentException("Invalid currency: $currency");
    }

    /**
     * Return array data.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'currency' => $this->currency,
        ];
    }
}