@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-0">
                    <i class="fas fa-file-alt text-warning mr-2"></i>Draft Articles
                </h3>
                <small class="text-muted">
                    Manage unpublished draft articles
                </small>
            </div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle mr-1"></i>
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            @endif
            <a href="{{ route('articles.index') }}" class="btn btn-secondary shadow-sm">
                <i class="fas fa-newspaper mr-1"></i>My Published Articles
            </a>
        </div>
        <div class="row">
            @forelse ($articles as $article)
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm border-0 h-100">
                        @if ($article->image)
                            <img src="{{ asset('storage/' . $article->image) }}" class="card-img-top"
                                style="height:220px;object-fit:cover;">
                        @else
                            <img src="https://via.placeholder.com/600x220" class="card-img-top"
                                style="height:220px;object-fit:cover;">
                        @endif

                        <div class="card-body d-flex flex-column">
                            <div class="mb-2">
                                <span class="badge badge-warning px-3 py-2">
                                    <i class="fas fa-pencil-alt mr-1"></i>Draft
                                </span>
                            </div>
                            <h4 class="mb-2">
                                {{ $article->title }}
                            </h4>
                            <p class="text-muted mb-2">
                                <i class="fas fa-folder mr-1"></i>
                                {{ $article->category->name ?? 'No Category' }}
                            </p>
                            <p class="text-secondary">
                                {{ Str::limit($article->body, 150) }}
                            </p>
                            <div class="mb-3">
                                @foreach ($article->tags as $tag)
                                    <span class="badge bg-primary mr-1">
                                        <i class="fas fa-tag mr-1"></i>{{ $tag->name }}
                                    </span>
                                @endforeach
                            </div>
                            <div class="mt-auto">
                                <a href="{{ route('articles.show', $article) }}" class="btn btn-info btn-sm mb-2">
                                    <i class="fas fa-eye mr-1"></i>View
                                </a>
                                <a href="{{ route('articles.edit', $article) }}" class="btn btn-warning btn-sm mb-2">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </a>
                                <form action="{{ route('articles.destroy', $article) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm mb-2"
                                        onclick="return confirm('Delete this article?')">
                                        <i class="fas fa-trash mr-1"></i>Delete
                                    </button>
                                </form>
                                <form action="{{ route('articles.status', $article) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-success btn-sm mb-2"><i
                                            class="fas fa-paper-plane mr-1"></i>Publish</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-file-alt fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">
                            No Draft Articles Found.
                        </h5>
                    </div>
                </div>
            @endforelse
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $articles->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
