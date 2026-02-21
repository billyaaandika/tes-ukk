@extends('layouts.app')

@section('title', 'Tambah Alat')

@section('content')
<div class="container mt-4">
    <div class="card shadow border-0">
        <div class="card-header bg-dark d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold text-white">Tambah User</h4>
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

            <form action="{{ route('admin.tools.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" name="name_tool" class="form-control border border-dark" placeholder="Masukan name tool" required>
                </div>
                <div class="mb-3">
                    <label>Kategori</label>
                    <select name="category_tool" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name_category }}
                        </option>
                        @endforeach
                    </select>
                </div>


                <div class="mb-3">
                    <label>Stock</label>
                    <input type="number" name="stock" class="form-control border border-dark" placeholder="Masukan stock" required>
                </div>

                <button class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Kembali</a>
            </form>


        </div>
    </div>

</div>
@endsection