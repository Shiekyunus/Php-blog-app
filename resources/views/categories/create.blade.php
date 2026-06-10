@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card card-primary card-outline shadow-sm">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="fas fa-folder-plus"></i>Create Category</h5><br>
                          <small class="text-muted">Add a new category for articles</small>
                    </div>

                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>Category Name</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label> Description (Optional)</label>
                                <textarea name="description" class="form-control" rows="4" placeholder="Enter category description">{{ old('description') }}</textarea>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <a href="{{ route('categories.index') }}" class="btn btn-secondary"><i class="fas fa-times mr-1"></i>Back</a>
                            <button type="submit" class="btn btn-success"><i class="fas fa-save mr-1"></i>Save Category</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
