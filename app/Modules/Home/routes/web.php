<?php

Route::group(['module' => 'Home', 'middleware' => ['web','prevent-back-history'], 'namespace' => 'App\Modules\Home\Controllers'], function() {

    Route::get('dashboard', 'HomeController@index')->name('dashboard.index');

});
