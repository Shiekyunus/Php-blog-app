@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-0">
                    <i class="fas fa-newspaper mr-2 text-primary"></i>My Published Articles</h3><br>
                    <small class="text-muted">
                        Manage and review your published blog posts
                    </small>
            </div>
                    @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif
            <div>
                <a href="{{ route('articles.draft') }}" class="btn btn-warning shadow-sm mr-2">
                    <i class="fas fa-file-alt mr-1"></i>
                    Drafts
                </a>
                <a href="{{ route('articles.create') }}" class="btn btn-primary shadow-sm">
                    <i class="fas fa-plus-circle mr-1"></i>
                    Create Article
                </a>
            </div>
        </div>

        <div class="row">
        @forelse($articles as $article)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    @if ($article->image)
                        <img src="{{ asset('storage/' . $article->image) }}" class="card-img-top" style="height:220px; object-fit:cover;">
                    @else
                       <img src="https://via.placeholder.com/600x350" class="card-img-top" style="height:220px; object-fit:cover;">
                       @endif
                       <div class="card-body d-flex flex-column">

                    <h5 class="font-weight-bold">

                        {{ $article->title }}
                    </h5>
                    <p class="text-muted mb-2" style="font-size:14px;">
                        <i class="fas fa-folder mr-1"></i>
                        {{ $article->category->name ?? 'No Category' }}
                        &nbsp; | &nbsp;
                        <i class="fas fa-user mr-1"></i>
                        {{ $article->author->name ?? 'Unknown' }}
                    </p>
                    <p class="text-secondary">
                        {!! Str::limit($article->body, 120) !!}
                    </p>
                    <div class="mb-3">
                        @foreach ($article->tags as $tag)
                            <span class="badge badge-primary">
                                #{{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                    <div class="mt-auto">
                    <a href="{{ route('articles.show', $article) }}" class="btn btn-info btn-sm w-100 mb-2"><i class="fas fa-eye mr-1"></i> View</a>
                    @if (Auth::id() === $article->user_id || Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Editor'))
                        <a href="{{ route('articles.edit', $article) }}" class="btn btn-warning btn-sm w-100 mb-2">
                            <i class="fas fa-edit mr-1"></i>Edit
                        </a>
                        <a href="{{ route('revisions.index', $article) }}" class="btn btn-secondary btn-sm w-100 mb-2">
                        <i class="fas fa-history mr-1"></i>
                        Revisions
                    </a>
                    @endif
                    @if (Auth::id() === $article->user_id || Auth::user()->hasRole('Admin'))
                        <form action="{{ route('articles.destroy', $article) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm btn-block " onclick="return confirm('Delete Article?')">
                                <i class="fas fa-trash mr-1"></i>
                                Delete
                            </button>
                        </form>
                    @endif

                    </div>
                </div>
                </div>
            </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">
                No Articles Found.
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
