
@extends('layouts.guest')

@section('title', 'Masuk')

@section('content')

<style>
    .password-wrapper {
        position: relative;
    }

    .password-wrapper .form-control {
        padding-right: 45px;
    }

    .toggle-password {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        border: none;
        background: transparent;
        cursor: pointer;
        color: #777;
        padding: 5px;
    }

    .toggle-password:hover {
        color: #333;
    }
</style>

<h1>Masuk</h1>
<p class="muted">Gunakan akun yang sudah terdaftar.</p>

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="form-group">
        <label for="email">Email</label>
        <input
            id="email"
            type="email"
            name="email"
            class="form-control"
            value="{{ old('email') }}"
            required
            autofocus
        >
    </div>

    <div class="form-group">
        <label for="password">Kata sandi</label>

        <div class="password-wrapper">
            <input
                id="password"
                type="password"
                name="password"
                class="form-control"
                required
            >

            <button
    type="button"
    id="togglePassword"
    class="toggle-password"
    aria-label="Tampilkan kata sandi"
    aria-pressed="false"
>
    <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg"
        width="20" height="20" viewBox="0 0 24 24"
        fill="none" stroke="currentColor"
        stroke-width="2" stroke-linecap="round"
        stroke-linejoin="round">
        <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7-10-7-10-7z"/>
        <circle cx="12" cy="12" r="3"/>
    </svg>
</button>
        </div>
    </div>

    <label class="check" style="margin-bottom: 1.1rem">
        <input type="checkbox" name="remember">
        Ingat saya
    </label>

    <button class="btn btn-block" type="submit">
        Masuk
    </button>
</form>

<p style="margin-top: 1.25rem" class="muted">
    Belum punya akun?
    <a href="{{ route('register') }}">Daftar sebagai mahasiswa</a>
</p>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const passwordInput = document.getElementById('password');
        const togglePassword = document.getElementById('togglePassword');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePassword.addEventListener('click', function () {
            const isPassword = passwordInput.type === 'password';

            passwordInput.type = isPassword ? 'text' : 'password';

            eyeIcon.innerHTML = isPassword
                ? `
                    <path d="M3 3l18 18"/>
                    <path d="M10.6 10.6a2 2 0 0 0 2.8 2.8"/>
                    <path d="M9.9 5.2A10.8 10.8 0 0 1 12 5c6.4 0 10 7 10 7a15.5 15.5 0 0 1-3.1 3.9"/>
                    <path d="M6.6 6.6C3.7 8.5 2 12 2 12s3.6 7 10 7a10 10 0 0 0 3.4-.6"/>
                  `
                : `
                    <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7-10-7-10-7z"/>
                    <circle cx="12" cy="12" r="3"/>
                  `;

            this.setAttribute('aria-pressed', isPassword);
            this.setAttribute(
                'aria-label',
                isPassword ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'
            );
        });
    });
</script>

@endsection
