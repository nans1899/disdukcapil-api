<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
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

        $rolesStr = '';
        foreach ($this->roles as $role ) {
            $rolesStr .= $role->name;
            if ($this->roles->last() != $role) {
                # code...
                $rolesStr .= ', ' ;
            }
        }

        return [
            'id'            => $this->id,
            'parent_id'     => $this->parent_id,
            'site_id'       => $this->site_id,
            'value'         => $this->value,
            'name'          => $this->name,
            'ref'           => $this->ref,
            'url'           => $this->url,
            'urlview'       => $this->urlview,
            'no'            => $this->no,
            'hide'          => $this->hide,
            'icon'          => $this->icon,
            // 'roles'         => RolesResource::collection($this->roles) ,
            'roles'         => $rolesStr,
        ] ;
    }
}
