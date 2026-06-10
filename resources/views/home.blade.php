@extends('layouts.admin')
@section('content')
<style>
    .card:hover{
        transform: translateY(-3px);
        transition: 0.3s;
        box-shadow: 0 8px 20px rgba(0, 0,0, 0.1);
    }
</style>
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            @isset($q)
            <h4 class="mb-0">Search Result for "{{$q}}"</h4>
            <small class="text-muted">
                Showing articles related to your search keyword
            </small>
            @elseif(isset($category))
            <h4 class="mb-0">
                Articles in "{{$category->name}}" Category
            </h4>
            <small class="text-muted">
                Browse articles belonging to this category
            </small>
            @elseif(isset($tag))
            <h4 class="mb-0">
                Articles Tagged with "#{{$tag->name}}"
            </h4>
            <small class="text-muted">
                Explore articles related to this tag
            </small>
            @else
            <h4 class="mb-0">Latest Articles</h4>
            <small class="text-muted">Read the newest published posts</small>
            @endisset
        </div>
    </div>
    <div class="row">
        @forelse($articles as $article)
          <div class="col-md-6 col-lg-4 mb-4">
              <div class="card h-100 shadow-sm">
                 @if($article->image)
                   <img src="{{asset('storage/'.$article->image)}}" class="card-img-top" style="height: 200px; object-fit:cover;">
                   @else
                   <img src="https://via.placeholder.com/400x200" class="card-img-top" style="height: 200px; object-fit:cover;">
                 @endif
                 <div class="card-body d-flex flex-column">
                    <h5>
                        <a href="{{route('articles.show',$article)}}">
                            {{$article->title}}
                        </a>
                    </h5>
                    <p class="text-muted mb-2" style="font-size: 13px;">
                        <i class="fas fa-user"></i>
                        {{$article->author->name??'Unknown'}}
                        &nbsp; | &nbsp;
                        <i class="fas fa-folder"></i>
                        {{$article->category->name??'uncategorized'}}
                    </p>
                    <p class="text-secondary">
                        {{Str::limit($article->body,120)}}
                    </p>
                    <div class="mb-2">
                        @foreach($article->tags as $tag)
                          <span class="badge badge-light border">
                            #{{$tag->name}}
                          </span>
                        @endforeach
                    </div>
                    <div class="mt-auto">
                        <a href="{{route('articles.show',$article)}}" class="btn btn-primary btn-sm btn-block">
                            Read More
                        </a>
                    </div>
                    @auth
                    <div class="mt-auto">
                      @if (Auth::id() === $article->user_id || Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Editor'))
                        <a href="{{route('articles.edit',$article)}}" class="btn btn-warning btn-sm btn-block mb-2">
                            Update Article
                        </a>
                      @endif
                    </div>
                    <div class="mt-auto">
                      @if (Auth::id() === $article->user_id || Auth::user()->hasRole('Admin'))
                        <form action="{{route('articles.destroy',$article)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm btn-block mb-2" onclick="return confirm('Delete Article?')">
                                Delete Article
                            </button>
                        </form>
                      @endif
                    </div>
                    @endauth
                 </div>
              </div>
          </div>
          @empty
          <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                <h5 class="text-muted"> No articles available.</h5>
            </div>
          </div>
          @endforelse
    </div>
    <div class="d-flex justify-content-center">
        {{$articles->links('pagination::bootstrap-4')}}
    </div>
</div>
@endsection
