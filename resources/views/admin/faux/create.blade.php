@php($page = 'create')
@extends('layouts.main')
@section('title', 'FauxEd: Admin Dashboard: Create')
@section('content')
<main class="main">
    <div class="container">
        <div class="page__heading">
            <h5>Dashboard: Add New Student</h5>
        </div>

        <div class="page__text flex_row">
            <div class="avatar">
                <img src="{{ asset('assets/images/profile.png') }}" height=110px alt="My Morda">
            </div>
            <div class="student__data flex-column">
                <form name='groups_form' action="{{ route('admin.faux.store') }}" method='post' class="student__form">
                    @csrf

                    <div class="add_group">
                        <p>Select Group</p>
                        <select name='group_id'>
                            <option value="{{ null }}" selected disabled>NONE</option>
                            @foreach($groups as $group)
                            <option value="{{ $group->id }}" @selected(old('group_id') == $group->id)>{{ $group->name }}</option>
                            @endforeach
                        </select>

                        <p class="note"><em><strong>Note:</strong> group cannot be edited afterwards</em></p>
                    </div>

                    <input type='text' name='first_name' placeholder="First Name" value="{{ old('first_name') }}" />
                    <x-faux.error error='first_name' />

                    <input type='text' name='last_name' placeholder="Last Name" value="{{ old('last_name') }}" />
                    <x-faux.error error='last_name' />

                    <p class="select_course">Select Course</p>
                    <select name='course_ids[]' multiple>
                        @foreach($courses as $course)
                        <option
                            value="{{ $course->id }}"
                            @selected(is_array(old('course_ids')) && in_array($course->id, old('course_ids')))
                        >
                            {{ $course->name }}
                        </option>
                        @endforeach
                    </select>
                    <p class="select_note">Hold down the Ctrl (windows) or Command (Mac) button to select multiple options.</p>
                    <x-faux.error error='course_ids' />

                    <input type='submit' value='Apply' class="button button_apply" />
                </form>
            </div>
        </div>
    </div>

</main>
@endsection
