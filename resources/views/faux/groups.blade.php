@php($page = 'groups')
@extends('layouts.main')
@section('title', 'FauxEd: find groups')
@section('content')
<main class="main">
    <div class="container">
        <div class="page__heading">
            Find all groups with less or equals student count
        </div>
        <div class="filter_form">
            <form name='groups_form' action="{{ route('faux.groups.post') }}" method='post'>
                @csrf

                <input type='number' name='amount' placeholder="Users amount" value="{{ $groupsData['amount'] ?? 0 }}"/>
                <input type='submit' value='SHOW' class="button" />
            </form>
        </div>

        <div class="page__text">
            <div class="caption">Founded groups</div>
            <table class="mytable table-striped">
                <thead>
                    <tr>
                        <th>Group ID</th>
                        <th>Name</th>
                        <th>Students Count</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($groupsData['groups'])
                        @foreach($groupsData['groups'] as $group)
                        <tr>
                            <td>{{ $group->id }}</td>
                            <td><a href="{{ route('faux.group', $group->id) }}">{{ $group->name }}</a></td>
                            <td>{{ $group->students()->count() }}</td>
                        </tr>
                        @endforeach
                    @endisset
                </tbody>
            </table>
        </div>
    </div>

</main>
@endsection
