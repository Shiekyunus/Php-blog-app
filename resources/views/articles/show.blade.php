@extends('layouts.admin')
@php
    use Stichoza\GoogleTranslate\GoogleTranslate;
    $locale = app()->getLocale();
    $translatedTitle = $locale != 'en' ? GoogleTranslate::trans($article->title, $locale, 'en') : $article->title;
    $translatedBody = $locale != 'en' ? GoogleTranslate::trans($article->body, $locale, 'en') : $article->body;

@endphp
@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h2 class="font-weight-bold mb-3">
                    {{ $translatedTitle }}
                </h2>
                <div class="mb-3 text-muted">
                    <span class="mr-4">
                        <i class="fas fa-user mr-1 text-primary"></i>

                    <strong>Author :</strong>
                    {{ optional($article->author)->name??'Unknown Author' }}
                    </span>
                <span>
                    <i class="fas fa-folder mr-1 text-warning"></i>
                    <strong>Category :</strong>
                    {{ optional($article->category)->name?? 'No Category' }}
                </span>
                </div>
                @if ($article->image)
                    <img src="{{ asset('storage/' . $article->image) }}" style="width:100%; max-height:450px; object-fit:cover;" class="img-fluid rounded shadow-sm mb-4">
                @else
                   <img src="https://via.placeholder.com/1200x450" class="img-fluid rounded shadow-sm mb-4" style="width: 100%; max-height:450px; object-fit:cover;">
                @endif
                <div class="mb-4 text-secondary" style="line-height: 1.9;">
                    {!! nl2br(e($translatedBody)) !!}
                </div>
                <div class="mb-4">
                    @foreach ($article->tags as $tag)
                        <span class="badge badge-primary p-2 mr-1">
                            #{{ $tag->name }}
                        </span>
                    @endforeach

                </div>
                <div class="mb-4">
                    <strong class="mr-2">
                        <i class="fas fa-share-alt mr-1"></i>Share:</strong>
                    @php
                        $url = urlencode(request()->fullUrl());
                        $title = urlencode($article->title);
                    @endphp
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $url }}" target="_blank"
                        class="btn btn-sm btn-primary mr-1"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://twitter.com/intent/tweet?url={{ $url }}&text={{ $title }}"
                        target="_blank" class="btn btn-sm btn-dark mr-1"><i class="fab fa-twitter"></i></a>
                    <a href="https://wa.me/?text={{ $title }}%20{{ $url }}" target="_blank"
                        class="btn btn-sm btn-success"><i class="fab fa-whatsapp"></i></a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $url }}" target="_blank"
                        class="btn btn-sm btn-primary"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <div class="dropdown mb-4">
                    <button class="btn btn-warning dropdown-toggle" type="button"
                        data-toggle="dropdown"><i class="fas fa-language mr-1"></i>Translate</button>
                    <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('locale.switch', 'en') }}">
                                English
                            </a>
                            <a class="dropdown-item" href="{{ route('locale.switch', 'ta') }}">
                                Tamil
                            </a>
                            <a class="dropdown-item" href="{{ route('locale.switch', 'hi') }}">
                                Hindi
                            </a>
                             <a class="dropdown-item" href="{{ route('locale.switch', 'my') }}">
                                Myanmar
                            </a>
                        </div>
                </div>
                <div class="d-flex flex-wrap align-items-center">
                <a href="{{ url()->previous() }}" class="btn btn-secondary mr-2 mb-2">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Back
                </a>
                @auth
                 @if (Auth::id() === $article->user_id || Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Editor'))
                        <a href="{{ route('articles.edit', $article) }}" class="btn btn-warning btn-sm mr-2 mb-2">
                            <i class="fas fa-edit mr-1"></i>Edit
                        </a>
                        <a href="{{ route('revisions.index', $article) }}" class="btn btn-secondary btn-sm mr-2 mb-2">
                        <i class="fas fa-history mr-1"></i>
                        Revisions
                    </a>
                    @endif
                    @if (Auth::id() === $article->user_id || Auth::user()->hasRole('Admin'))
                        <form action="{{ route('articles.destroy', $article) }}" method="POST" class="d-inline mr-2 mb-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete Article?')">
                                <i class="fas fa-trash mr-1"></i>
                                Delete
                            </button>
                        </form>
                    @endif
                    @php
                      $isLiked=$article->likes()->where('user_id',Auth::id())->exists();
                      $isSaved=$article->savedArticles()->where('user_id',Auth::id())->exists();
                    @endphp
                   <button type="button" class="btn btn-light border mr-2 like-btn" data-slug="{{$article->slug}}">
                    <i class="{{$isLiked? 'fas text-danger':'far text-dark'}} fa-heart"></i>
                    <span class="like-count"> ({{$article->likes_count}})</span>
                   </button>
                    <button type="button" class="btn btn-success btn-sm save-btn" data-slug="{{$article->slug}}">
                        <i class="{{$isSaved?'fas text-success':'far text-dark'}} fa-bookmark"></i>
                        Save
                    </button>
                @endauth
            </div>
        </div>
        </div>
        <div class="mt-5">
            <h3 class="mb-4">
                <i class="fas fa-comments mr-2 text-primary"></i>
                Comments
            </h3>
            @auth
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                <form action="{{ route('comments.store', $article) }}" method="POST" class="mb-4">
                    @csrf
                    <div class="form-group">
                    <textarea name="body" rows="4" class="form-control" style="resize: none;" placeholder="Write your comment..."></textarea>
                    @error('body')
                     <div class="text-danger small mt-1">
                        {{$message}}
                     </div>
                     @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane mr-1"></i>
                        Add Comment
                    </button>
                </form>
                </div>
            </div>
            @endauth
            @forelse ($comments as $comment)
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-body">
                        @php
                            $translatedComment = $comment->body;
                            if ($locale != 'en') {
                                $translatedComment = GoogleTranslate::trans($comment->body, $locale, 'en');
                            }
                        @endphp
                        <h5 class="font-weight-bold mb-2"><i class="fas fa-user-circle mr-1 text-secondary"></i>{{ $comment->user->name }}</h5>
                        <p class="text-secondary">
                            {{ $translatedComment }}
                        </p>
                        <div class="mb-2">
                        @auth
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="toggleReplyForm({{ $comment->id }})">
                                <i class="fas fa-reply mr-1"></i>
                                Reply
                            </button>
                        @endauth
                        @php
                            $approvedRepliesCount = $comment->replies->where('status', 'approved')->count();
                        @endphp
                        @if ($approvedRepliesCount > 0)
                            <button class="btn btn-sm btn-outline-info" onclick="toggleReplies({{ $comment->id }})"><i class="fas fa-comments mr-1"></i>Show
                                Replies ({{ $approvedRepliesCount }})</button>
                        @endif
                        </div>
                        <div id="reply-form-{{ $comment->id }}" style="display:none" class="mt-3">
                            <form action="{{ route('comments.reply', $comment) }}" method="POST">
                                @csrf
                                <textarea name="body" rows="2" class="form-control" placeholder="Write reply"></textarea>
                                <button type="submit" class="btn btn-sm btn-primary mt-2">
                                    Submit Reply
                                </button>
                            </form>
                        </div>
                        <div id="replies-{{ $comment->id }}" style="display: none">
                            @foreach ($comment->replies as $reply)
                                @if ($reply->status == 'approved')
                                    <div class="card mt-3 ml-5 border-0 shadow-sm">
                                        <div class="card-body">
                                            @php
                                                $translatedReply = $reply->body;
                                                if ($locale != 'en') {
                                                    $translatedReply = GoogleTranslate::trans(
                                                        $reply->body,
                                                        $locale,
                                                        'en',
                                                    );
                                                }
                                            @endphp
                                            <h6 class="font-weight-bold">
                                                <i class="fas fa-user-circle mr-1 text-info"></i>
                                                {{ $reply->user->name }}
                                            </h6>
                                            <p class="text-secondary mb-0">
                                                {{ $translatedReply }}
                                            </p>
                                            @auth
                                                <button type="button" class="btn btn-sm btn-outline-secondary"
                                                    onclick="toggleReplyForm({{ $reply->id }})">
                                                    Reply
                                                </button>
                                            @endauth
                                            @php
                                                $approvedNestedRepliesCount = $reply->replies
                                                    ->where('status', 'approved')
                                                    ->count();
                                            @endphp
                                            @if ($approvedNestedRepliesCount > 0)
                                                <button class="btn btn-sm btn-outline-info"
                                                    onclick="toggleReplies({{ $reply->id }})"><i class="fas fa-comments mr-1"></i>Show
                                                    Replies ({{ $approvedNestedRepliesCount }})</button>
                                            @endif
                                            <div id="reply-form-{{ $reply->id }}" style="display: none;" class="mt-3">
                                                <form action="{{ route('comments.reply', $reply) }}" method="POST">
                                                    @csrf
                                                    <textarea name="body" rows="2" class="form-control" placeholder="Write reply..."></textarea>
                                                    <button type="submit" class="btn btn-sm btn-primary mt-2">
                                                        <i class="fas fa-paper-plane mr-1"></i>
                                                        Submit Reply
                                                    </button>
                                                </form>
                                            </div>
                                            <div id="replies-{{ $reply->id }}" style="display: none">
                                                @foreach ($reply->replies as $nestedreply)
                                                    @if ($nestedreply->status == 'approved')
                                                        <div class="card mt-3 ml-5 border-0 shadow-sm">
                                                            <div class="card-body">
                                                                @php
                                                                    $translatedNestedReply = $nestedreply->body;
                                                                    if ($locale != 'en') {
                                                                        $translatedNestedReply = GoogleTranslate::trans($nestedreply->body,$locale,'en');
                                                                    }
                                                                @endphp
                                                                <h6 class="font-weight-bold">
                                                                    <i class="fas fa-user-circle mr-1 text-info"></i>
                                                                    {{ $nestedreply->user->name }}
                                                                </h6>
                                                                <p class="text-secondary mb-0">
                                                                    {{ $translatedNestedReply}}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>


            @empty
            <div class="alert alert-light border text-center">
                <i class="fas fa-comments fa-2x text-muted mb-2"></i>
                <p class="mb-0">
                    No comments yet
                </p>
            </div>
            @endforelse
            <div class="d-flex justify-content-center mt-4">{{$comments->links('pagination::bootstrap-4')}}</div>
        </div>
        <div class="mt-5">
            <h3 class="mb-4">
                <i class="fas fa-newspaper mr-2 text-success"></i>
                Related Articles
            </h3>
            <div class="row">
            @forelse($relatedArticles as $related)
                <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="font-weight-bold">
                            {{ $related->title }}
                        </h5>
                        <p class="text-muted">
                            {{Str::limit($related->body,100)}}
                        </p>
                        <div class="mt-auto">
                        <a href="{{ route('articles.show', $related) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-book-open mr-1"></i>
                            Read More
                        </a>
                        </div>
                    </div>
                    </div>
                </div>
            @empty
              <div class="col-12">
                <div class="alert alert-light border text-center">
                    <i class="fas fa-newspaper fa-2x text-muted mb-2"></i>
                <p class="mb-0">
                    No related articles Found.
                </p>
                </div>
              </div>
            @endforelse
        </div>
    </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                }
            });
        $('.like-btn').click(function(){
            let button = $(this);
            let articleslug=button.data('slug');
            $.ajax({
                url:"{{url('/articles/')}}/"+articleslug+"/like",
                type:'POST',
                success:function(response){
                    button.find('.like-count').text(response.like_count);
                    let icon=button.find('i');
                    if(response.liked){
                        icon.removeClass('far text-dark');
                        icon.addClass('fas text-danger');
                    }else{
                        icon.removeClass('fas text-danger');
                        icon.addClass('far text-dark');
                    }
                },
                error:function(xhr){
                console.log(xhr.responseText);
                }
            });
        });
        $('.save-btn').click(function(){
            let button = $(this);
            let articleslug=button.data('slug');
            $.ajax({
                url:"{{url('/articles/')}}/"+articleslug+"/save",
                type:'POST',
                data:{
                    _token: '{{csrf_token()}}'
                },
                success:function(response){
                    let icon=button.find('i');
                    if(response.saved){
                        icon.removeClass('far text-dark');
                        icon.addClass('fas text-success');
                    }else{
                        icon.removeClass('fas text-success');
                        icon.addClass('far text-dark');
                    }
                },
                error:function(xhr){
                    console.log(xhr.responseText);
                }
            });
        });
    });
        function toggleReplyForm(id) {
            let form = document.getElementById('reply-form-' + id);
            if (form.style.display === 'none') {
                form.style.display = 'block';
            } else {
                form.style.display = 'none';
            }
        }

        function toggleReplies(id) {
            let replies = document.getElementById('replies-' + id);
            if (replies.style.display === "none") {
                replies.style.display = 'block';
            } else {
                replies.style.display = 'none';
            }
        }
    </script>
@endsection
