<?php

namespace App\Services;

use App\Http\DTO\Guest\GuestId as GuestId;
use App\Http\DTO\Guest\StoreGuest;
use App\Http\DTO\Guest\UpdateGuest;
use App\Models\Guest;

interface IGuestService
{
    public function store(StoreGuest $guestData): GuestId;

    public function update(Guest $guest, UpdateGuest $guestData): GuestId;

    public function delete(Guest $guest): void;
}
