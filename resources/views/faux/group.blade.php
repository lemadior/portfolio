@php($page = 'group')
@extends('layouts.main')
@section('title', 'FauxEd: Group Page')
@section('content')
<main class="main">
    <div class="container">
        <div class="page__heading">
            <h5>Group: <span><em>{{ $group->name }}</em></span></h5>
        </div>

        <div class="per_page per_page_right">
            <form name='groups_form' id="groups_form" action="{{ route('faux.group', $group->id) }}" method='get'>
                @csrf
                <label for="per_page">Count per Page</label>
                <select name="per_page" id="per_page">
                    <option value="5" @selected($studentsPerPage==5)>5</option>
                    <option value="10" @selected($studentsPerPage==10)>10</option>
                    <option value="15" @selected($studentsPerPage==15)>15</option>
                    <option value="20" @selected($studentsPerPage==20)>20</option>
                </select>


                <input type='submit' value='SHOW' class="button" hidden />
            </form>
        </div>

        <div class="page__text">
            <table class="mytable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Student Name</th>
                        <th>Course</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                    <tr>
                        <td>{{ $student->id }}</td>
                        <td><a href="{{ route('faux.show', $student->id) }}">{{ $student->first_name . " " . $student->last_name }}</a></td>
                        <td>
                            @foreach($student->courses as $course)
                            <p><a href="{{ route('faux.course', $course->id) }}">{{ $course->name }}</a></p>
                            @endforeach
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="paginate_space">
                {{ $students->appends(['per_page' => $studentsPerPage])->links() }}
            </div>
        </div>
    </div>

</main>

<script src="{{ asset('assets/js/paginate.js') }}"></script>

@endsection
