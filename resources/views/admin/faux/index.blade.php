@php($page = 'admin')
@extends('layouts.main')
@section('title', 'FauxEd: Admin Dashboard')
@section('content')
<main class="main">
    <div class="container">
        <div class="page__heading">
            <h5>Dashboard: Students List</h5>
        </div>

        <div class="page__text">

            <a href="{{ route('admin.faux.create') }}"><input type='button' value='Add student' class="button admin_button_add" /></a>

            <div class="per_page">
                <form name='groups_form' id="groups_form" method='get'>
                    @csrf
                    <label for="per_page">Count per Page</label>
                    <select name="per_page" id="per_page">
                        <option value="5" @selected($studentsPerPage == 5)>5</option>
                        <option value="10" @selected($studentsPerPage == 10)>10</option>
                        <option value="15" @selected($studentsPerPage == 15)>15</option>
                        <option value="20" @selected($studentsPerPage == 20)>20</option>
                    </select>


                    <input type='submit' value='SHOW' class="button" hidden />
                </form>
            </div>
            <table class="mytable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Student Name</th>
                        <th>Group Name</th>
                        <th>Course</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($students)
                    @foreach($students as $student)
                    <tr>
                        <td>{{ $student->id }}</td>
                        <td><a href="{{ route('faux.show', $student->id) }}">{{ $student->first_name . " " . $student->last_name }}</a></td>
                        <td><a href="{{ $student->group ? route('faux.group', $student->group_id) : '#' }}">{{ $student->group ? $student->group->name : 'NONE' }}</a></td>
                        <td>
                            @foreach($student->courses as $course)
                            <p><a href="{{ route('faux.course', $course->id) }}">{{ $course->name }}</a></p>
                            @endforeach
                        </td>
                        <td>
                            <div class="table__action">

                                <a href="{{ route('faux.show', $student->id) }}" class="table__action_view">👁</a>

                                <a href="{{ route('admin.faux.edit', $student->id) }}" class="table__action_edit">✎</a>

                                <form action="{{ route('admin.faux.delete', $student->id) }}" method="post">
                                    @csrf
                                    @method('delete')

                                    <button type="submit" onclick="return confirm('Are You sure to delete this student\'s record?')" class="table__action_delete">✖</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @endisset
                </tbody>
            </table>

            @isset($students)
            <div class="paginate_space">
                {{ $students->appends(['per_page' => $studentsPerPage])->links() }}
            </div>
            @endisset
        </div>
    </div>

</main>

<script src="{{ asset('assets/js/paginate.js') }}"></script>

@endsection
