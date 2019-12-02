<?php

Route::view('/', 'home')->name('home');
Route::view('/docs', 'docs')->name('docs');
Route::redirect('/features', '/docs');
Route::view('/help', 'help')->name('help');
Route::view('/invite', 'invite')->name('invite');
Route::view('/team', 'team')->name('team');

Route::get('/login', 'LoginController@login')->name('login')->middleware('sessionHasDiscordToken');
Route::get('/logout', 'LoginController@logout')->name('logout');

Route::prefix('config')->namespace('Config')->middleware(['sessionHasDiscordToken'])->group(function () {
    Route::get('/', 'ConfigController@index')->name('displayServers')->middleware('auth.discord');
    Route::get('/{serverId}/{name?}', 'ConfigController@edit')
        ->name('editConfig')
        ->where('serverId', '[0-9]+');
    Route::post('/{serverId}', 'ConfigController@update')
        ->where('serverId', '[0-9]+');
});

Route::prefix('api')->namespace('Config')->middleware(['sessionHasDiscordToken', 'auth.discord'])->group(function () {
    Route::get('/guilds', 'ApiController@guilds');
    Route::get('/user', 'ApiController@user');
    Route::get('/server/{serverConfig}', 'ApiController@config');
    Route::post('/server/{serverConfig}', 'ApiController@update')
        ->where('serverId', '[0-9]+');
});
