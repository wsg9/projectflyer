@extends('layout')

@section('content')

    <h1>Have a property for sale? List With Us!</h1>

    <hr>

    <form method="POST" action="/flyer" enctype="multipart/form-data">
        @include('flyer.form')

        @include('errors')
    </form>
@stop