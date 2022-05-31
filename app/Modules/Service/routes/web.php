<?php

Route::group(['module' => 'Service', 'middleware' => ['web','prevent-back-history'], 'namespace' => 'App\Modules\Service\Controllers'], function() {

    Route::post('get-klasifikasi-surat', 'ServiceController@get_klasifikasi_surat')->name('service.klasifikasi_surat');
    Route::post('get-keamanan-surat', 'ServiceController@get_keamanan_surat')->name('service.keamanan_surat');
    Route::post('get-sifat-surat', 'ServiceController@get_sifat_surat')->name('service.sifat_surat');
    Route::post('get-kepada-opd', 'ServiceController@get_kepada_opd')->name('service.get_kepada_opd');
    Route::post('get-struktural-opd', 'ServiceController@get_pegawai_struktural_opd')->name('service.get_pegawai_struktural_opd');
    Route::get('get-bentuk-surat/{id}', 'ServiceController@get_bentuk_surat')->name('service.get_bentuk_surat');
    Route::post('get-tipe-ttd', 'ServiceController@get_tipe_ttd')->name('service.get_tipe_ttd');
    
});
