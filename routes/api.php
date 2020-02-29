<?php

Route::group(['prefix' => 'auth'], function() {
   Route::post('/login', 'Api\AuthController@login');
});


