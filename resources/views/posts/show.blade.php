@extends('layouts.template')
@section('content')

<h2>{{ $post->title }}</h2>
<p class="text-muted">
    Added {{ $post->created_at->diffForHumans() }}
    by {{ $post->user->name }}    
</p>
<p>{{ $post->content }}</p>
@if((new Carbon\Carbon())->diffInMinutes($post->created_at) < 5)
    New
@endif
@forelse($post->comments as $comment)
    <p>{{ $comment->content }}</p>
    <strong>added {{ $comment->created_at->diffForHumans()}}</strong>
    <br/>
@empty
    <p>No comment Yet!</p>
@endforelse

@endsection