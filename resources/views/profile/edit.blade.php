@extends('layouts.admin')
@section('content')
<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
        <div class="card border-0 shadow-lg rounded-lg overflow-hidden">
        <div class="bg-primary text-white text-center py-4">
            <h3 class="mb-0"><i class="fas fa-user-edit mr-2"></i>Edit Profile</h3>
        </div>
        <div class="card-body p-5">
            <form action="{{route('profile.update')}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group mb-4">
                <label class="font-weight-bold"><i class="fas fa-user text-primary mr-1"></i>Name</label>
                <input type="text" name="name" value="{{$user->name}}" class="form-control form-control-lg rounded-pill shadow-sm">
            </div>
            <div class="form-group mb-4">
                <label class="font-weight-bold"><i class="fas fa-envelope text-info mr-1"></i>Email</label>
                <input type="email" name="email" value="{{$user->email}}" class="form-control form-control-lg rounded-pill shadow-sm">
            </div>
            <div class="form-group mb-4">
                <label class="font-weight-bold"><i class="fas fa-lock text-warning mr-1"></i>Password(optional)</label>
                <input type="password" name="password" class="form-control form-control-lg rounded-pill shadow-sm">
            </div>
            <div class="form-group mb-4">
                <label class="font-weight-bold"><i class="fas fa-check-circle text-success mr-1"></i>Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control form-control-lg rounded-pill shadow-sm" >
            </div>
            @if($user->image)
            <div class="text-center mb-4">
                <label class="font-weight-bold d-block mb-2">Current Profile Image</label>
                   <img src="{{asset('user_images/'.$user->image)}}" class="rounded-circle shadow border" width="120" height="120" style="object-fit: cover;">

            </div>
            @endif
            <div class="form-group mb-3">
                <label class="font-weight-bold"><i class="fas fa-image text-secondary mr-1"></i>Change Image</label>
                <input type="file" name="image" class="form-control">
            </div>
            <div class="d-flex justify-content-between">
                <a href="{{route('profile.index')}}" class="btn btn-outline-secondary rounded-pill px-4"><i class="fas fa-arrow-left mr-1"></i>
                    Cancel
                </a>
            <button type="submit" class="btn btn-success rounded-pill px-5 shadow-sm"><i class="fas fa-save mr-1"></i>Update Profile</button>
            </div>
            </form>
        </div>
        </div>
        </div>
    </div>
</div>
@endsection
