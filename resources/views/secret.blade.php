@extends('layouts.template')
@section('content')
    <h4> This is Secret Page </h4>
    @can('contact.secret')
        <p> For Admin </p>
    @endcan
@endsection