@php($page = 'login')
@extends('layouts.main')
@section('title', 'FauxEd: Dashboard login')
@section('content')
<main class="main">
    <div class="container">

        <div class="login">
            <img src="{{ asset('assets/images/FAUX_long.png') }}" alt="logo">
            <div class="login__form">

                <form name='login' method='post'>
                    @csrf

                    <input type='email' name='email' placeholder="Email address" value="{{ old('email') }}"/>
                    <x-faux.error error='email' />

                    <input type='password' name='password' placeholder="Type password here" />
                    <x-faux.error error='password' />

                    <input type='submit' value='LOGIN' />
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
