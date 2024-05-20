<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $random_color = '#' . substr(md5(rand()), 0, 6);

        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'start' => $this->start_date,
            'end' => $this->end_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'color' => $random_color,
            'textColor' => 'white',
        ];
    }
}
