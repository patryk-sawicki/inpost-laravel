<?php

namespace PatrykSawicki\InPost\app\Models;

class Sender
{
    private string $name, $company_name, $first_name, $last_name, $phone, $email;
    private Address $address;

    public function __construct(string $name, string $company_name, string $first_name, string $last_name, string $email, string $phone, Address $address)
    {
        $this->name = $name;
        $this->company_name = $company_name;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->phone = $phone;
        $this->address = $address;
    }

    /**
     * Return array data.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'company_name' => $this->company_name,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address->toArray(),
        ];
    }
}