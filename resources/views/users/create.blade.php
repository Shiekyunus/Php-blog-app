@extends('layouts.admin')
@section('content')
<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg rounded-lg rounded-lg overflow-hidden">
    <div class="bg-primary text-white text-center py-4">
        <h3 class="mb-0">
            <i class="fas fa-user-plus mr-2"></i>Create new User</h3>
        <small class="class=text-light">Add a new user to the system</small>
    </div>
    <div class="card-body p-5">
        <form action="{{route('users.store')}}" method="POST" enctype="multipart/form-data">
           @csrf
           <div class="form-group mb-4">
            <label class="font-weight-bold"><i class="fas fa-user text-primary mr-1"></i>Name</label>
            <input type="text" name="name" class="form-control form-control-lg rounded-pill shadow-sm @error('name') is-invalid @enderror" value="{{old('name')}}" placeholder="Enter full name">
            @error('name')
              <small class="text-danger">{{$message}}</small>
            @enderror
           </div>
           <div class="form-group mb-4">
            <label class="font-weight-bold"><i class="fas fa-envelope text-info mr-1"></i>Email</label>
            <input type="email" name="email" class="form-control form-control-lg rounded-pill shadow-sm @error('email') is-invalid @enderror" value="{{old('email')}}" placeholder="Enter email address">
            @error('email')
               <small class="text-danger">{{$message}}</small>
            @enderror
           </div>
           <div class="form-group mb-3">
            <label class="font-weight-bold"><i class="fas fa-lock text-warning mr-1"></i>Password</label>
            <input type="password" name="password" class="form-control form-control-lg rounded-pill shadow-sm @error('password') is-invalid @enderror" placeholder="Enter password">
            @error('password')
              <small class="text-danger">{{$message}}</small>
            @enderror
           </div>
           <div class="form-group mb-4">
            <label class="font-weight-bold"><i class="fas fa-user-tag text-success mr-1"></i>Role</label>
            <select name="role" class="form-control form-control-lg rounded-pill shadow-sm">
                @foreach($roles as $role)
                   <option value="{{$role->name}}">{{$role->name}}</option>
                @endforeach
            </select>
           </div>
           <div class="form-group mb-4">
            <label class="font-weight-bold"><i class="fas fa-image text-secondary mr-1"></i>Profile Image</label>
            <input type="file" name="image" class="form-control-file">
           </div>
           <div class="d-flex justify-content-between">
            <a href="{{route('users.index')}}" class="btn btn-secondary rounded-pill px-4"><i class="fas fa-arrow-left mr-1"></i>Cancel</a>
           <button type="submit" class="btn btn-success rounded-pill px-5 shadow-sm"><i class="fas fa-save mr-1"></i>Save User</button>
           </div>
        </form>
    </div>
            </div>
        </div>
    </div>
</div>
@endsection
