@extends('layouts.admin')
@section('content')
<div class="container-fluid py-5">
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
        <div><h2 class="font-weight-bold mb-1"><i class="fas fa-users text-primary mr-2"></i>Users Management</h2>
             <p class="text-muted mb-0">
                Manage all registered users and their roles
             </p>
        </div>
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm">
            <i class="fas fa-check-circle mr-1"></i>
            {{session('success')}}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
        @endif
        <a href="{{route('users.create')}}" class="btn btn-primary rounded-pill shadow-sm px-4 mt-3 mt-md-0"><i class="fas fa-user-plus mr-1"></i>Create User</a>
    </div>
    <div class="card border-0 shadow-lg rounded-lg">
        <div class="card-body p-0">
            <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="bg-darktext-white">
            <tr>
                <th class="py-3 px-4">Name</th>
                <th class="py-3">Email</th>
                <th class="py-3">Role</th>
                <th class="py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td class="px-4">
                        <div class="d-flex align-items-center">
                            @if($user->image)
                <img src="{{asset('user_images/'.$user->image)}}" class="rounded-circle shadow-sm mr-3" width="55" height="55" style="object-fit: cover;">
                @else
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow-sm mr-3" style="width: 55px; height:55px;font-size:20px; font-weight:bold;">
                    {{strtoupper(substr($user->name,0,1))}}
                </div>
                @endif
                <div><h6 class="mb-0 font-weight-bold">{{ $user->name }}</h6>
                     <small class="text-muted">
                        Joined {{$user->created_at->format('d M Y')}}
                     </small>
                </div>
                        </div>
                </td>
                    <td><span class="text-muted">{{ $user->email }}</span></td>
                    <td>@php $role= $user->getRoleNames()->first();@endphp
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
                           <span class="badge badge-danger px-3 py-2">
                            <i class="fas fa-user mr-1"></i>{{$role??'User'}}
                           </span>
                           @endif
                    </td>
                    <td class="text-center">
                        <a href="{{route('users.show',$user)}}" class="btn btn-info btn-sm rounded-pill shadow-sm mb-1"><i class="fas fa-eye mr-1"></i>View</a>
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning rounded-pill shadow-sm mb-1"><i class="fas fa-edit mr-1"></i>Edit</a>
                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger rounded-pill shadow-sm mb-1"><i class="fas fa-trash mr-1"></i> Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-5">
                        <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">
                            No User Found
                        </h5>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center mt-4">
        {{ $users->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
