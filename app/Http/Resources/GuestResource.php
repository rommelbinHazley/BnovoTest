<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $email
 * @property string $country
 * @property string $phone
 */
class GuestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'fullName' => $this->name.' '.$this->surname,
            'email' => $this->email,
            'country' => $this->country,
            'phone' => $this->phone,
        ];
    }
}
