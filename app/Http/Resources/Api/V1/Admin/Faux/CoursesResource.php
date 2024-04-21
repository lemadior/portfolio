<?php

namespace App\Http\Resources\Api\V1\Admin\Faux;

use App\Services\Resources\Api\V1\Admin\Faux\CoursesService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class CoursesResource extends JsonResource
{
    private CoursesService $service;

    public function __construct($resource)
    {
        parent::__construct($resource);

        $this->service = new CoursesService();
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->service->getCoursesData($this->resource);
    }
}
