<?php

namespace Botwinder\Logic;

use Illuminate\Support\Collection;

interface DiscordDataInterface
{

    /**
     * @param $serverId
     * @return Collection|null
     */
    public function getGuild($serverId);
}
