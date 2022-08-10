<?php

namespace PatrykSawicki\InPost\app\Models;

class Address
{
    private string $street, $building_number, $city, $post_code, $country_code;

    /**
     * @param string $street
     * @param string $building_number
     * @param string $city
     * @param string $post_code
     * @param string $country_code
     */
    public function __construct(string $street, string $building_number, string $city, string $post_code, string $country_code = 'PL')
    {
        $this->street = $street;
        $this->building_number = $building_number;
        $this->city = $city;
        $this->post_code = $post_code;
        $this->country_code = $country_code;
    }

    /**
     * Return array data.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'street' => $this->street,
            'building_number' => $this->building_number,
            'city' => $this->city,
            'post_code' => $this->post_code,
            'country_code' => $this->country_code,
        ];
    }
}