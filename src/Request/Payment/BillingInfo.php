<?php

namespace App\Request\Payment;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class BillingInfo
{
    #[Assert\NotBlank]
    private string $firstName;

    #[Assert\NotBlank]
    private string $lastName;

    #[Assert\NotBlank]
    #[Assert\Email]
    private string $email;

    #[Assert\NotBlank]
    private string $address;

    #[Assert\NotBlank]
    private string $city;

    #[Assert\NotBlank]
    private string $postalCode;

    #[Assert\NotBlank]
    #[Assert\Country]
    private string $country;

    #[Assert\NotBlank]
    private string $phoneNumber;

    #[Assert\NotBlank]
    private string $administrativeArea;

    public function __construct(Request $request)
    {
        $content = $request->toArray()['billing'];
        $this->firstName = $content['firstName'];
        $this->lastName = $content['lastName'];
        $this->email = $content['email'];
        $this->address = $content['address'];
        $this->city = $content['city'];
        $this->postalCode = $content['postalCode'];
        $this->country = $content['country'];
        $this->phoneNumber = $content['phoneNumber'];
        $this->administrativeArea = $content['administrativeArea'];
    }

    /**
     * Get the value of country.
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * Get the value of postalCode.
     */
    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    /**
     * Get the value of city.
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * Get the value of address.
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * Get the value of email.
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Get the value of lastName.
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * Get the value of firstName.
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * Get the value of phoneNumber.
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * Get the value of administrativeArea.
     */
    public function getAdministrativeArea(): string
    {
        return $this->administrativeArea;
    }
}
