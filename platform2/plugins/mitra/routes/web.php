<?php

Route::group(['namespace' => 'Botble\Mitra\Http\Controllers', 'middleware' => ['web', 'core']], function () {

    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'mitras', 'as' => 'mitra.'], function () {
            Route::resource('', 'MitraController')->parameters(['' => 'mitra']);
            Route::delete('items/destroy', [
                'as' => 'deletes',
                'uses' => 'MitraController@deletes',
                'permission' => 'mitra.destroy',
            ]);
        });
    });

});
