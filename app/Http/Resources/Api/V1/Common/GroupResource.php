<?php

namespace App\Http\Resources\Api\V1\Common;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class GroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $group = $this->resource['group'];

        $students = $this->resource['students'];

        $pagination = $this->preparePagination($students->toArray());

        return [
            'name' => $group->name,
            'students' => $this->getGroupStudentsData($students),
            'pagination' => $pagination
        ];
    }

     /**
     * Prepare pagination data:
     *  - to get more convenient format;
     *  - to modify pages URL for properly values
     *  - to remove unneeded records
     *
     * @param array $rawPagination
     *
     * @return array
     */
    protected function preparePagination(array $rawPagination): array
    {
        $pagination = $rawPagination;

        if (!isset($pagination['per_page'])) {
            return [];
        }

        unset($pagination['data']);

        $perPage = $pagination['per_page'];

        $missedPart = '?limit=' . $perPage;

        $pagination['first_page_url'] .= $missedPart;
        $pagination['last_page_url'] .= $missedPart;

        $pagination['next_page_url'] = $pagination['next_page_url']
            ? $pagination['next_page_url'] . $missedPart
            : null;

        $pagination['prev_page_url'] = $pagination['prev_page_url']
            ? $pagination['prev_page_url'] . $missedPart
            : null;

        $links = [];

        foreach ($pagination['links'] as $link) {
            if ($link['url']) {
                $link['url'] .= $missedPart;
            }

            $links[] = $link;
        }

        $pagination['links'] = $links;

        return $pagination;
    }

    /**
     * Prepare students data from $students collection retrieved for this group
     *
     * @param Collection | LengthAwarePaginator $students
     *
     * @return array
     */
    protected function getGroupStudentsData(Collection | LengthAwarePaginator $students): array
    {
        $studentsData = [];

        foreach ($students as $student) {
            $courses = $student->courses;

            $courseNames = [];

            foreach ($courses as $course) {
                $courseNames[] = $course->name;
            }

            $studentsData[] = [
                'id' => $student->id,
                'name' => $student->first_name . " " . $student->last_name,
                'courses' => $courseNames
            ];
        }

        return $studentsData;
    }
}
