@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-0">
                    <i class="fas fa-tags mr-1 text-primary"></i>Tags
                </h3>
                <small class="text-muted">Manage all article tags</small>
            </div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show"><i
                        class="fas fa-check-circle mr-1"></i>{{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            @endif
            @can('manage tags')
                <a href="{{ route('tags.create') }}" class="btn btn-primary shadow-sm"><i class="fas fa-plus mr-1"></i>Add
                    Tag</a>
            @endcan

        </div>
        <div class="row">
            @forelse($tags as $tag)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm h-100 border-0">
                        <div class="card-body d-flex flex-column">
                            <h5 class="mb-2">
                                <i class="fas fa-tag text-info mr-1"></i> {{ $tag->name }}
                            </h5>
                            <small class="text-muted mb-3"><code>{{ $tag->slug }}</code></small>
                            <div class="mt-auto">
                                <a href="{{ route('tags.articles', $tag) }}" class="btn btn-sm btn-info btn-block mb-2"><i
                                        class="fas fa-eye mr-1"></i>Show Article</a>
                                <a href="{{ route('tags.show', $tag) }}" class="btn btn-sm btn-secondary btn-block mb-2"><i
                                        class="fas fa-eye mr-1"></i>View Tag</a>
                                @can('manage tags')
                                    <a href="{{ route('tags.edit', $tag) }}" class="btn btn-sm btn-warning btn-block mb-2"><i
                                            class="fas fa-edit mr-1"></i> Edit Tag</a>
                                @endcan
                                @can('delete tags')
                                    <form action="{{ route('tags.destroy', $tag) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger btn-block"
                                            onclick="return confirm('Delete this Tags?')"><i
                                                class="fas fa-trash mr-1"></i>Delete</button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No Tags Found. </h5>
                    </div>
                </div>
            @endforelse
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $tags->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
