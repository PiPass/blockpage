# PiPass
<a href="https://codeclimate.com/github/roenw/PiPass/issues">![Maintainability](https://api.codeclimate.com/v1/badges/9d4a537646feea510ddf/maintainability)</a>
![version](https://img.shields.io/github/release/roenw/pipass.svg?label=release)
![GitHub pull-requests](https://img.shields.io/github/issues-pr-raw/roenw/pipass.svg?color=blue)
![GitHub pull-requests](https://img.shields.io/github/issues-raw/roenw/pipass.svg?color=red)

PiPass is an extention to the Pi-Hole project which adds easy temporary unblocking functionality and a visually appealing blockpage. The whole project currently is written in PHP, so it will integrate very easily with your existing Pi-Hole system. The blockpage is very easy to use, presenting three distinct options, an automated, temporary unblock button among them.

<p align="center">
  <a href="https://https://apps.roen.us/pipass/blockpage.png"><img src="https://apps.roen.us/pipass/blockpage.png" width="75%" height="75%"></a><br/>
  <strong>PiPass blockpage</strong><br />
</p>

Contributing
------
Obviously, this is an open-source project. You may find problems in the code, in which I would strongly encourage you to create an issue, or if you're willing to solve it yourself, fork the repository and create a pull request. If you want a feature added, feel free to [create an issue](https://github.com/roenw/PiPass/issues).


A list of known caveats is at the bottom of this document. If you'd like to contribute but don't know how, check there for some ideas.

Prerequisites
------
* Pi-Hole server
  * Includes webserver and PHP already installed & configured (confirmed working on PHP version 7.3)
* SSH or direct terminal access
* SSL certificate for your Pi-Hole (self signed is ok) 
* PHP-CURL to check for new versions (``sudo apt update && sudo apt install php7.0-curl``)
Root (sudo) access to Pi-Hole
* Git (if this isn't installed yet, use ``sudo apt-get install wget git-core``)
* Knowledge of location of webroot (normaly this can be found under /var/www/html/)
* Webroot folder without any index files (e.g. no index.php/index.html/etc.)
* Knowledge of which user PHP is running as
* Optional, will improve functionality: Domain or subdomain linked to your Pi-Hole

Install
------
Installation on a vanilla Pi-Hole is completely automated. Execute ``bash <(wget -qO- https://kubrick.roen.us/pipass/scripts/install.sh)`` to install.

If you have a more complex installation (e.g. using ``NGiNX`` as a webserver), follow these steps below.

1. Make your webserver redirect all 404 errors to the webroot. If you use ``lighttpd``, this function is automated.

For ``NGiNX``, this is

```
        location / {
                try_files $uri $uri/ =404;
                error_page 404 =200 http://$host;
        }
```

3. ``bash <(wget -qO- https://kubrick.roen.us/pipass/scripts/install.sh)`` - You may be prompted for elevated permissions using ``sudo``.

4. Optional: fill out the ``config.php`` configuration file.

Support
------
Having problems? [Let me know.](https://github.com/roenw/PiPass/issues)

Pull requests are welcome!

Known Caveats
------
* Requires webroot index
* Does not work on websites with HSTS header cached :(


Future Ideas
------
* Ability to trigger permanent whitelist after password entry
* Admin console for PiPass (currently in the works)
* apt repository/package and Docker image
