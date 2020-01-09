@extends('layouts.template')
@section('content')
<div class="row">
    <div class="col-md-8">
        @foreach($posts as $post)
                <h2>
                    @if($post->trashed())
                        <del>
                    @endif
                    <a href="{{ url('posts/'.$post->id) }}" class="{{ $post->trashed() ? 'text-danger' : 'text-primary' }}">{{ $post->title }}</a>
                    @if($post->trashed())
                        </del>
                    @endif
                </h2>

            {{-- <p class="text-muted">
                Added {{ $post->created_at->diffForHumans() }}
                by {{ $post->user->name }}    
            </p> --}}

            @update(['date' => $post->created_at, 'name' => $post->user->name ])
            @endupdate


            @if($post->comments_count)
                <p>{{ $post->comments_count }} comments</p>
            @else
                <p>No comment yet</p>
            @endif
            {{-- Can ဆိုတာ policy ထဲမွာရွိတဲ့ method ကိုလွမ္းေခၚတာ။ --}}
            @can('update', $post) 
                <a href=" {{ url('posts/'.$post->id.'/edit') }} " class="btn btn-sm btn-primary">Edit</a>
            @endcan 
            {{-- 

            can အျပင္ cannot ကိုလဲသံုးလို့ရပါေသးတယ္
            ဥပမာ ျပထားတာပါ သံုးခ်င္လဲသံုးလို့ရပါတယ္။ 
            
            --}}

            {{-- @cannot('delete', $post)
                <p> မင္းျဖတ္လို့မရဘူး! </p>
            @endcannot --}}

            @if(!$post->trashed())
            @can('delete', $post)
                <!-- <a href="{{ url('posts/'.$post->id) }}" class="btn btn-sm btn-danger"
                    onClick="event.preventDefault(); document.getElementById('delete-form').submit();" 
                >Delete {{ $post->id }}</a> -->
                <form action="{{ route('posts.destroy',['$post' => $post->id]) }}" method="POST" style="display:inline;">
                    @method('DELETE')
                    @csrf
                    <input type="submit" value="Delete" class="btn btn-sm btn-danger">
                </form>
            @endcan
            @endif
        @endforeach
    </div>
    <div class="col-md-4">
        <div class="container">

            @card(['title' => 'Most Commented!'])
                @slot('users')
                     @foreach($mostCommented as $post)
                        <li class="list-group-item">
                            <a href="{{ url('posts/'.$post->id) }}">{{ $post->title }}</a>
                        </li>
                    @endforeach
                @endslot
            @endcard

            {{-- <div class="row">
                <div class="card" style="width: 100%;">
                    <div class="card-header">
                        <h4> Most Commented! </h4>
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach($mostCommented as $post)
                                <li class="list-group-item">
                                    <a href="{{ url('posts/'.$post->id) }}">{{ $post->title }}</a>
                                </li>
                        @endforeach
                    </ul>
                </div>
            </div> --}}

            <div class="row mt-4">
                {{-- <div class="card" style="width: 100%;">
                    <div class="card-header">
                        <h4> Most Posted Users! </h4>
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach($mostPostedUsers as $user)
                                <li class="list-group-item">
                                    <a href="{{ url('posts/'.$post->id) }}">{{ $user->name }}</a>
                                </li>
                        @endforeach
                    </ul>
                </div> --}}
                @card(['title' => 'Most Posted Users!'])
                    @slot('users', collect($mostPostedUsers)->pluck('name'))
                @endcard
            </div>

        </div>
    </div>
</div>
@endsection