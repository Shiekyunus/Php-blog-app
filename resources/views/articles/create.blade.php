@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card card-primary card-outline shadow-sm">
                <div class="card-header">
                    <h4 class="card-title mb-0"><i class="fas fa-newspaper mr-2"></i> Create Article
                    </h4><br>
                    <small class="text-muted">
                        Write and publish a new blog article
                    </small>
                </div>
    <form action="{{route('articles.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
     <div class="card-body">
     <div class="form-group">
        <label>
            <i class="fas fa-heading mr-1"></i> Title
        </label>
        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{old('title')}}" placeholder="Enter article title">
        @error('title')
           <div class="invalid-feedback">
            {{$message}}
           </div>
        @enderror
     </div>
     <div class="form-group">
        <label>
           <i class="fas fa-folder mr-1"></i> Category
        </label>
        <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
            <option value="">
                Select Category
            </option>
            @foreach ($categories as $category)
                <option value="{{$category->id}}" {{old('category_id')==$category->id ? 'selected' :''}}>
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
            <i class="fas fa-tags mr-1"></i>Tags
        </label>
        <select name="tags[]" multiple class="form-control @error('tags') is-invalid @enderror">
            @foreach ($tags as $tag)
                    <option value="{{$tag->id}}" {{collect(old('tags'))->contains($tag->id)? 'selected':''}}>
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
                <i class="fas fa-image mr-1"></i>Featured Image
            </label>
            <input type='file' name="image" class="form-control">
            @error('image')
             <small class="text-danger">
                {{$message}}
             </small>
            @enderror
        </div>
        <div class="form-group">
            <label>
                <i class="fas fa-align-left mr-1"></i>Content
            </label>
            <textarea name="body" rows="10" class="form-control @error('body') is-invalid @enderror" placeholder="Write your article content here...">{{old('body')}}</textarea>
            @error('body')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
            @enderror
        </div>
     </div>
     <div class="card-footer d-flex justify-content-between">
        <a href="{{route('articles.index')}}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Back
        </a>
     <div>
        <button type="submit" name="publish" value="0" class="btn btn-warning mr-2">
          <i class="fas fa-save mr-1"></i>  Save Draft
        </button>
        <button type="submit" name="publish" value="1" class="btn btn-success">
            <i class="fas fa-paper-plane mr-1"></i> Publish
        </button>
     </div>
     </div>
    </form>
</div>
        </div>
    </div>
</div>
@endsection
