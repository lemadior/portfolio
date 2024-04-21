@php($page = 'register')
@extends('layouts.main')
@section('title', 'FauxEd: Dashboard register')
@section('content')

<main class="main">
    <div class="container">

        <div class="login">
            <img src="{{ asset('assets/images/FAUX_long.png') }}" alt="logo">
            <div class="login__form">

                <form name='register' method='post'>
                    @csrf

                    <input type='text' name='name' placeholder="Your name" value="{{ old('name') }}"/>
                    <x-faux.error error='name' />

                    <input type='email' name='email' placeholder="Your Email" value="{{ old('email') }}"/>
                    <x-faux.error error='email' />

                    <input type='password' name='password' placeholder="Type passwd here" />
                    <x-faux.error error='password' />

                    <input type='password' name='confirm' placeholder="Type passwd for confirm" />
                    <x-faux.error error='confirm' />

                    <input type='submit' value='REGISTER' />
                </form>
            </div>

            <div class="login_underline">
                <p class="login_from_register">
                    <span>Already registered?</span>
                    <a href="{{ route('auth.login') }}">Login</a>
                </p>
            </div>
        </div>
    </div>
</main>
@endsection
