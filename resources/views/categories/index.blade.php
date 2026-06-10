@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>
                <h3 class="mb-0">
                    <i class="fas fa-folder mr-1 text-primary"></i>Category
                </h3>
                <small class="text-muted">Manage all article Categories</small>
            </div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show"><i
                        class="fas fa-check-circle mr-1"></i>{{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            @endif
            @can('manage categories')
                <a href="{{ route('categories.create') }}" class="btn btn-primary shadow sm">Add Category</a>
            @endcan

        </div>
        <div class="row">
            @forelse($categories as $category)
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="mb-2"><i class="fas fa-folder"></i>{{ $category->name }}</h5>
                            <small class="text-muted mb-3"><code>{{ $category->slug }}</code></small>
                            <div class="mt-auto">
                                <a href="{{ route('categories.articles', $category) }}" class="btn btn-info btn-sm w-100 mb-2">
                                    <i class="fas fa-eye mr-1"></i>
                                    Show Articles
                                </a>

                                <a href="{{ route('categories.show', $category) }}"
                                    class="btn btn-secondary btn-sm w-100 mb-2">
                                    <i class="fas fa-eye mr-1"></i>View
                                    Category</a>
                                @can('manage categories')
                                    <a href="{{ route('categories.edit', $category) }}"
                                        class="btn btn-sm btn-warning w-100 mb-2"><i class="fas fa-edit mr-1"></i>Edit
                                        Category</a>
                                @endcan
                                @can('delete categories')
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger w-100"
                                            onclick="return confirm('Delete this Category?')"><i
                                                class="fas fa-trash mr-1"></i>Delete Category</button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">No Categories Found. </div>
                </div>
            @endforelse
        </div>
        <div class="d-flex justify-content-center mt-4">{{ $categories->links('pagination::bootstrap-4') }}</div>
    </div>
    </div>
    </div>
@endsection
