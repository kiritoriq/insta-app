<?php

Route::group(['module' => 'Home', 'middleware' => ['web','prevent-back-history'], 'namespace' => 'App\Modules\Home\Controllers'], function() {

    Route::get('dashboard', 'HomeController@index')->name('dashboard.index');

    Route::post('laporan/load-data-rs', 'HomeController@loadDataTablesRS')->name('load-data-rs');
    Route::post('laporan/load-data-dir-rs', 'HomeController@loadDataTablesDirRS')->name('load-data-dir-rs');
    Route::post('laporan/load-data-puskesmas', 'HomeController@loadDataTablesPuskesmas')->name('load-data-puskesmas');
    Route::post('laporan/load-data-grafik', 'HomeController@loadDataGrafik')->name('load-data-grafik');

    Route::get('dashboard/page-grafik-aduan', 'HomeController@getPageAduan')->name('load-page-aduan');
    Route::post('laporan/load-data-grafik-aduan', 'HomeController@loadDataGrafikAduan')->name('load-data-grafik-aduan');

    // Route submenu dashboard
    Route::get('dashboard/data-faskes', 'HomeController@getDataFaskes')->name('dashboard.data-faskes');
    Route::get('dashboard/data-lain', 'HomeController@getDataLain')->name('dashboard.data-lain');

});
