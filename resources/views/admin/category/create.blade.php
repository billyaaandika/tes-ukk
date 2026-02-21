@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
<div class="container mt-4">
    <div class="card shadow border-0">
        <div class="card-header bg-dark d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold text-white">Tambah Kategori</h4>
        </div>

        <div class="card-body">

            {{-- ERROR VALIDASI --}}
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('admin.category.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label>Nama Kategori</label>
                    <input type="text" name="name_category" class="form-control border border-dark" placeholder="Masukan nama kategori" required>
                </div>

                <div class="mb-3">
                    <label>Deskripsi</label>
                    <input type="text" name="description" class="form-control border border-dark" placeholder="Masukan deskripsi kategori" required>

                <button class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.category.index') }}" class="btn btn-secondary">Kembali</a>
            </form>


        </div>
    </div>

</div>
@endsection