<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace Valkyrja{
/**
 * Valkyrja\Channel
 *
 * @property-read \Valkyrja\ServerConfig $serverConfig
 */
	class Channel extends \Eloquent {}
}

namespace Valkyrja{
/**
 * Valkyrja\CustomCommand
 *
 */
	class CustomCommand extends \Eloquent {}
}

namespace Valkyrja{
/**
 * Valkyrja\Role
 *
 * @property-read \Valkyrja\ServerConfig $serverConfig
 */
	class Role extends \Eloquent {}
}

namespace Valkyrja{
/**
 * Valkyrja\ServerConfig
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\Valkyrja\Channel[] $channels
 * @property-read \Illuminate\Database\Eloquent\Collection|\Valkyrja\CustomCommand[] $customCommands
 * @property-read \Illuminate\Database\Eloquent\Collection|\Valkyrja\Role[] $roles
 */
	class ServerConfig extends \Eloquent {}
}

