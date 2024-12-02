<?php

namespace App\Http\DTO\Guest;

use Spatie\LaravelData\Data;

class GuestId extends Data
{
    public function __construct(
        public ?int $id,
    ) {}
}
