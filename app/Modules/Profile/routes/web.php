<?php

Route::group(['module' => 'Profile', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Profile\Controllers'], function() {

    // Follow
    Route::post('profile/follow/{user_id}', [ProfileController::class, 'follow'])->name('profile.follow');

    Route::get('settings/{user_id}', [ProfileController::class, 'index'])->name('profile.settings');
    Route::resource('profile', 'ProfileController');

});
