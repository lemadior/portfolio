<?php

namespace App\Http\Resources\Api\V1\Admin\Faux;

use App\Services\Resources\Api\V1\Admin\Faux\StudentsService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use Exception;

class StudentsResource extends JsonResource
{
    private StudentsService $service;

    public function __construct($resource)
    {
        parent::__construct($resource);

        $this->service = new StudentsService();
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        try {
            return $this->service->getStudentsData($request, $this->resource);
        } catch (Exception $err) {
            return [
                'status' => 'failed',
                'message' => $err->getMessage()
            ];
        }
    }
}
