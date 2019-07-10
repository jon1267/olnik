<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// resource
Route::resource('props', 'APIPropsController')
    ->except(['create']);