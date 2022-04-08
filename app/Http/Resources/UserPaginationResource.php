<?php

namespace App\Http\Resources;

use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserPaginationResource extends JsonResource
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
            'data'              => UserResource::collection($this->items()),
            'next_page_url'     => $this->nextPageUrl(),
            'previous_page_url' => $this->previousPageUrl(),
            'current_page'      => $this->currentPage(),
            'last_page'         => $this->lastPage(),
            'per_page'          => $this->perPage(),
            'from'              => $this->firstItem(),
            'to'                => $this->lastItem(),
            'total'             => $this->total(),
            'has_pages'         => $this->hasMorePages()
        ];
    }
}
