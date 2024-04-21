<?php

namespace App\Http\Resources\Api\V1\Common;

use App\Services\Resources\Api\V1\Common\StudentService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class StudentResource extends JsonResource
{
    /**
     * @var StudentService $service
     */
    private StudentService $service;

    public function __construct($resource)
    {
        parent::__construct($resource);

        $this->service = new StudentService();
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->service->getStudentData($this->resource);
    }
}
