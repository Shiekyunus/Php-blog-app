@extends('layouts.admin')

@section('content')
<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
        <div class="card border-0 shadow-lg rounded-lg overflow-hidden">
            <div class="bg-primary text-white text-center py-5 ">
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
           <div class="row">
            <div class="col-md-6 mb-4">
                <div class="border rounded-lg p-4 shadow-sm h-100">
                    <small class="text-muted d-block mb-2">
                       <i class="fas fa-user text-primary mr-1"></i> Full Name
                    </small>
                    <h5 class="font-weight-bold mb-0">{{$user->name}}</strong>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="border rounded-lg p-4 shadow-sm h-100">
                    <small class="text-muted d-block mb-2">
                        <i class="fas fa-envelope text-info mr-1"></i>Email Address
                    </small>
                    <h5 class="font-weight-bold mb-0">{{$user->email}}</h5>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="border rounded-lg p-3 shadow-sm p-4 h-100">
                    <small class="text-muted d-block mb-2">
                        Role
                    </small>
                    @php
                      $role=$user->getRoleNames()->first();
                    @endphp
                    @if($role=='Admin')
                           <span class="badge badge-danger px-3 py-2">
                            <i class="fas fa-user-shield mr-1"></i>{{$role}}
                           </span>
                        @elseif($role=='Editor')
                           <span class="badge badge-warning px-3 py-2">
                            <i class="fas fa-user-edit mr-1"></i>{{$role}}
                           </span>
                        @elseif($role=='Author')
                           <span class="badge badge-danger px-3 py-2">
                            <i class="fas fa-pen-nib mr-1"></i>{{$role}}
                           </span>
                        @else
                           <span class="badge badge-primary px-4 py-2">
                            <i class="fas fa-user mr-1"></i>{{$role??'User'}}
                           </span>
                           @endif
                </div>
            </div>
           <div class="col-md-6 mb-4">
                <div class="border rounded-lg p-4 shadow-sm h-100">
                    <small class="text-muted d-block mb-2">
                        <i class="fas fa-calendar-alt text-success mr-1"></i>Joined Date
                    </small>
                    <h5 class="font-weight-bold mb-0">{{$user->created_at->format('d M Y')}}</h5>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between mt-4">
            <a href="{{route('users.index')}}" class="btn btn-secondary rounded-pill px-4 shadow-sm"><i class="fas fa-arrow-left mr-1"></i>Back</a>
                <a href="{{route('users.edit',$user)}}" class="btn btn-warning btn-lg rounded-pill px-5 shadow-sm text-white">
                    <i class="fas fa-edit mr-1"></i>
                    Edit Profile
                </a>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
