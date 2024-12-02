<?php

namespace App\Http\DTO\Guest;

use App\Http\DTO\Casts\PhoneCast;
use libphonenumber\PhoneNumber;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;

class StoreGuest extends Data
{
    public function __construct(
        public ?int $id,
        public string $name,
        public string $surname,
        public string $email,
        #[WithCast(PhoneCast::class)]
        public PhoneNumber $phone,
        public ?string $country,
    ) {}
}
