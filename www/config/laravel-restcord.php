<?php

return [

    // Your application's bot token
    'bot-token' => getenv('DISCORD_BOT_TOKEN'),

    // Whether or not an exception is thrown when a ratelimit is supposed to hit
    'throw-exception-on-rate-limit' => getenv('DISCORD_USE_EXCEPTIONS', true),

    // Class to be invoked when a webhook has been created
    // replace this with your owner handler implementaton or add an IOC binding for this class
    'webhook-created-handler' => \LaravelRestcord\Discord\Webhooks\HandlesDiscordWebhooksBeingCreated::class,

    // Class to be invoked when a bot has been added to a guild
    // replace this with your owner handler implementaton or add an IOC binding for this class
    'bot-added-handler' => \LaravelRestcord\Discord\Bots\HandlesBotAddedToGuild::class,
];
