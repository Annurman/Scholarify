@extends('layouts.app')
@section('title', $akun->exists ? 'Ubah Akun Staf' : 'Tambah Akun Staf')
@section('content')
    <div class="page-head">
        <div>
            <h1>{{ $akun->exists ? 'Ubah Akun Staf' : 'Tambah Akun Staf' }}</h1>
            <p>Buat akun khusus untuk Admin penyelenggara atau Mentor pembinaan.</p>
        </div>
    </div>

    <form method="POST" class="card" style="max-width:620px" action="{{ $akun->exists ? route('admin.akun.update', $akun) : route('admin.akun.store') }}">
        @csrf
        @if($akun->exists) @method('PUT') @endif

        <div class="form-group">
            <label for="name">Nama lengkap</label>
            <input id="name" name="name" class="form-control" value="{{ old('name', $akun->name) }}" required maxlength="100">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" class="form-control" value="{{ old('email', $akun->email) }}" required maxlength="100">
        </div>

        <div class="form-group">
            <label for="role">Role akun</label>
            @if($akun->exists && $akun->id === auth()->id())
                <input type="hidden" name="role" value="{{ $akun->role }}">
                <select id="role" class="form-control" disabled>
                    <option value="admin" @selected($akun->role === 'admin')>Admin — Penyelenggara Beasiswa</option>
                    <option value="mentor" @selected($akun->role === 'mentor')>Mentor — Monitoring Peserta</option>
                </select>
                <div class="hint">Role akun yang sedang digunakan tidak dapat diubah sendiri.</div>
            @else
                <select id="role" name="role" class="form-control" required>
                    <option value="admin" @selected(old('role', $akun->role) === 'admin')>Admin — Penyelenggara Beasiswa</option>
                    <option value="mentor" @selected(old('role', $akun->role) === 'mentor')>Mentor — Monitoring Peserta</option>
                </select>
                <div class="hint">Admin mengelola program dan penerimaan. Mentor hanya mengakses kelompok binaannya.</div>
            @endif
        </div>

        <div class="form-group">
            <label for="password">Kata sandi {{ $akun->exists ? '(kosongkan jika tidak diubah)' : '' }}</label>
            <input id="password" type="password" name="password" class="form-control" {{ $akun->exists ? '' : 'required' }} minlength="8" autocomplete="new-password">
            <div class="hint">Minimal 8 karakter.</div>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Ulangi kata sandi</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" {{ $akun->exists ? '' : 'required' }} minlength="8" autocomplete="new-password">
        </div>

        <label class="check" style="margin-bottom:1.2rem">
            @if($akun->exists && $akun->id === auth()->id())
                <input type="hidden" name="is_active" value="1">
                <input type="checkbox" checked disabled>
                Akun aktif (status akun sendiri tidak dapat diubah)
            @else
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $akun->is_active))>
                Akun aktif
            @endif
        </label>

        <div class="actions">
            <button class="btn" type="submit">Simpan akun</button>
            <a class="btn btn-ghost" href="{{ route('admin.akun.index') }}">Batal</a>
        </div>
    </form>
@endsection
