@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card card-warning card-outline shadow-sm">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="fas fa-edit mr-1"></i> Edit Tag: </h5><br>
                        <small class="text-muted">
                            Update tag details below
                        </small>
                    </div>
                        <form action ="{{ route('tags.update', $tag) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                            <div class="form-group">
                                <label>Tag Name</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $tag->name) }}" placeholder="Enter tag name">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            </div>
                            <div class="card-footer d-flex justify-content-between">
                                <a href="{{ route('tags.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i>Back </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i>Update Tag</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
