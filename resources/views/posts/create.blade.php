@extends('layouts.template')
@section('content')

<form action="{{ url('posts') }}" method="POST">
    @csrf
    <div class="col-md-8 offset-md-2">
    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
        <div class="form-group row">
            <label for="title" class="col-sm-2 col-form-label">Title</label>
            <div class="col-sm-10">
                <input type="text" value="{{ old('title') }}"  class="form-control" id="title" name="title" placeholder="Title">
            </div>
        </div>

        <div class="form-group row">
            <label for="content" class="col-sm-2 col-form-label">Content</label>
            <div class="col-sm-10">
                <textarea value="{{ old('content') }}" name="content" class="form-control" id="content" placeholder="Content">
                </textarea>
                {{-- <input type="text" value="{{ old('content') }}" name="content" class="form-control" id="content" placeholder="Content"> --}}
            </div>
        </div>
        <input type="submit" class="btn btn-primary btn-block" value="Post">

    </div>

</form>

@endsection
