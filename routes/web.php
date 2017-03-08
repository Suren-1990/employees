<?php

include_once(APP_PATH . 'Base/Route.php');
include_once(APP_PATH . 'Base/View.php');

Route::set('/', 'HomeController@index');

Route::set('/home', function () {
    return View::make('home');
});

Route::set('/store', 'HomeController@store');

Route::set('/edit', 'HomeController@edit');

Route::set('/update', 'HomeController@update');

Route::set('/delete', 'HomeController@destroy');

Route::set('/multi-delete', 'HomeController@multiDestroy');


Route::set('/search', 'HomeController@search');
