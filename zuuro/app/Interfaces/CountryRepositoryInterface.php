<?php

namespace App\Interfaces;

Interface CountryRepositoryInterface
{
    public function getAllCountries();

    public function getCountryById($CountryId);

    public function deleteCountry($CountryId);

    public function createCountry(array $CountryDetails);

    public function updateCountry($CountryId, array $newDetails);
    
    public function getLoanCountries();

    public function getPhoneCode($countryIso);

    public function CountryByStatus();
}

