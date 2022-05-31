<?php

Route::group(['module' => 'Roles', 'middleware' => ['web'], 'namespace' => 'App\Modules\Roles\Controllers'], function() {

    Route::resource('roles', 'RolesController');

});
