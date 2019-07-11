<?php

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', 'PropertiesController@index')->name('index.home');

// Для отладки класса(сервиса) Csv.php
//Route::get('/csv', 'PropertiesController@testCsv');
