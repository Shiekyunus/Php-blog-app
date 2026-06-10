@extends('layouts.admin')

@section('content')
<div class="container-fluid py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="font-weight-bold"><i class="fas fa-bell text-warning mr-2"></i>Notifications</h2>
        <p class="text-muted mb-0">Your latest updates</p>
    </div>
        <form action="{{route('notifications.readAll')}}" method="POST">
            @csrf
            <button class="btn btn-sm btn-success rounded-pill shadow-sm"><i class="fas fa-check-double mr-1"></i>Mark All as Read</button>
        </form>
    </div>
    <div class="row">
        <div class="col-lg-8">
       @forelse ($notifications as $notification)
          <div class="card border-0 shadow-sm mb-3 rounded-lg {{$notification->read_at?'bg-light':'border-primary'}}">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-1 font-weight-bold">
                        <i class="fas fa-info-circle text-primary mr-1"></i>
                        {{$notification->data['message']?? 'Notification'}}
                    </p>
                    <small class="text-muted">
                        <i class="fas fa-clock mr-1"></i>
                        {{$notification->created_at->diffForHumans()}}
                    </small>
                </div>
                <div class="d-flex align-items-center">
                    @if(!$notification->read_at)
                      <form action="{{route('notifications.read',$notification->id)}}" method="POST" class="mr-2">
                        @csrf
                        <button class="btn btn-sm btn-primary btn-sm rounded-pill">
                            Mark as Read
                        </button>
                      </form>
                    @else
                      <span class="badge badge-success px-3 py-2">
                        Read
                      </span>
                      @endif
                </div>
            </div>
          </div>
        @empty
           <div class="text-center py-5">
            <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">No Notifications Found</h5>
           </div>
       @endforelse
       <div class="d-flex justify-content-center mt-4">
        {{$notifications->links('pagination::bootstrap-4')}}
       </div>
        </div>
    </div>
</div>
@endsection
