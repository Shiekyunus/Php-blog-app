@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="col-md-8">
            <div class="card card-info card-outline shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-tag mr-1"></i>Tag Details
                    </h5>
                </div>
                <div class="card-body">
                    <h4 class="mb-3"><i class="fas fa-tags text-info mr-1"></i> {{ $tag->name }}</h4>
                    <p class="text-muted mb-3"><strong>Slug:</strong><code>{{ $tag->slug }}</code></p>
                    <hr>
                    <div class="mb-3">
                        <span class="text-muted">
                            <i class="fas fa-newspaper mr-1"></i> Total Articles:
                        </span>
                        <span class="badge badge-primary">
                            {{ $tag->articles_count ?? 0 }}
                        </span>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('tags.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i>Back
                        to List</a>
                    @can('manage tags')
                        <a href="{{ route('tags.edit', $tag) }}" class="btn btn-primary">
                            <i class="fas fa-edit mr-1"></i>Edit Tag
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection
