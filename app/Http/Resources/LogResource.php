<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LogResource extends JsonResource
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
            'id'             => $this->id,
            'username'       => $this->username,
            'activity'       => $this->activity,
            'module'         => $this->module,
            'url'            => $this->url,
            'from'           => $this->from,
            'created_at'     => $this->created_at->format('d F Y h:i:s A'),
        ] ;
    }
}
