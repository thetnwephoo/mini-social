@extends('layouts.template')
@section('content')

<h2>
    {{ $post->title }}
    {{-- Component ေတြကို default သတ္မွတ္ခ်င္တယ္ဆိုရင္ AppServiceProvider ထဲမွာသြားပီးေတာ့ သတ္မွတ္ပါ။ --}}
    @badge(['show' => now()->diffInMinutes($post->created_at) < 40])
        New!
    @endbadge
</h2>

{{-- <p class="text-muted">
    Added {{ $post->created_at->diffForHumans() }}
    by {{ $post->user->name }}    
</p> --}}

@update(['date' => $post->created_at, 'name' => $post->user->name ])
@endupdate

{{-- @update(['date' => $post->updated_at, 'name' => $post->user->name ])
@endupdate --}}

<p>{{ $post->content }}</p>

@forelse($post->comments as $comment)
    <p>{{ $comment->content }}</p>
    {{-- <strong>added {{ $comment->created_at->diffForHumans()}}</strong> --}}
    @update(['date' => $comment->created_at ])
    @endupdate
@empty
    <p>No comment Yet!</p>
@endforelse

@endsection