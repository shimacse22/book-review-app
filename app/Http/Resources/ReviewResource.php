<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'     => $this->id,
            'user'   => [
                'id'   => $this->user->id ?? null,
                'name' => $this->user->name ?? 'Anonymous',
            ],
            'rating' => $this->rating,
            'review' => $this->review,
            'book_id' => $this->book_id,
        ];
    }
}
