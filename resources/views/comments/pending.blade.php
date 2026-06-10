@extends('layouts.admin')
@section('content')
<div class="container-fluid py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h2 class="font-weight-bold"><i class="fas fa-comments text-warning mr-2"></i>Pending Comments
    </h2>
    <p class="text-muted mb-0">Review and moderate user comments</p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-10 mx-auto">
    @forelse ($comments as $comment)
        <div class="card border-0 shadow-sm rounded-lg mb-3">
            <div class="card-body">
                <div class="d-flex justity-content-between flex-wrap mb-2">
                    <div>
                <h5 class="font-weight-bold mb-1"><i class="fas fa-user-circle text-primary mr-1"></i>{{$comment->user->name}}</h5>
                <small class="text-muted">
                    <i class="fas fa-book mr-1"></i>Article :<strong>
                    {{$comment->article->title}}</strong>
                </small>
                    </div>
                </div>
                <div class="bg-light p-3 rounded mb-3">
                    {{$comment->body}}
                </div>
                @if($comment->parent)
                <div class="alert alert-secondary py-2">
                    <small>
                    <strong>Reply To:</strong>{{$comment->parent->body}}
                    </small>
                </div>
                @endif
                <div class="d-flex">
                <form action="{{route('comments.approve',$comment)}}" method="POST" class="mr-2">
                    @csrf
                    @method('PATCH')
                    <button class="btn btn-success btn-sm rounded-pill shadow-sm">
                        <i class="fas fa-check mr-1"></i>Approve
                    </button>
                </form>
                <form action="{{route('comments.reject',$comment)}}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button class="btn btn-danger btn-sm rounded-pill shadow-sm"><i class="fas fa-times mr-1"></i>Reject</button>
                </form>
            </div>
        </div>
        </div>
        @empty
        <div class="text-center py-5">
            <i class="fas fa-comment-slash fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">No Pending Comments</h5>
        </div>
    @endforelse
    <div class="d-flex justify-content-center mt-4">
    {{$comments->links('pagination::bootstrap-4')}}
    </div>
        </div>
    </div>
</div>
</div>
@endsection
