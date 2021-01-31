<?php

namespace App\Http\Resources\comment;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResourse2 extends JsonResource
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
            'comment' => $this->comment,
            'post' => new PostResourse2($this->post)
        ];
    }
}
