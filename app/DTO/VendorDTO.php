<?php

namespace App\DTO;

class VendorDTO
{
    public string $vendor_code;
    public string $name;
    public ?string $phone;
    public ?string $email;
    public ?string $address;
    public ?string $contact_person;
    public ?string $npwp;
    public ?string $certification;
    public bool $is_active;

    public function __construct(array $data)
    {
        $this->vendor_code = $data['vendor_code'];
        $this->name = $data['name'];
        $this->phone = $data['phone'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->address = $data['address'] ?? null;
        $this->contact_person = $data['contact_person'] ?? null;
        $this->npwp = $data['npwp'] ?? null;
        $this->certification = $data['certification'] ?? null;
        $this->is_active = (bool) ($data['is_active'] ?? true);
    }

    public function toArray(): array
    {
        return [
            'vendor_code' => $this->vendor_code,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'contact_person' => $this->contact_person,
            'npwp' => $this->npwp,
            'certification' => $this->certification,
            'is_active' => $this->is_active,
        ];
    }
}
