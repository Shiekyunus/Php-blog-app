@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="mb-0">About Us</h3>
            <small class="text-muted">Learn more about our blog platform</small>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4>Welcome to Our Blog</h4>
                    <p>
                        This is a modern blogging platform built using laravel and AdminLTE.
                        It allows user to read , write and interact with articles in clear and structured environment.
                    </p>
                    <p>
                        Our system supports user authentication , role-based access , article publishing , categories , tags ,likes , saved articles , comments and notifications
                    </p>
                    <hr>
                    <h5>What We offer</h5>
                    <ul>
                        <li>Read high-quality articles</li>
                        <li>Write and published your own content</li>
                        <li>Organize posts using categories and tags</li>
                        <li>Like and save favories articles</li>
                        <li>Read-time notifications</li>
                        <li>User profile management</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm mb-3">
                <div class="card-body text-center">
                    <h5>Our Mission</h5>
                    <p class="text-muted">
                        to build a simple and powerful platform where knowledge is shared freely
                    </p>
                </div>
            </div>
            <div class="card shadow-sm mb-3">
                <div class="card-body text-center">
                    <h5>Our Vision</h5>
                    <p class="text-muted">
                        To belcome a trusted blogging ecosystem for developers and writers.
                    </p>
                </div>
            </div>
            <div class="card shodow-sm">
                <div class="card-body text-center">
                    <h5>Contact</h5>
                    <p class="mb-1">
                        support@blog.com
                    </p>
                    <p class="mb-0">
                        www.blog.com
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
