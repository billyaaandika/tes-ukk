@extends('layouts.app')

@section('title', 'Edit User')

@section('content')


<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white fw-bold">
            Edit User
        </div>

        <div class="card-body">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <label class="mt-3">Nama Pegawai</label>
                <input type="text" name="name" class="form-control border border-dark" value="{{ $user->name }}" required>
                @error('name')
                <div class="text-danger">{{ $message }}</div>
                @enderror

                <label class="mt-3">Email</label>
                <input type="email" name="email" class="form-control border border-dark" value="{{ $user->email }}" required>
                @error('email')
                <div class="text-danger">{{ $message }}</div>
                @enderror

               <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select border border-dark" required>
                        <option value="">Pilih Role</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="officer" {{ old('role') == 'officer' ? 'selected' : '' }}>Officer</option>
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                    </select>
                    @error('role')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <label class="mt-3">Password</label>
                <input type="password" name="password" class="form-control border border-dark" placeholder="Masukan Password Baru (Opsional)">
                @error('password')
                <div class="text-danger">{{ $message }}</div>
                @enderror

                <button type="submit" class="btn btn-warning mt-4">Update</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mt-4">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection