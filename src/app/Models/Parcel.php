<?php

namespace PatrykSawicki\InPost\app\Models;

class Parcel
{
    private string $id;
    private Dimensions $dimensions;
    private Weight $weight;
    private bool $is_non_standard;

    /**
     * @param string $id
     * @param Dimensions $dimensions
     * @param Weight $weight
     * @param bool $is_non_standard
     */
    public function __construct(Dimensions $dimensions, Weight $weight, string $id = '', bool $is_non_standard = false)
    {
        $this->id = $id;
        $this->dimensions = $dimensions;
        $this->weight = $weight;
        $this->is_non_standard = $is_non_standard;
    }

    /**
     * Return array data.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'dimensions' => $this->dimensions->toArray(),
            'weight' => $this->weight->toArray(),
            'is_non_standard' => $this->is_non_standard,
        ];
    }
}