@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')


<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-dark text-white fw-bold">
          
            <h3 class="text-white">  Edit Kategori</h3>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <label class="mt-3">Nama Kategori</label>
                <input type="text" name="name_category" class="form-control border border-dark" value="{{ $category->name_category }}" required>
                @error('name_category')
                <div class="text-danger">{{ $message }}</div>
                @enderror

                <label class="mt-3">Deskripsi</label>
                <input type="text" name="description" class="form-control border border-dark" value="{{ $category->description }}" required>
                @error('description')
                <div class="text-danger">{{ $message }}</div>
                @enderror

                <button type="submit" class="btn btn-warning mt-4">Update</button>
                <a href="{{ route('admin.category.index') }}" class="btn btn-secondary mt-4">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection