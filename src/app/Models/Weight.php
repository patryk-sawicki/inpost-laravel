<?php

namespace PatrykSawicki\InPost\app\Models;

use InvalidArgumentException;

class Weight
{
    private string $unit;
    private float $amount;

    const ALLOWED_UNITS = ['kg'];

    /**
     * @param string $unit
     * @param float $amount
     */
    public function __construct(float $amount, string $unit = 'kg')
    {
        $this->validateUnit($unit);

        $this->unit = $unit;
        $this->amount = $amount;
    }

    /**
     * Validate unit.
     *
     * @param string $unit
     * @return void
     */
    private function validateUnit(string $unit): void
    {
        if(!in_array($unit, self::ALLOWED_UNITS))
            throw new InvalidArgumentException("Invalid unit: $unit");
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
            'unit' => $this->unit,
        ];
    }
}