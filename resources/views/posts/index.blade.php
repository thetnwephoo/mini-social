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
    <div class="col-md-4" style="position:absolute !important; right:0">
        <div class="container">
            <div class="row">
                <div class="list-group" style="position:fixed;">
                    <a href="#" class="list-group-item list-group-item-action active">
                        <h4> Most Commented! </h4>
                        What people are currently talking about.
                    </a>
                    @foreach($mostCommented as $post)
                        <a href="{{ url('posts/'.$post->id) }}" class="list-group-item list-group-item-action">{{ $post->title }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection