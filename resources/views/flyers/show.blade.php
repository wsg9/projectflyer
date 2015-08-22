@extends('layout')

@section('content')
    <h1>{!! $flyer->street !!}</h1>
    <h2>{!! $flyer->price !!}</h2>

    <br>

    <div class="description">{!! nl2br($flyer->description) !!}</div>
@stop