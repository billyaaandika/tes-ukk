@extends('layouts.app')

@section('title', 'Edit Tool')

@section('content')


<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-dark text-white fw-bold">
          
            <h3 class="text-white">  Edit Tool </h3>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.tools.update', $tool->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <label class="mt-3">Nama Alat</label>
                <input type="text" name="name_tool" class="form-control border border-dark" value="{{ $tool->name_tool }}" required>
                @error('name_tool')
                <div class="text-danger">{{ $message }}</div>
                @enderror

                <label class="mt-3">Kategori</label>
                <input type="text" name="category_tool" class="form-control border border-dark" value="{{ $tool->category_tool }}" required>
                @error('category_tool')
                <div class="text-danger">{{ $message }}</div>
                @enderror

                <label class="mt-3">Stock</label>
                <input type="number" name="stock" class="form-control border border-dark" value="{{ $tool->stock }}" required>
                @error('stock')
                <div class="text-danger">{{ $message }}</div>
                @enderror

                <button type="submit" class="btn btn-warning mt-4">Update</button>
                <a href="{{ route('admin.tools.index') }}" class="btn btn-secondary mt-4">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection