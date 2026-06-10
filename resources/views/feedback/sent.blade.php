@extends('layouts.admin')
@section('content')
<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <div>
            <h2 class="font-weight-bold mb-1"><i class="fas fa-paper-plane text-success mr-2"></i>Sent Feedbacks</h2>
            <p class="text-muted mb-0">
                View all feedback messages sent by you
            </p>
        </div>
        <div class="mt-3 mt-md-0">
        <a href="{{route('feedback.create')}}" class="btn btn-primary rounded-pill shadow-sm mr-2">
            <i class="fas fa-plus-circle mr-1"></i>
            Create Feedback
        </a>
        @can('review feedback')
        <a href="{{route('feedback.reviewed')}}" class="btn btn-success rounded-pill shadow-sm">
            <i class="fas fa-inbox mr-1"></i>
            Reviewed Feedbacks
        </a>
        @endcan
        </div>
    </div>
    <div class="card border-0 shadow-lg rounded-lg">
        <div class="card-body p-0">
            <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-dark text-white">
                <tr>
                    <th class="py-3 px-3">Type</th>
                    <th class="py-3">Subject</th>
                    <th class="py-3">To</th>
                    <th class="py-3">Status</th>
                    <th class="py-3">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($feedbacks as $feedback)
                <tr>
                    <td class="px-3">
                         @if($feedback->type=='issue')
                              <span class="badge badge-danger px-3 py-2">
                                <i class="fas fa-bug mr-1"></i>Issue
                              </span>
                            @elseif($feedback->type=='improvement')
                              <span class="badge badge-info px-3 py-2">
                                <i class="fas fa-lightbulb mr-1"></i>
                                Improvement
                              </span>
                            @else
                                <span class="badge badge-warning px-3 py-2">
                                    <i class="fas fa-user-edit mr-1"></i>
                                    Contact Author
                                </span>
                                @endif
                    </td>
                    <td>
                        <strong>{{$feedback->subject}}</strong></td>
                        <td class="d-flex align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mr-2" style="width:40px;height:40px;">
                                    <i class="fas fa-user"></i>
                                </div>
                        <div>
                            <strong>
                            {{ $feedback->receiver->name ?? 'Management' }}
                            </strong>
                        </div>
                            </div>
                        </td>
                    <td>@if($feedback->status == 'open')
                              <span class="badge badge-primary px-3 py-2">
                                Open
                              </span>
                              @elseif($feedback->status == 'reviewed')
                              <span class="badge badge-warning px-3 py-2">
                                Reviewed
                              </span>
                              @else
                              <span class="badge badge-success px-3 py-2">
                                Closed
                              </span>
                              @endif
                            </td>
                    <td class="text-muted">{{$feedback->created_at->format('d M Y')}}</td>
                </tr>
                @empty
                <tr>
                  <td colspan="5" class="text-center py-5">
                    <i class="fas fa-paper-plane fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">
                        No Sent Feedbacks Found
                    </h5>
                  </td>
                  </tr>
                @endforelse
            </tbody>
        </table>
            </div>
            <div class="d-flex justify-content-center mt-4">{{$feedbacks->links('pagination::bootstrap-4')}}</div>
        </div>
    </div>
</div>
@endsection
