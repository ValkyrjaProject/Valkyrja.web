<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index');
Route::get('/docs', 'FeaturesController@index');
Route::redirect('/features', '/docs');
//Route::get('/features', 'FeaturesController@index');
Route::get('/updates', 'ChangelogController@index');
Route::get('/help', 'HelpController@index');
Route::get('/team', 'TeamController@index');
Route::get('/invite', 'InviteController@index');
Route::get('/meetings/{channelID}/{meetingName}', 'MeetingsController@index');
Route::any('/meetings/{channelID}/{meetingName}/meeting', 'MeetingsController@getMeeting');


/*Route::resource('config', 'ConfigController', ['except' =>[
    'create', 'store', 'show', 'destroy'
]]);*/

Route::get('/login', 'LoginController@login')->name('login');
Route::get('/logout', 'LoginController@logout')->name('logout');
Route::group(['prefix' => 'config'], function () {
    Route::post('/edit', 'ConfigController@redirectConfig');
    Route::group(['middleware' => ['authorizeDiscord']], function () {
        Route::get('/', 'ConfigController@index')->name('displayServers');
        Route::get('/{serverId}/edit', 'ConfigController@edit')->name('editConfig');
        Route::post('/{serverId}', 'ConfigController@update');
    });
});
