@extends('layouts.admin')
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-lg rounded-lg">
            <div class="card-header bg-primary text-white py-3">
            <h3 class="mb-0"><i class="fas fa-paper-plane mr-2"></i>Send Feedback</h3>
        </div>
        <div class="card-body p-4">
            @if(session('success'))
              <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle mr-1"></i>
                 {{session('success')}}
                 <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                 </button>
              </div>
            @endif
            <form action="{{route('feedback.store')}}" method="POST">
                @csrf
                <div class="form-group mb-4">
                    <label class="font-weight-bold">
                    <i class="fas fa-list-alt text-primary mr-1"></i>Feedback Type</label>
                    <select name="type" id="feedbackType" class="form-control">
                        <option value="issue">Issue</option>
                        <option value="improvement">Improvement</option>
                        @auth
                        <option value="contact_author">Contact Author</option>
                        @endauth
                    </select>
                </div>
                    @auth
                    <div class="form-group mb-4" id="userField" style="display: none;">
                        <label class="font-weight-bold"><i class="fas fa-user text-success mr-1"></i>Select User</label>
                        <select name="user_id" class="form-control form-control form-control-lg rounded-pill">
                            <option value="">Select User</option>
                            @foreach($users as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    @endauth
                    <div class="form-group mb-4">
                        <label class="font-weight-bold"><i class="fas fa-heading text-warning mr-1"></i>Subject</label>
                        <input type="text" name="subject" class="form-control form-control-lg rounded-pill" placeholder="Enter feedback subject">
                        @error('subject')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                        @enderror
                    </div>
                    <div class="form-group mb-4">
                        <label class="font-weight-bold">
                            <i class="fas fa-comment-dots text-info mr-1"></i>Message</label>
                        <textarea name="message" class="form-control rounded-lg" rows="6" placeholder="Write your feedback here..."></textarea>
                        @error('message')
                        <small class="text-danger">
                            {{$message}}
                        </small>
                        @enderror
                    </div>
                    <div class="text-right">
                    <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm">
                        <i class="fas fa-paper-plane mr-1"></i>
                        Submit
                    </button>
                    </div>
            </form>
        </div>
    </div>
    </div>
    </div>
</div>
<script>
    const feedbackType=document.getElementById('feedbackType');
    const userField=document.getElementById('userField');
    feedbackType.addEventListener('change',function(){
        if(this.value === 'contact_author')
        {
            userField.style.display='block';
        }else{
            userField.style.display='none';
        }
    });
</script>
@endsection

