@php($page = 'students')
@extends('layouts.main')
@section('title', 'FauxEd: find students')
@php($courseName = $studentsData['courseName'] ?? 'Select Course')
@section('content')
<main class="main">
    <div class="container">
        <div class="page__heading">
            Find all students related to the course with a given name
        </div>

        <div class="filter_form">
            <form name='groups_form' id="groups_form" action="{{ route('faux.students.post') }}" method='post'>
                @csrf

                <select name='course'>
                    @foreach($studentsData['courses'] as $course)
                    <option @selected(old('course')===$course || $course===$courseName) {{ $course === 'Select Course' ? "disabled" : "" }} value="{{ $course }}">{{ $course }}</option>
                    @endforeach
                </select>

                <div class="per_page">
                    <label for="per_page">Count per Page</label>
                    <select name="per_page" id="per_page">
                        <option value="5" @selected($studentsData['studentsPerPage'] == 5)>5</option>
                        <option value="10" @selected($studentsData['studentsPerPage'] == 10)>10</option>
                        <option value="15" @selected($studentsData['studentsPerPage'] == 15)>15</option>
                        <option value="20" @selected($studentsData['studentsPerPage'] == 20)>20</option>
                    </select>
                </div>

                <input type='submit' value='SHOW' class="button" />
            </form>

        </div>

        <div class="page__text">
            <div class="caption">Founded students</div>

            <table class="mytable table-striped">

                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Student Name</th>
                        <th>Group</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($studentsData['students'])
                    @foreach($studentsData['students']->items() as $student)
                    <tr>
                        <td>{{ $student->student_id }}</td>
                        <td><a href="{{ route('faux.show', $student->student_id) }}">{{ $student->first_name . " " . $student->last_name }}</a></td>
                        <td><a href="{{ $student->group ? route('faux.group', $student->group->id) : '#' }}">{{ $student->group ? $student->group->name : 'NONE' }}</a></td>
                    </tr>
                    @endforeach
                    @endisset
                </tbody>
                </table>

                <div class="paginate_space">
                    {{ $studentsData['students']->appends(['course' => $courseName, 'per_page' => $studentsData['studentsPerPage']])->links() }}
                </div>
        </div>
    </div>

</main>

<script src="{{ asset('assets/js/paginate.js') }}"></script>

@endsection
