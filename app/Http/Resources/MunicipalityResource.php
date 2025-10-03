<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MunicipalityResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'ibge_code' => $this->ibge_code,
            'siafi_code' => $this->siafi_code,
            'state' => StateResource::make($this->whenLoaded('state')),
        ];
    }
}
