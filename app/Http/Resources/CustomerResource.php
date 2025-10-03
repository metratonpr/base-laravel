<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'razao_social' => $this->razao_social,
            'document_type' => $this->document_type,
            'document' => $this->document,
            'ie' => $this->ie,
            'is_ie_isento' => $this->is_ie_isento,
            'logradouro' => $this->logradouro,
            'numero' => $this->numero,
            'complemento' => $this->complemento,
            'bairro' => $this->bairro,
            'cep' => $this->cep,
            'phone' => $this->phone,
            'email' => $this->email,
            'municipality' => MunicipalityResource::make($this->whenLoaded('municipality')),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
