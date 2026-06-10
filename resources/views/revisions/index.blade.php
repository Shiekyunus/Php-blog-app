@extends('layouts.admin')

@section('content')

<div class="container-fluid py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
       <div> <h2 class="font-weight-bold">
            <i class="fas fa-history text-primary mr-2"></i>Revision History
        </h2>
        <p class="text-muted mb-0">Track all change of this article</p>
       </div>
        <a href="{{route('articles.show',$article)}}" class="btn btn-secondary rounded-pill shadow-sm"><i class="fas fa-arrow-left mr-1"></i>Back</a>
    </div>
        @if(session('success'))
           <div class="alert alert-success shadow-sm">
            <i class="fas fa-check-circle mr-1"></i>
               {{session('success')}}
           </div>
        @endif
        <div class="row">
           <div class="col-lg-10 mx-auto">
             @forelse ( $revisions as $revision)
                <div class="card mb-4 shadow-lg rounded-lg mb-4 border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start flex-wrap">
                            <div>
                                <h4 class="font-weight-bold text-primary">
                                    {{$revision->title}}
                                </h4>
                                <p class="text-muted md-2">
                                    <i class="fas fa-user-edit mr-1"></i>
                                    Restored By :
                                    <strong>
                                        {{
                                            $revision->user->name??'Unknown'
                                        }}
                                    </strong>
                                </p>

                            </div>
                            @can('manage articles')
                                <form method="POST" action="{{route('revisions.restore',[$article,$revision])}}">
                                    @csrf
                                    <button type="submit" class="btn btn-warning rounded-pill btn-sm shadow-sm">
                                       <i class="fas fa-undo mr-1"></i> Restore Revision
                                    </button>
                                </form>
                            @endcan
                        </div>
                        <hr>
                        <div class="mb-3">
                            <h6 class="text-muted">
                                <i class="fas fa-folder mr-1"></i>Category
                            </h6>

                                @php
                                    $category=\App\Models\Category::find($revision->category_id);
                                @endphp
                                <span class="badge badge-info px-3 py-2">
                                {{$category?->name??'No Category'}}
                                </span>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-muted">
                                <i class="fas fa-tags mr-1"></i>Tags
                            </h6>
                            @if($revision->tags)
                              @php
                                  $tags=\App\Models\Tag::whereIn('id',$revision->tags)->get();
                              @endphp
                              @foreach ($tags as $tag)
                                  <span class="badge badge-primary px-3 py-2 mr-1">
                                     #{{$tag->name}}
                                  </span>
                              @endforeach
                            @else
                              <span class="text-muted">
                                No Tags
                              </span>
                            @endif
                        </div>
                        <div class="mb-3">
                            <h6 class="text-muted">
                                <i class="fas fa-image mr-1"></i>Article Image
                            </h6>
                            @if($revision->image)
                                <img src="{{asset('storage/'.$revision->image)}}" style="max-width:300px;" class="img-fluid rounded shadow-sm">
                            @else
                               <p class="text-muted">No Image</p>
                            @endif
                        </div>
                        <div>
                            <h6 class="text-muted">
                                <i class="fas fa-file-alt mr-1"></i>Content
                            </h6>
                            <div class="border p-3 rounded bg-light">
                                {!! nl2br(e($revision->body)) !!}
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-5">
                    <i class="fas fa-history fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No Revisions Found</h5>
                </div>
             @endforelse
             <div class="d-flex justify-content-center mt-4">
                {{$revisions->links('pagination::bootstrap-4')}}
             </div>
    </div>
</div>
        </div>
@endsection
