<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



Route::get('/callback', 'TestController@index');
Route::group(['middleware' => ['authorizeDiscord']], function () {
    Route::get('/config', 'ConfigController@displayServers')->name('displayServers');
    Route::get('/config/edit/{serverId}', 'ConfigController@displayConfig')->name('editConfig');
    Route::post('/config/save/{serverId}', 'ConfigController@saveConfig');
});
Route::get('/meetings/{channelID}/{meetingName}', 'MeetingsController@index');
Route::get('/', 'HomeController@index');
Route::get('/docs', 'FeaturesController@index');
Route::get('/features', 'FeaturesController@index');
Route::get('/updates', 'ChangelogController@index');
Route::get('/contribute', 'ContributeController@index');
Route::get('/help', 'HelpController@index');
Route::get('/team', 'TeamController@index');
Route::get('/invite', 'InviteController@index');
Route::get('/config/login', 'ConfigController@login')->name('login');
Route::post('/config/edit', 'ConfigController@redirectConfig');
Route::get('/config/logout', 'ConfigController@logout')->name('logout');;
Route::any('/meetings/{channelID}/{meetingName}/meeting', 'MeetingsController@getMeeting');
