@extends('layouts.app')

@section('title', 'Edit Data Peminjaman')

@section('content')

<style>
    .table-bordered>:not(caption)>*>* {
        border-width: 1px !important;
    }
</style>

<div class="container mt-5">

    {{-- NOTIFIKASI --}}
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card shadow border-0">
        <div class="card-header bg-dark">
            <h4 class="mb-0 fw-bold text-white">Edit Data Peminjaman</h4>
        </div>

        <div class="card-body">

            <form action="{{ route('admin.borrowings.update', $borrowing->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Peminjam</label>
                    <select name="user_id" class="form-control">
                        @foreach($users as $user)
                        <option value="{{ $user->id }}"
                            {{ $borrowing->user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Alat</label>
                    <select name="tool_id" class="form-control">
                        @foreach($tools as $tool)
                        <option value="{{ $tool->id }}"
                            {{ $borrowing->tool_id == $tool->id ? 'selected' : '' }}>
                            {{ $tool->name_tool }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Tanggal Peminjaman</label>
                    <input type="date" name="borrowed_at" class="form-control"
                        value="{{ $borrowing->borrowed_at }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Tanggal Pengembalian</label>
                    <input type="date" name="return_at" class="form-control"
                        value="{{ $borrowing->return_at }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Status</label>
                    <select name="status" class="form-control">
                        <option value="pending" {{ $borrowing->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ $borrowing->status == 'approved' ? 'selected' : '' }}>Disetujui</option>
                        <option value="rejected" {{ $borrowing->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.borrowings.index') }}" class="btn btn-secondary">
                        Kembali
                    </a>

                    <button type="submit" class="btn btn-warning text-white">
                        Update Data
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection