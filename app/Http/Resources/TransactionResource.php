<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'category' => $this->category,
            'payee' => $this->payee,
            'amount' => $this->amount,
            'account' => $this->account,
            'notes' => $this->notes,
        ];
    }
}
