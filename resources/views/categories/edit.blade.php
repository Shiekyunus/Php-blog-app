@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card card-warning card-outline shadow-sm">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="fas fa-edit mr-1"></i>Edit Category </h5><br>
                        <small class="text-muted">Update category details below</small>
                    </div>

                    <form action ="{{ route('categories.update', $category) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label>Category Name</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $category->name) }}" placeholder="Enter category name">
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" class="form-control" rows="4" placeholder="Enter category description">{{ old('description', $category->description) }}</textarea>
                            </div>
                        </div>
                            <div class="card-footer d-flex justify-content-between">
                                <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i>Back</a>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>Update
                                    Category</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
