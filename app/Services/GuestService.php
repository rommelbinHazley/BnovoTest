<?php

namespace App\Services;

use App\Facades\PhoneNumberFacade;
use App\Http\DTO\Guest\GuestId;
use App\Http\DTO\Guest\StoreGuest;
use App\Http\DTO\Guest\UpdateGuest;
use App\Models\Guest;
use libphonenumber\PhoneNumber;
use libphonenumber\ShortNumberInfo;

class GuestService implements IGuestService
{
    public function store(StoreGuest $guestData): GuestId
    {
        $guest = new Guest;

        $this->fillModel($guest, $guestData);

        $guest->save();

        return GuestId::from($guest);
    }

    public function update(Guest $guest, UpdateGuest $guestData): GuestId
    {
        $this->fillModel($guest, $guestData);

        $guest->update();

        return GuestId::from($guest);
    }

    public function delete(Guest $guest): void
    {
        $guest->delete();
    }

    private function fillModel(Guest $guest, StoreGuest|UpdateGuest $guestData): void
    {
        $guest->setAttribute('name', $guestData->name);
        $guest->setAttribute('surname', $guestData->surname);
        $guest->setAttribute('email', $guestData->email);
        $guest->setAttribute('phone', $this->getPhoneNumberForDB($guestData->phone));
        $guest->setAttribute('country', $this->getCountryForDB($guestData->country, $guestData->phone));
    }

    private function getPhoneNumberForDB(PhoneNumber $phone): string
    {
        return '+'.$phone->getCountryCode().$phone->getNationalNumber();
    }

    private function getCountryForDB(?string $country, PhoneNumber $phone): string
    {
        if ($country) {
            return $country;
        }

        return $this->getCountryISOCode($phone);
    }

    /**
     * Получение страны по коду номера телефона.
     */
    private function getCountryISOCode(PhoneNumber $phone): string
    {
        $regionCodes = [];

        foreach (ShortNumberInfo::getInstance()->getSupportedRegions() as $region) {
            $regionCodes[PhoneNumberFacade::getCountryCodeForRegion($region)] = $region;
        }

        return $regionCodes[$phone->getCountryCode()];
    }
}
