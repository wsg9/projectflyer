<?php

Route::get('/', function () {
    return view('pages.home');
});

Route::get('pages/search', 'SearchController@index');

Route::resource('flyers', 'FlyersController');
Route::get('{zip}/{street}', 'FlyersController@show');