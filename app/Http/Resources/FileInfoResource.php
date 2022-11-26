<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\FileInfo */
class FileInfoResource extends JsonResource
{
    /**
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'parent' => new FileInfoResource($this->whenLoaded('parent')),
            'type' => $this->type,
            'name' => $this->name,
            'created_at' => $this->created_at,

            'children' => FileInfoResource::collection($this->whenLoaded('children')),
        ];
    }
}
