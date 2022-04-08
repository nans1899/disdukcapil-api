<?php

namespace App\Http\Resources;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class ImagesDashboardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'foto' => $this->foto == null ? config('app.url') . '/dashboard/img-404.png' : env('DUK_HOST_API') . '/dashboard/'  . $this->foto,
            // 'caption' => $this->caption,
            'imageable_type' => $this->imageable_type,
            // 'imageable_id' => $this->imageable_id,
            'no' => $this->no,
            'url' => $this->url
        ];
    }
}
