# PiPass
[![Maintainability](https://api.codeclimate.com/v1/badges/9d4a537646feea510ddf/maintainability)](https://codeclimate.com/github/roenw/PiPass/maintainability)
[![GitHub tag](https://img.shields.io/github/tag/Naereen/StrapDown.js.svg)](https://github.com/roenw/PiPass/releases/tag/v1.1b)
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
Installing PiPass is straightforward and simple. It should take about 10-15 minutes. All it requires is a small change to your Pi-Hole's permissions, moving around some files, filling out a configuration file, and changing some settings with your webserver.
1. We'll get the most difficult stuff out of the way first. Use ``sudo visudo`` to edit your ``/etc/sudoers`` file. We will use this to give PHP permission to make changes to the whitelist. Add the following line to the _bottom_ of the file. Substitute ``USER_RUNNING_PHP`` in the file with the user that is running PHP on your system.

``USER_RUNNING_PHP ALL=(ALL) NOPASSWD: /usr/local/bin/pihole -w *, /usr/local/bin/pihole -w -d *``
> The /etc/sudoers file is a critical file to the security of your Linux installation. Adding anything other than what is above can expose your system to security threats.
2. Next, we have to tell our webserver to point all 404 erros to the homepage. It's not ideal and hopefully it can be changed in a future release, but as of now it's required for proper function. How you do this depends on your webserver. For lighttpd, comment out the existing 404 line and replace it with:

``server.error-handler-404    = "/index.php"``

I don't personally run lighttpd and this is untested, but it should work. Just don't be surprised if it doesn't ;)
I use nginx, so this code is verified working:

```
        location / {
            try_files $uri $uri/ =404;
            error_page 404 =200 http://$host;
        }
```

3. We must instruct Pi-Hole to use a blockpage instead of returning ``NXDOMAIN``. Don't worry, this will still result in a blank space where advertisements should be. Using your favorite editor, edit ``/etc/pihole/pihole-FTL.conf`` and find the line ``BLOCKINGMODE``. Replace it with ``BLOCKINGMODE=IP`` and restart the Pi-Hole FTL service.

You can now test the configuration so far. Go to a website you know is blocked. It should return the ``index`` page, or a ``404 Not Found/403 Forbidden`` error if configured correctly.

4. To prepare for installation, ``cd`` to your webroot folder. Make sure there are no ``index`` files and there is no folder called ``blockpage``.

5. Now, we're at the fun part. Making sure you are still in your webroot, run ``sudo git clone https://github.com/roenw/pipass.git && cd pipass && sudo git checkout tags/v1.1b && cd .. && sudo mv pipass/* . && sudo rm -r pipass/`` This command downloads all PiPass files and moves them to your webroot.

6. Using your favorite text editor, edit ``config.php`` with appropriate information.


Known Caveats
------
* /etc/sudoers file must be modified
* Requires webroot index
* Requires end-user to (sometimes) clear their DNS cache
* Configuration is not automated


Future Ideas
------
* Configuration script (maybe even an apt package?)
* Ability to trigger permanent whitelist after password entry
