<?php

namespace Valkyrja\Logic;

use Illuminate\Support\Collection;

interface DiscordDataInterface
{

    /**
     * @param $serverId
     * @return Collection|null
     */
    public function getGuild($serverId);
}
