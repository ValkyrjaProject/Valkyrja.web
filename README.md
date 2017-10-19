Copyright © 2016 Radka Janek, [rhea-ayase.eu](http://rhea-ayase.eu)

![alt CC BY-NC-SA 4.0 license](https://i.creativecommons.org/l/by-nc-sa/4.0/88x31.png)

[Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International License](https://creativecommons.org/licenses/by-nc-sa/4.0/)



## The Botwinder
Please take a look at our website to see what's the bot about, full list of features, invite and configuration: [http://botwinder.info](http://botwinder.info)

## Contributing

Please read the [Contributing file](CONTRIBUTING.md) before you start =)

If there is a security issue, contact SpyTec\#1329 on Discord or email spytec13+botwinder@gmail.com

## Self hosting

If you are self-hosting Botwinder and want configuration dashboard, you'd have to run our website on a server that can connect to the self-hosted Botwinder database.

## Requirements

* PHP 7
* MariaDB/MySQL

## Installation

1. `git clone https://github.com/RheaAyase/Botwinder.web.git` or download as zip
1. Copy `www/.env.example` to `www/.env`
1. Configure `.env` with MariaDB/MySQL database connection and OAuth2 and bot tokens and `APP_ENV` to `production`
1. Point web server of choice to `www/public/`. For further information on configuring check-out Laravel's installation guide

If you want to run website locally without the bot, do this after step 3:

1. In `www/` do `php artisan migrate:install --seed`

Some modifications are still required to fully configure the bot as we are currently not mocking the OAuth2 end.
