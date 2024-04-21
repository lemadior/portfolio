<?php

namespace App\Http\Resources\Api\V1\Faux;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class StudentsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $course = $this->resource['course'];
        $students = $this->resource['students'];
        $perPage = $this->resource['limit'];

        $pagination = $this->preparePagination($students->toArray(), $course->id, $perPage) ?? [];

        return [
            'students' => $this->getCourseStudentsData($students),
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
     * @param int $courseId
     *
     * @return array
     */
    protected function preparePagination(array $rawPagination, int $courseId, int $perPage = 0): array
    {
        if (!$perPage || $perPage < 0) {
            return [];
        }

        $pagination = $rawPagination;
        unset($pagination['data']);

        $perPage = $pagination['per_page'];

        $missedPart = '&course=' . $courseId . '&limit=' . $perPage;

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
     * Prepare students data from $students collection retrieved for specified course
     *
     * @param Collection | LengthAwarePaginator $students
     *
     * @return array
     */
    protected function getCourseStudentsData(Collection | LengthAwarePaginator $students): array
    {
        $courseStudents = [];

        foreach ($students as $student) {
            $courseStudents[] = [
                'id' => $student->id,
                'name' => $student->first_name . " " . $student->last_name,
                'group' => $student->group ? $student->group->name : 'NONE'
            ];
        }

        return $courseStudents;
    }
}
