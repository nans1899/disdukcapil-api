<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MenusResource extends JsonResource
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

            # code...
            return [
                'id'        => $this->id,
                'parent_id' => $this->parent_id,
                'site_id'   => $this->site_id,
                'urlview'   => $this->urlview,
                'value'     => $this->value,
                'name'      => $this->name,
                'hide'      => $this->hide,
                'has_child' => empty($this->childs->toArray()) ? 0 : 1,
                'icon'      => $this->icon,
            ];
    }
}
