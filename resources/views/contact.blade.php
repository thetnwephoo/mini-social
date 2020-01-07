@extends('layouts.template')
@section('content')
    <h4> This is Contact Page </h4>
    @can('contact.secret')
        <a href="{{ route('secret') }}"> Go To Secret page </a>
    @endcan
@endsection
