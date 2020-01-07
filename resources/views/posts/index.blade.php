@extends('layouts.template')
@section('content')
<div class="row">
    <div class="col-md-8">
        @foreach($posts as $post)
            <h2><a href="{{ url('posts/'.$post->id) }}">{{ $post->title }}</a></h2>

            <p class="text-muted">
                Added {{ $post->created_at->diffForHumans() }}
                by {{ $post->user->name }}    
            </p>


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

            @can('delete', $post)
                <a href="{{ url('posts/'.$post->id) }}" class="btn btn-sm btn-danger"
                    onClick="event.preventDefault(); document.getElementById('delete-form').submit();" 
                >Delete</a>
                <form action="{{ url('posts/'.$post->id) }}" id="delete-form" method="POST" style="display:none;">
                    @method('DELETE')
                    @csrf
                </form>
            @endcan
            <br/>
        @endforeach
    </div>
    <div class="col-md-4">
        <div class="list-group">
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
@endsection