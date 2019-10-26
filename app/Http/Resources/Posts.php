<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Posts extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'title' => $this->title,
            'sub_title' => $this->sub_title,
            'slug_title' => $this->slug_title,
            'tags' => $this->posttags,
            'category' => $this->category,
            'photo' => $this->photo,
            'content' => $this->content,
            'status' => $this->status,
            'tags_id' => $this->posttags->pluck('tag_id')->toArray(),
        ];
    }
}
