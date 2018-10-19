Copyright © 2016 Radka Janek, [rhea-ayase.eu](http://rhea-ayase.eu)

![alt CC BY-NC-SA 4.0 license](https://i.creativecommons.org/l/by-nc-sa/4.0/88x31.png)

[Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International License](https://creativecommons.org/licenses/by-nc-sa/4.0/)



## Valkyrja ![](https://api.travis-ci.org/RheaAyase/Valkyrja.web.svg?branch=dev)
Please take a look at our website to see what the bot about, full list of features, invite and configuration: [https://valkyrja.app](https://valkyrja.app)

## Contributing

Please read the [Contributing file](CONTRIBUTING.md) before you start =)

If there is a security issue, contact `SpyTec#1329` on Discord or email spytec13+valkyrja@gmail.com

## Self hosting

If you are self-hosting the Valkyrja bot and want configuration dashboard, you'd have to run our website on a server that can connect to the self-hosted Valkyrja's database.

## Requirements

* PHP 7.1
* MariaDB/MySQL

## Installation

1. `git clone https://github.com/RheaAyase/Valkyrja.web.git` or download as zip
1. Copy `www/.env.example` to `www/.env`
1. Configure `.env` with database connection and OAuth2 variables and bot tokens
1. Run `docker-compose up`

If you want to run website locally without the bot, do the following:

With docker:
1. `docker-compose exec app php artisan key:generate`
1. `docker-compose exec app php artisan migrate:fresh`
1. `docker-compose exec app php artisan db:seed`

Without Docker:
1. In `www/` do `php artisan key:generate`
1. In `www/` do `php artisan migrate:fresh`
1. In `www/` do `php artisan db:seed`
