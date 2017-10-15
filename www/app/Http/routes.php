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

Route::get('/config', function () {
    return view('errors.unavailable');
});
/*Route::group(['prefix' => 'config'], function () {
    Route::get('/login', 'ConfigController@login')->name('login');
    Route::get('/logout', 'ConfigController@logout')->name('logout');;
    Route::post('/edit', 'ConfigController@redirectConfig');

    Route::group(['middleware' => ['authorizeDiscord']], function () {
        Route::get('/', 'ConfigController@displayServers')->name('displayServers');
        Route::get('/edit/{serverId}', 'ConfigController@displayConfig')->name('editConfig');
        Route::post('/save/{serverId}', 'ConfigController@saveConfig');
    });
});*/

Route::get('/', 'HomeController@index');
Route::get('/docs', function () {
    return view('errors.unavailable');
});
Route::get('/features', function () {
    return view('errors.unavailable');
});
/*Route::get('/docs', 'FeaturesController@index');
Route::get('/features', 'FeaturesController@index');*/
Route::get('/updates', 'ChangelogController@index');
Route::get('/contribute', 'ContributeController@index');
Route::get('/help', 'HelpController@index');
Route::get('/team', 'TeamController@index');
Route::get('/invite', 'InviteController@index');
Route::get('/meetings/{channelID}/{meetingName}', 'MeetingsController@index');
Route::any('/meetings/{channelID}/{meetingName}/meeting', 'MeetingsController@getMeeting');

/*Route::group(['middleware' => ['authorizeDiscord', 'authorizeAdmins']], function () {
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
});
Route::group(['prefix' => 'api', 'middleware' => ['authorizeDiscord']], function () {
    Route::get('roles/{serverId}', 'ApiController@getRoles');
    //Route::get('roles/{serverId}/{configAttribute}', 'ApiController@getRolesData');

    Route::get('channels/{serverId}', 'ApiController@getChannels');
    //Route::get('channels/{serverId}/{configAttribute}', 'ApiController@getChannelsData');

    Route::get('data/{serverId}/{configAttribute}', 'ApiController@getData');

    Route::get('botwinderCommands', 'ApiController@getBotwinderCommands');
});*/