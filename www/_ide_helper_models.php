<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace Botwinder{
/**
 * Botwinder\Channel
 *
 * @property-read \Botwinder\ServerConfig $serverConfig
 */
	class Channel extends \Eloquent {}
}

namespace Botwinder{
/**
 * Botwinder\CustomCommand
 *
 */
	class CustomCommand extends \Eloquent {}
}

namespace Botwinder{
/**
 * Botwinder\Role
 *
 * @property-read \Botwinder\ServerConfig $serverConfig
 */
	class Role extends \Eloquent {}
}

namespace Botwinder{
/**
 * Botwinder\ServerConfig
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\Botwinder\Channel[] $channels
 * @property-read \Illuminate\Database\Eloquent\Collection|\Botwinder\CustomCommand[] $customCommands
 * @property-read \Illuminate\Database\Eloquent\Collection|\Botwinder\Role[] $roles
 */
	class ServerConfig extends \Eloquent {}
}

