@extends('layouts.admin')

@section('content')
<div class="container-fluid py-5">
    <h2 class="font-weight-bold mb-4">
        <i class="fas fa-chart-line text-primary mr-2"></i>Dashboard</h2>
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm rounded-lg text-center p-4 h-100">
                <i class="fas fa-newspaper fa-2x text-primary mb-3"></i>
                <h6 class="text-muted">Published Articles</h6>
                <h3 class="font-weight-bold">{{ $publishedCount}}</h3>
                <a href="{{route('home')}}" class="btn btn-outline-primary btn-sm mt-3 rounded-pill"><i class="fas fa-arrow-right mr-1"></i>
                  View Article
                </a>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm rounded-lg text-center p-4 h-100">
                <i class="fas fa-bookmark fa-2x text-success mb-3"></i>
                <h6 class="text-muted">Saved Articles</h6>
                <h3 class="font-weight-bold">{{ $savedCount}}</h3>
                <a href="{{route('saved.index')}}" class="btn btn-outline-success btn-sm mt-3 rounded-pill">
                    <i class="fas fa-bookmark mr-1"></i>View Saved
                </a>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm rounded-lg text-center p-4 h-100">
                <i class="fas fa-heart fa-2x text-success mb-3"></i>
                <h6 class="text-muted">Like Articles</h6>
                <h3 class="font-weight-bold">{{ $likedCount}}</h3>
                <a href="{{route('likes.index')}}" class="btn btn-outline-danger btn-sm mt-3 rounded-pill">
                    <i class="fas fa-bookmark mr-1"></i>View Likes
                </a>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm rounded-lg text-center p-4 h-100">
                <i class="fas fa-bell fa-2x text-warning mb-3"></i>
                <h6 class="text-muted">Newsletter Subscription</h6>
                @php
                  $isSubscribed=\App\Models\Subscription::where('user_id',auth()->id())->where('status','active')->exists();
                  @endphp
                  @if($isSubscribed)
                  <h5 class="text-success font-weight-bold">Active</h5>
                  <form action="{{route('unsubscribe')}}" method="POST" class="mt-3">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill"><i class="fas fa-times mr-1"></i>Unsubscribe</button>
                  </form>
                  @else
                  <h5 class="text-muted font-weight-bold">
                    No Subscribed
                  </h5>
                  <form action="{{route('subscribe')}}" method="POST" class="mt-3">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill text-white"><i class="fas fa-bell mr-1"></i>Subscribe</button>
                  </form>
                  @endif
            </div>
        </div>
        @isset($ownPublished)
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm rounded-lg text-center p-4 h-100">
                <i class="fas fa-user-edit fa-2x text-info mb-3"></i>
                <h6 class="text-muted">My Published</h6>
                <h3 class="font-weight-bold">{{ $ownPublished}}</h3>
                <a href="{{route('articles.index')}}" class="btn btn-outline-info btn-sm mt-3 rounded-pill">
                    <i class="fas fa-user-edit mr-1"></i>My Articles
                </a>
            </div>
        </div>
        @endisset
        @isset($draftCount)
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm rounded-lg text-center p-4 h-100">
                <i class="fas fa-file-alt fa-2x text-warning mb-3"></i>
                <h6 class="text-muted">My Drafts</h6>
                <h3 class="font-weight-bold">{{ $draftCount}}</h3>
                <a href="{{route('articles.draft')}}" class="btn btn-outline-warning btn-sm mt-3 rounded-pill">
                    <i class="fas fa-file-alt mr-1"></i>View Drafts
                </a>
            </div>
        </div>
        @endisset
        @isset($pendingComments)
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm rounded-lg text-center p-4 h-100">
                <i class="fas fa-comments fa-2x text-secondary mb-3"></i>
                <h6 class="text-muted">Pending Comments</h6>
                <h3 class="font-weight-bold">{{ $pendingComments}}</h3>
                <a href="{{route('comments.pending')}}" class="btn btn-outline-secondary btn-sm mt-3 rounded-pill">
                    <i class="fas fa-comments mr-1"></i>Review Comments
                </a>
            </div>
        </div>
        @endisset
        @isset($totalUsers)
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm rounded-lg text-center p-4 h-100">
                <i class="fas fa-users fa-2x text-dark mb-3"></i>
                <h6 class="text-muted">Total Users</h6>
                <h3 class="font-weight-bold">{{ $totalUsers}}</h3>
                <a href="{{route('users.index')}}" class="btn btn-outline-dark btn-sm mt-3 rounded-pill">
                    <i class="fas fa-users mr-1"></i>Manage Users
                </a>
            </div>
        </div>
        @endisset
    </div>
</div>
@endsection
