<?php

namespace PatrykSawicki\InPost\app\Models;

use InvalidArgumentException;

class Parcels
{
    private array $parcels;

    /**
     * @param Parcel ...$parcels
     */
    public function __construct(Parcel ...$parcels)
    {
        $this->parcels = $parcels;
    }

    /**
     * Validate parcels.
     */
    private function validateParcels(): void
    {
        if(count($this->parcels) === 0)
            throw new InvalidArgumentException('No parcels provided');

        if(count($this->parcels) > 1000)
            throw new InvalidArgumentException('Maximum 1000 parcels allowed');
    }

    /**
     * Return array data.
     *
     * @return array
     */
    public function toArray(): array
    {
        $result = [];

        foreach($this->parcels as $parcel)
            $result[] = $parcel->toArray();

        return $result;
    }
}