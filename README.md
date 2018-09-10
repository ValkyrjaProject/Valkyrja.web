Copyright © 2016 Radka Janek, [rhea-ayase.eu](http://rhea-ayase.eu)

![alt CC BY-NC-SA 4.0 license](https://i.creativecommons.org/l/by-nc-sa/4.0/88x31.png)

[Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International License](https://creativecommons.org/licenses/by-nc-sa/4.0/)



## Botwinder ![](https://api.travis-ci.org/RheaAyase/Botwinder.web.svg?branch=dev)
Please take a look at our website to see what the bot about, full list of features, invite and configuration: [http://botwinder.info](http://botwinder.info)

## Contributing

Please read the [Contributing file](CONTRIBUTING.md) before you start =)

If there is a security issue, contact `SpyTec#1329` on Discord or email spytec13+botwinder@gmail.com

## Self hosting

If you are self-hosting the Botwinder bot and want configuration dashboard, you'd have to run our website on a server that can connect to the self-hosted Botwinder's database.

## Requirements

* PHP 7.1
* MariaDB/MySQL

## Installation

1. `git clone https://github.com/RheaAyase/Botwinder.web.git` or download as zip
1. Copy `www/.env.example` to `www/.env`
1. Configure `.env` with MariaDB/MySQL database connection and OAuth2 variables and bot tokens
1. Point web server of choice to `www/public/`. For further information on configuring check-out Laravel's installation guide

If you want to run website locally without the bot, do this after step 3:

1. In `www/` do `php artisan migrate:install`
1. In `www/` do `php artisan db:seed`
