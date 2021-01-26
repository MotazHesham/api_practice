<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserCommentResource extends JsonResource
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
            'comment' => $this->pivot->comment,
            'user' => [
                'full_name' => $this->first_name . ' ' . $this->last_name,
                'email' => $this->email,
            ]
        ];
    }
}
