<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'stock_quantity' => $this->stock_quantity,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
