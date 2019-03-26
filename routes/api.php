<?php

Route::namespace('Auth')->group(function () {
    Route::post('login', 'LoginController@login');
    Route::post('register', 'RegisterController@register');
    Route::post('logout', 'LogoutController@logout');
    Route::get('me', 'MeController@me');

});
// Route::post('logout', 'AuthController@logout');