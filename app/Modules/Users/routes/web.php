<?php

Route::group(['module' => 'Users', 'middleware' => ['web','prevent-back-history'], 'namespace' => 'App\Modules\Users\Controllers'], function() {

    Route::get('user', 'UsersController@index')->name('users.index');
    Route::get('user/create', 'UsersController@getCreate')->name('users.create');
    Route::post('user/create-action', 'UsersController@postCreate')->name('users.create.action');

    Route::post('user/delete', 'UsersController@postDelete')->name('users.delete');
    Route::get('user/edit/{id}', 'UsersController@getEdit')->name('users.edit');
    Route::post('user/edit', 'UsersController@postEdit')->name('users.edit.action');

});
