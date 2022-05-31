<?php

Route::group(['module' => 'Roles', 'middleware' => ['api'], 'namespace' => 'App\Modules\Roles\Controllers'], function() {

    Route::resource('Roles', 'RolesController');

});
