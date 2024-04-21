<?php

namespace App\Services\Resources\Api\V1\Admin\Faux;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Exception;

class StudentsService
{
    /**
     * Prepare data for Admin Faux Students resource request from API
     *
     * @param Request $request
     * @param mixed $resource
     *
     * @return array
     */
    public function getStudentsData(Request $request, mixed $resource): array
    {
        $perPage = $request->limit;

        $studentsBuilder = $resource;

        if (!$studentsBuilder) {
            throw new Exception('Students data cannot be retrieved');
        }

        $pagination = [];

        if ($perPage) {
            $students = $studentsBuilder->paginate($perPage);
            $pagination = $this->preparePagination($students->toArray());
        } else {
            $students = $studentsBuilder->get();
        }

        return [
            'students' => $this->getAllStudentsData($students),
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
    protected function preparePagination(array $rawPagination): array
    {
        $pagination = $rawPagination;
        unset($pagination['data']);

        $perPage = $pagination['per_page'];

        $missedPart = '&limit=' . $perPage;

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
     * Prepare students data from $students collection retrieved for main Admin students page
     *
     * @param Collection | LengthAwarePaginator $students
     *
     * @return array
     */
    protected function getAllStudentsData(Collection | LengthAwarePaginator $students): array
    {
        $studentsData = [];

        foreach ($students as $student) {
            $courses = [];

            foreach ($student->courses as $course) {
                $courses[] = $course->name;
            }

            $studentsData[] = [
                'id' => $student->id,
                'name' => $student->first_name . " " . $student->last_name,
                'group' => $student->group ? $student->group->name : 'NONE',
                'courses' => $courses
            ];
        }

        return $studentsData;
    }
}
