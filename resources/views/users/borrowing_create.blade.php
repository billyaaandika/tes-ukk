@extends('layouts.app')

@section('title', 'Ajukan Peminjaman')

@section('content')

<style>
    .table-bordered>:not(caption)>*>* {
        border-width: 1px !important;
    }
</style>

<div class="container mt-5" style="margin-left: 250px;">

    {{-- NOTIFIKASI --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow border-0">
        <div class="card-header bg-dark d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold text-white">📌 Form Peminjaman Alat</h4>
            <a href="{{ route('user.borrowings_list') }}" 
               class="btn btn-light btn-sm text-dark fw-bold">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card-body">

            <form action="{{ route('user.borrowings_store') }}" method="POST">
                @csrf

                {{-- PILIH ALAT --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Alat</label>
                    <select name="tool_id" class="form-control @error('tool_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Alat --</option>
                        @foreach ($tools as $tool)
                            <option value="{{ $tool->id }}" 
                                {{ old('tool_id') == $tool->id ? 'selected' : '' }}>
                                {{ $tool->name_tool }}
                            </option>
                        @endforeach
                    </select>
                    @error('tool_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- TANGGAL PINJAM --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Tanggal Pinjam</label>
                    <input type="date" name="borrowed_at" class="form-control @error('borrowed_at') is-invalid @enderror" value="{{ old('borrowed_at') }}"required>
                    @error('borrowed_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- TANGGAL RENCANA KEMBALI --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Tanggal Rencana Kembali</label>
                    <input type="date" name="return_plan" class="form-control @error('return_plan') is-invalid @enderror"value="{{ old('return_plan') }}"required>
                    @error('return_plan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- KETERANGAN --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Keterangan</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror"rows="3" placeholder="Contoh: Digunakan untuk praktik RPL">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- BUTTON --}}
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success fw-bold">
                        <i class="fas fa-paper-plane"></i> Ajukan Peminjaman
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection