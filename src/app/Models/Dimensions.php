<?php

namespace PatrykSawicki\InPost\app\Models;

use InvalidArgumentException;

class Dimensions
{
    private string $unit;
    private float $length, $width, $height;

    const ALLOWED_UNITS = ['mm'];

    /**
     * @param float $length
     * @param float $width
     * @param float $height
     * @param string $unit
     */
    public function __construct(float $length, float $width, float $height, string $unit = 'mm')
    {
        $this->validateUnit($unit);

        $this->unit = $unit;
        $this->length = $length;
        $this->width = $width;
        $this->height = $height;
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
            'length' => $this->length,
            'width' => $this->width,
            'height' => $this->height,
            'unit' => $this->unit,
        ];
    }
}