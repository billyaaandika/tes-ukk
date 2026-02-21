@extends('layouts.app')

@section('title', 'Edit Data Pengembalian')

@section('content')

<style>
.table-bordered>:not(caption)>*>* {
    border-width: 1px !important;
}
</style>

<div class="container mt-5">

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
            <h4 class="mb-0 fw-bold text-white">Edit Data Pengembalian</h4>
        </div>

        <div class="card-body">

            <form action="{{ route('admin.returns.update', $return->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-bold">ID Peminjaman</label>
                    <select name="borrowing_id" class="form-control">
                        @foreach($borrowings as $borrowing)
                            <option value="{{ $borrowing->id }}"
                                {{ $return->borrowing_id == $borrowing->id ? 'selected' : '' }}>
                                {{ $borrowing->id }} - {{ $borrowing->user->name ?? '-' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Tanggal Pengembalian</label>
                    <input type="date" name="returned_at" class="form-control"
                        value="{{ $return->returned_at }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Denda (Rp)</label>
                    <input type="number" name="fine_amount" class="form-control"
                        value="{{ $return->fine_amount }}">
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.returns.index') }}" class="btn btn-secondary">
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
