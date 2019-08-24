<?php

namespace Valkyrja\Http\Controllers\Config;

use Illuminate\Http\Response;
use Illuminate\View\View;
use Valkyrja\Http\Controllers\Controller;
use Valkyrja\Http\Requests\UpdateServerConfig;
use Valkyrja\Models\ServerConfig;
use Illuminate\Http\Request;
use function MongoDB\BSON\toJSON;

class ConfigController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        return view('config/guilds');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $serverId
     * @return View
     */
    public function edit($serverId)
    {
        return view('config/edit', [
            'serverId' => $serverId
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateServerConfig $request
     * @param  ServerConfig $serverConfig
     * @return array
     */
    public function update(UpdateServerConfig $request, ServerConfig $serverConfig)
    {
        return $request->validated();
        // Expect to be authorized
        // replace Request method injection with form validation
        // Save to tables
        // Redirect with message
    }

}
