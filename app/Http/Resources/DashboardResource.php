<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DashboardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // foreach($this->data as $dashboardhome) {
        //     if($dashboardhome->type_id == 1){
        //         foreach ($dashboardhome->images->sortBy('no') as $image) {
        //             return parent::toArray($image);
        //         }
        //     }
        // }
        // return parent::toArray($request);
        // return [
        //     'id' => $this->id,
        // ];

        if($this->type_id == 1) {

            return [
                'id'=> $this->id,
                'name'=> $this->name,
                'type_id'=> $this->type_id,
                'hidden'=> $this->hidden,
                'no'=> $this->no,
                'images'=> ImagesDashboardResource::collection($this->images),
            ];
        }

    }
}
