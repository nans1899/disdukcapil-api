<?php

namespace App\Http\Resources;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id'                   => $this->id,
            'name'                 => $this->name,
            'email'                => $this->email,
            'username'             => $this->username,
            'foto'                 => $this->foto == null ? config('app.url') . '/storage/users/user.png' :  env('DUK_HOST_API') . '/storage/users/' . $this->id . '/' . $this->foto,
            'whatsapp'             => $this->whatsapp,
            'slack'                => $this->slack,
            'role_id'              => $this->roles->name,
        ];
    }
}
