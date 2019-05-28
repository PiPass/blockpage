# PiPass
[![Maintainability](https://api.codeclimate.com/v1/badges/9d4a537646feea510ddf/maintainability)](https://codeclimate.com/github/roenw/PiPass/maintainability)
[![GitHub tag](https://img.shields.io/github/tag/Naereen/StrapDown.js.svg)](https://github.com/roenw/PiPass/releases/tag/v1.1)
[![GitHub pull-requests](https://img.shields.io/github/issues-pr/Naereen/StrapDown.js.svg)](https://GitHub.com/Naereen/StrapDown.js/pull/)

PiPass is an extention to the Pi-Hole project which adds easy temporary unblocking functionality and a visually appealing blockpage. The whole project currently is written in PHP, so it will integrate very easily with your existing Pi-Hole system. The blockpage is very easy to use, presenting three distinct options, an automated, temporary unblock button among them.

<p align="center">
  <a href="https://roen.us/wp-content/uploads/2019/05/pipass-blockpage.gif"><img src="https://roen.us/wp-content/uploads/2019/05/pipass-blockpage.gif" width="75%" height="75%"></a><br/>
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
* Root (sudo) access to Pi-Hole
* Git
* Webroot folder without any index files (e.g. no index.php/index.html/etc.)
* Knowledge of location of webroot
* SSH or direct terminal access
* Knowledge of which user PHP is running as
* Optional: Domain or subdomain linked to your Pi-Hole
* Optional: SSL certificate for your Pi-Hole

Install
------
**NOTE:** Versions 1.2/1.2b and below are now deprecated due to not having automatic update checking functionality. Please update immediately by removing your current installation and following this much simpler setup guide.

1. Make your webserver redirect all 404 errors to the webroot. For nginx, this is

```
        location / {
                try_files $uri $uri/ =404;
                error_page 404 =200 http://$host;
        }
```

For lighttpd, use ``server.error-handler-404 = "/index.php"`` (this is untested, but should work)

2. Execute ``cd ~ && wget https://apps.roen.us/pipass/getuser && mv getuser getuser.php && wget https://apps.roen.us/pipass/setup && mv setup setup.php`` to download the setup script and rename it.

3. Execute ``sudo php setup.php`` to execute the setup script.

4. Fill out the ``config.php`` configuration file.

Support
------
Having problems? [Let me know.](https://github.com/roenw/PiPass/issues)

Pull requests are welcome!

Known Caveats
------
* Requires webroot index
* Requires end-user to (sometimes) clear their DNS cache
* Does not work on websites with HSTS header cached :(


Future Ideas
------
* Ability to trigger permanent whitelist after password entry
* Admin console for PiPass
