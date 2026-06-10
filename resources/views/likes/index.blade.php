@extends('layouts.admin')
@section('content')
<div class="container-fluid py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
    <h2 class="font-weight-bold">
        <i class="fas fa-heart text-danger mr-2"></i>Liked Articles</h2>
        <p class="text-muted mb-0">Articles you have liked</p>
        </div>
    </div>
    <div class="row">
    @forelse($likes as $like)
      <div class="col-md-6 col-lg-4 mb-4">
        <div class="card border-0 shadow-lg rounded-lg h-100">
            <div class="position-relative">
                @if($like->article->image)
                  <img src="{{asset('storage/'.$like->article->image)}}" class="card-img-top" style="height: 200px;object-fit:cover;">
                  @else
                  <img src="https://via.placeholder.com/400x200" class="card-img-top" style="height: 200px; object-fit:cover;">
                  @endif
                  <span class="badge badge-success position-absolute" style="top: 10px;right:10px;">Liked </span>
            </div>
            <div class="card-body d-flex flex-column">
            <h5 class="font-weight-bold">{{$like->article->title}}</h5>
            <p class="text-muted small">
                {{Str::limit($like->article->body,100)}}
            </p>
            <div class="mt-auto">
                <a href="{{route('articles.show',$like->article)}}" class="btn btn-primary btn-sm btn-block rounded-pill">
                    <i class="fas fa-eye mr-1"></i>View Article
                </a>
            </div>
            </div>
        </div>

      </div>
    @empty
     <div class="col-12 text-center py-5">
        <i class="fas fa-bookmark fa-3x text-muted mb-3"></i>

      <h5 class="text-muted">No liked articles found.</h5>
      <a href="{{route('home')}}" class="btn btn-outline-primary mt-2">
        Explore Articles
      </a>
     </div>
    @endforelse
</div>
<div class="d-flex justify-content-center mt-4">{{ $likes->links('pagination::bootstrap-4') }}</div>
    </div>
@endsection
