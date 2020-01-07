@extends('layouts.template')
@section('content')

<form action="{{ url('posts/'.$post->id) }}" method="post">
    @csrf
    @method('PUT')
    <div class="col-md-8 offset-md-2">
    
        <div class="form-group row">
            <label for="title" class="col-sm-2 col-form-label">Title</label>
            <div class="col-sm-10">
                <input type="text" value="{{ old('content', $post->title) }}"  class="form-control" id="title" name="title" placeholder="Title">
            </div>
        </div>

        <div class="form-group row">
            <label for="content" class="col-sm-2 col-form-label">Content</label>
            <div class="col-sm-10">
                <textarea name="content" class="form-control" id="content" placeholder="Content">
                    {{ old('content', $post->content) }}
                </textarea>
                {{-- <input type="text" name="content" class="form-control" id="content" placeholder="Content"> --}}
            </div>
        </div>
        <input type="submit" class="btn btn-primary btn-block" value="Post">

    </div>

</form>

@endsection