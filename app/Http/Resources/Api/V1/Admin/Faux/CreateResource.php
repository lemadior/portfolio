<?php

namespace App\Http\Resources\Api\V1\Admin\Faux;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class CreateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $student = $this->resource;

        return [
            'id' => $student->id,
            'group_id' => $student->group_id,
            'first_name' => $student->first_name,
            'last_name' => $student->last_name,
            'course_ids' => $student->courses->pluck('id')->toArray()
        ];
    }
}
