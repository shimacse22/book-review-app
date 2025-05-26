<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'author'        => $this->author,
            'description'   => $this->description,
            'cover_image'         => $this->cover_image,
            'rating'        => round($this->reviews->avg('rating'), 1) ?? 0,
            'reviews_count' => $this->reviews->count(),
            'reviews'       => ReviewResource::collection($this->whenLoaded('reviews')),
        ];
    }
}
