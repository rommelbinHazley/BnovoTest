<?php

namespace App\Http\DTO\Casts;

use App\Facades\PhoneNumberFacade;
use App\Http\DTO\Guest\StoreGuest;
use App\Http\DTO\Guest\UpdateGuest;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\DataProperty;

class PhoneCast implements Cast
{
    /**
     * @param  array<mixed>  $properties
     * @param  CreationContext<StoreGuest|UpdateGuest>  $context
     */
    public function cast(DataProperty $property, mixed $value, array $properties, CreationContext $context): mixed
    {
        return PhoneNumberFacade::parse($value);
    }
}
