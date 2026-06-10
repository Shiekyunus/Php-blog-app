@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-info card-outline shadow-sm">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-folder"></i> Category Details
                        </h5>
                    </div>
                    <div class="card-body">
                        <h4 class="mb-3"><i class="fas fa-tag"></i> {{ $category->name }}</h4>
                        <p class="text-muted mb-2"><strong>Slug:</strong><code>{{ $category->slug }}</code></p>
                        <hr>
                        <div class="mb-3">
                            <h6 class="text-secondary">Description</h6>
                            <div class="p-3 bg-light border rounded">
                                {{ $category->description ?? 'No description provided.' }}
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="text-muted"><i class="fas fa-newspaper mr-1"></i>Published Articles:</span>
                            <span class="badge badge-success">
                                {{$category->published_articles_count}}
                            </span>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary"><i
                                class="fas fa-arrow-left mr-1"></i>Back to List</a>
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-primary">
                            <i class="fas fa-edit mr-1"></i>Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
