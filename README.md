# Craft PHP FPM Status Monitor

Craft PHP FPM Status Monitor is a Craft CMS 3 plugin that allows you to monitor PHP FPM status from within the Craft CMS control panel dashboard.

This plugin is a work in progress.


## Requirements

* PHP 8.0 (_probably_ works with 7.4 as well)
* PHP running with the [FastCGI Process Manager (PHP FPM)](https://www.php.net/manual/en/install.fpm.php)
    * Including PHP FPM `pm.status_path` configured
* Web server configured to allow requests to the configured PHP FPM status path
* This has only been tested on Craft 3.7.35, but _probably_ works on all of 3.x.x
* Composer (I mean, this is a Craft dependency too :))


## Installation

1. In terminal, from the root of your Craft project install the package with composer:

```
composer require noahjahn/craft-php-fpm-status-monitor
```

or, if you're like me and don't like having dependencies installed on your local machine and would rather install with Docker:

```
docker run --rm --user $UID:$UID -w /app -v "$(pwd):/app" composer require noahjahn/craft-php-fpm-status-monitor
```

2. In your browser, logged in to an admin user for your Craft site, open the Control Panel > Settings > Plugins and install the plugin


## Configuration

1. Configure the `pm.status_path` in the PHP FPM configuration on your server

    Example PHP FPM configuration (on your server, or in your container, PHP FPM config probably lives `/usr/local/etc/php-fpm.d/`):

    ```
    pm.status_path = /fpm-status
    ```

2. Configure the web server to be able to send requests to the status path previously configured

    *It's recommended not to allow public access to this endpoint.*

    Here is some example nginx configuration under the `server` block (your `fastcgi_pass` value will probably be different):

    ```nginx
    # Allow fpm ping and status from localhost and private IPs
    location ~ ^/(fpm-status)$ {
        access_log off;
        # Private IPs:
        allow 10.0.0.0/8;
        allow 172.16.0.0/12;
        allow 192.168.0.0/16;
        allow 127.0.0.1;
        deny all;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_pass php-fpm;
    }
    ```

3. In the control panel of your site, set the `path` to your chosen path value in the settings of the plugin


## Use cases

* View php-fpm status information from the control panel dashboard


## Ideas & future

* Store metrics about past number of in use php-fpm workers
* Provide a better possible configuration given total amount of memory, PHP memory limit, and OPCache memory config
