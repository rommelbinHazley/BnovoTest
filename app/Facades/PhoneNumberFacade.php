<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberUtil;

/**
 * @method static PhoneNumber parse($numberToParse, $defaultRegion = null, $phoneNumber = null, $keepRawInput = false)
 * @method static string getCountryCodeForRegion(string $region)
 *
 * @see PhoneNumberUtil
 */
class PhoneNumberFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'libphonenumber';
    }
}
