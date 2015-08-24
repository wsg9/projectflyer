<?php

Route::get('/', function () {
    return view('pages.home');
});

Route::resource('flyers', 'FlyersController');
Route::get('{zip}/{street}', 'FlyersController@show');
Route::post('{zip}/{street}/photos', 'FlyersController@addPhoto');