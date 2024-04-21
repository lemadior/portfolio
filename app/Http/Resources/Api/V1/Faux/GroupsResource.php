<?php

namespace App\Http\Resources\Api\V1\Faux;

use App\Services\Resources\Api\V1\Faux\GroupsService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class GroupsResource extends JsonResource
{
    /**
     * @var GroupsService $service
     */
    private GroupsService $service;

    public function __construct($resource)
    {
        parent::__construct($resource);

        $this->service = new GroupsService();
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->service->getGroupsData($this->resource);
    }
}
