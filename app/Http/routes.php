<?php

Route::get('/', function () {
    return view('pages.home');
});

Route::get('{zip}/{street}', 'FlyersController@show');
Route::resource('flyers', 'FlyersController');