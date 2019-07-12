<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// api search props
Route::get('search', 'Api\APIPropsController@apiSearch');

// resource
Route::resource('prop', 'Api\APIPropsController')
    ->except(['create', 'edit']);