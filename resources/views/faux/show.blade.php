@php($page = 'show')

@extends('layouts.main')

@section('title', 'FauxEd: Admin Dashboard: Show')

@section('content')
<main class="main">
    <div class="container">
        <div class="page__heading">
            <h5>Student: <span><em>{{ $student->first_name . " " . $student->last_name }}</em></span><h5>
        </div>

        <div class="page__text flex_row">
            <div class="avatar">
                <img src="{{ asset('assets/images/profile.png') }}" height=110px alt="My Morda">
            </div>
            <div class="student__data flex-column">
                <p class="group">
                    <a href="{{ $student->group ? route('faux.group', $student->group->id) : '#' }}">{{ $student->group ? $student->group->name : 'NONE' }}</a>
                </p>
                <table class="mytable table-courses">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Courses</th>
                            <!-- <th>Action</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($student->courses as $key => $course)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td><a href="{{ route('faux.course', $course->id) }}">{{ $course->name }}</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @auth
                <div class="buttons">
                    <a href="{{ route('admin.faux.edit', $student->id) }}" class="button">EDIT</a>

                    <form action="{{ route('admin.faux.delete', $student->id) }}" method="post">
                        @csrf
                        @method('delete')

                        <button type="submit" onclick="return confirm('Are You sure to delete this student\'s record?')" class="button">DELETE</button>
                    </form>

                </div>
                @endauth
            </div>
        </div>
    </div>

</main>
@endsection
