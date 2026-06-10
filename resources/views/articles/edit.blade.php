@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card card-warning card-outline shadow-sm">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Article
                    </h4><br>
                    <small class="text-muted d-block">
                        Update your article details and publish settings
                    </small>
                </div>
    <form action="{{route('articles.update',$article)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
            <label>
                <i class="fas fa-heading mr-1"></i>
                Title
            </label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{old('title',$article->title)}}" placeholder="Enter article title">
            @error('title')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label>
                <i class="fas fa-folder mr-1"></i>
                Category
            </label>
            <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                @foreach ($categories as $category )
                  <option value="{{$category->id}}" @selected(old('category_id',$article->category_id)==$category->id)>
                     {{$category->name}}
                  </option>
                @endforeach
            </select>
            @error('category_id')
              <div class="invalid-feedback">
                {{$message}}
              </div>
            @enderror
        </div>
        <div class="form-group">
            <label>
                <i class="fas fa-tags mr-1"></i>
                Tags
            </label>
            <select name="tags[]" multiple class="form-control @error('tags') is-invalid @enderror">
                @foreach ($tags as $tag)
                    <option value="{{$tag->id}}" @selected(collect(old('tags',$article->tags->pluck('id')))->contains($tag->id))>
                        {{$tag->name}}
                    </option>
                @endforeach
            </select>
            @error('tags')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label>
                <i class="fas fa-image mr-1"></i>
                Current Image
            </label>
            <div class="mt-2">
            @if ($article->image)
                <img src="{{asset('storage/'.$article->image)}}" class="img-fluid rounded shadow-sm border" style="max-height:250px;">
            @else
               <div class="alert alert-light border mb-0">
                No image uploaded
               </div>
               @endif
            </div>
        </div>
        <div class="form-group">
            <label>
                <i class="fas fa-upload mr-1"></i>
                Change Image
            </label>
            <input type="file" name="image" class="form-control">
            @error('image')
              <small class="text-danger">{{$message}}</small>
              @enderror
        </div>
        <div class="form-group">
            <label>
                <i class="fas fa-align-left mr-1"></i>
                Content
            </label>
            <textarea name="body" rows="10" class="form-control @error('body') is-invalid @enderror" placeholder="Write your article content here...">{{old('body',$article->body)}}</textarea>
            @error('body')
              <div class="invalid-feedback">
                {{$message}}
              </div>
              @enderror
        </div>
        <div class="form-group">
            <label>
                <i class="fas fa-toggle-on mr-1"></i>
                Status
            </label>
            <select name="publish" class="form-control">
                <option value="0" @selected(!$article->is_published)>
                    Draft
                </option>
                <option value="1" @selected($article->is_published)>
                    Published
                </option>
            </select>
        </div>
        </div>
        <div class="card-footer d-flex justify-content-between">
            <a href="{{route('articles.index')}}" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-1"></i>
                Back
            </a>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save mr-1"></i>
            Update Article
        </button>
        </div>
    </form>
            </div>
        </div>
    </div>
</div>
@endsection
