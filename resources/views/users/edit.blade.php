@extends('layouts.admin')
@section('content')
<div class="container-fluid py-5">
    <div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-lg rounded-lg overflow-hidden">
            <div class="bg-warning text-white text-center py-4">
        <h3 class="mb-1"><i class="fas fa-user-edit mr-2"></i>Edit User</h3>
        <p class="mb-0">
            Update user information and role
        </p>
            </div>
        <div class="card-body py-5">
            <form action="{{route('users.update',$user)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="text-center mb-5">
                @if($user->image)
                <img src="{{asset('user_images/'.$user->image)}}" class="rounded-circle shadow border" width="130" height="130" style="object-fit: cover; border-width:4px !important;">
                @else
                <div class="mx-auto rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow" style="width: 130px; height:130px;font-size:50px; font-weight:bold;">
                    {{strtoupper(substr($user->name,0,1))}}
                </div>
                @endif
                <h4 class="mt-3 font-weight-bold">
                    {{$user->name}}
                </h4>
                <p class="text-muted">
                    {{$user->email}}
                </p>
            </div>
            <div class="form-group mb-4">
                <label class="font-weight-bold"><i class="fas fa-user text-primary mr-1"></i>Name</label>
                <input type="text" name="name" value="{{$user->name}}" class="form-control form-control-lg rounded-pill shadow-sm @error('name') is-invalid @enderror" placeholder="Enter user name">
                @error('name')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group mb-4">
                <label class="font-weight-bold"><i class="fas fa-envelope text-info mr-1"></i>Email</label>
                <input type="email" name="email" value="{{$user->email}}" class="form-control form-control-lg rounded-pill shadow-sm @error('email') is-invalid @enderror" placeholder="Enter email address">
                @error('email')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group mb-4">
                <label class="font-weight-bold"><i class="fas fa-user-shield text-warning mr-1"></i>Role</label>
                <select name="role" class="form-control form-control-lg rounded-pill shadow-sm @error('role') is-invalid @enderror">
                    @foreach ($roles as $role)
                        <option value="{{$role->name}}" {{$user->hasRole($role->name)?'selected':''}}>{{$role->name}}</option>
                    @endforeach
                </select>
                @error('role')
                  <div class="invalid-feedback">
                    {{$message}}
                  </div>
                @enderror
            </div>
            <div class="form-group mb-4">
                <label class="font-weight-bold"><i class="fas fa-image text-success mr-1"></i>Change Profile Image</label>
                <input type="file" name="image" class="form-control-file">
                @error('image')
                <small class="text-danger">
                    {{$message}}
                </small>
                @enderror
            </div>
            <div class="d-flex justify-content-between mt-5">
                            <a href="{{route('users.index')}}" class="btn btn-secondary rounded-pill px-4 shadow-sm"><i class="fas fa-arrow-left mr-1"></i>Cancel</a>
            <button class="btn btn-warning rounded-pill px-5 shadow-sm text-white"><i class="fas fa-save mr-1"></i>Update User</button>
            </div>
            </form>
        </div>
    </div>
        </div>
    </div>
</div>
@endsection
