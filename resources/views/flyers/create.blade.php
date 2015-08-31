@extends('layout')

@section('content')

    <h1>Have a property for sale? List With Us!</h1>

    <hr>

    <form method="POST" action="/flyers" enctype="multipart/form-data">
        @include('flyers.form')

        @include('errors')
    </form>
@stop