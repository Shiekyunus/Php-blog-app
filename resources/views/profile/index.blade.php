@extends('layouts.admin')

@section('content')
<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="card border-0 shadow-lg rounded-lg overflow-hidden">
            <div class="bg-primary text-white text-center py-5 position-relative">
                @if($user->image)
                   <img src="{{asset('user_images/'.$user->image)}}" width="140" height="140" class="rounded-circle shadow border border border-white" style="object-fit: cover; border-width:4px !important;">
                   @else
                   <div class="mx-auto rounded-circle bg-white text-primary d-flex align-items-center justify-content-center shadow" style="width: 140px; height:140px; font-size:55px;font-weight:bold;">
                    {{strtoupper(substr($user->name,0,1))}}
                   </div>
                   @endif
                   <h2 class="mt-4 font-weight-bold">{{$user->name}}</h2>
                   <p class="mb-0">
                    <i class="fas fa-envelope mr-1"></i>
                    {{$user->email}}
                   </p>
            </div>
            <div class="card-body p-5">
                <div class="row text-center">
                    <div class="col-md-4 mb-4">
                        <div class="border rounded-lg p-4 shadow-sm h-100">
                            <i class="fas fa-newspaper fa-2x text-primary mb-3"></i>
                            <h4 class="font-weight-bold">
                                {{$user->articles->count()}}
                            </h4>
                            <p class="text-muted mb-0">
                                Articles
                            </p>
                        </div>
                    </div>
    <div class="col-md-4 mb-4">
        <div class="border rounded-lg p-4 shadow-sm h-100">
            <i class="fas fa-heart fa-2x text-danger mb-3"></i>
             <h4 class="font-weight-bold"> {{$user->likes->count()}}</h4>
             <p class="text-muted mb-0">
                Likes
             </p>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="border rounded-lg p-4 shadow-sm h-100">
            <i class="fas fa-bookmark fa-2x text-success mb-3"></i>
             <h4 class="font-weight-bold"> {{$user->savedArticles->count()}}</h4>
             <p class="text-muted mb-0">
                Saved Articles
             </p>
        </div>
    </div>
                </div>
    <div class="mt-4">
        <h4 class="font-weight-bold mb-4">
            <i class="fas fa-user-circle text-info mr-2"></i>
            Profile Information
        </h4>
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="border rounded-lg p-3 shadow-sm">
                    <small class="text-muted d-block">
                        Full Name
                    </small>
                    <strong>{{$user->name}}</strong>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="border rounded-lg p-3 shadow-sm">
                    <small class="text-muted d-block">
                        Email Address
                    </small>
                    <strong>{{$user->email}}</strong>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="border rounded-lg p-3 shadow-sm">
                    <small class="text-muted d-block">
                        Role
                    </small>
                    <strong>{{optional($user->roles)->pluck('name')->implode(', ')}}</strong>
                </div>
            </div>
           <div class="col-md-6 mb-4">
                <div class="border rounded-lg p-3 shadow-sm">
                    <small class="text-muted d-block">
                        Joined Date
                    </small>
                    <strong>{{$user->created_at->format('d M Y')}}</strong>
                </div>
            </div>
        </div>
    </div>
            <div class="text-center mt-4">
                <a href="{{route('profile.edit')}}" class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm">
                    <i class="fas fa-edit mr-1"></i>
                    Edit Profile
                </a>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
