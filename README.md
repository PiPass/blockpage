# PiPass
PiPass is an extention to the Pi-Hole project which adds easy temporary unblocking functionality and a visually appealing blockpage. The whole project currently is written in PHP, so it will integrate very easily with your existing Pi-Hole system. The blockpage is very easy to use, presenting three distinct options, an automated, temporary unblock button among them.

<p align="center">
  <img src="https://roen.us/wp-content/uploads/2019/05/pipass-blockpage.gif" width="75%" height="75%"><br/>
  <strong>PiPass blockpage</strong><br />
</p>

Prerequisites
------
* Pi-Hole server
  * Includes webserver and PHP already installed & configured (confirmed working on PHP version 7.3)
* Root (sudo) access to Pi-Hole
* Git
* **EMPTY** webroot folder
* Knowledge of location of webroot
* SSH or direct terminal access
* Knowledge of which user PHP is running as
* Optional: Domain or subdomain linked to your Pi-Hole
* SSL certificate for your Pi-Hole

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

3. We must instruct Pi-Hole to use a blockpage instead of returning ``NXDOMAIN``. Don't worry, this will still result in a blank space where advertisements should be. Using your favorite editor, edit ``cat /etc/pihole/pihole-FTL.conf`` and find the line ``BLOCKINGMODE``. Replace it with ``BLOCKINGMODE=IP`` and restart the Pi-Hole FTL service.

You can now test the configuration so far. Go to a website you know is blocked. It should return the ``index`` page, or a ``404 Not Found/403 Forbidden`` error if configured correctly.

4. To prepare for installation, ``cd`` to your webroot folder. Make sure there are no ``index`` files and there is no folder called ``blockpage``.

5. Now, we're at the fun part. Making sure you are still in your webroot, run ``sudo git clone https://github.com/roenw/pipass.git && cd pipass && sudo git checkout tags/v1.1 && cd .. && sudo mv pipass/* .`` This command downloads all PiPass files and moves them to your webroot.

6. Using your favorite text editor, edit ``config.php`` with appropriate information.

6a. Optional: Run ``sudo chmod 660 config.php`` to secure your configuration file. Highly reccomended if your Pi-Hole is externally accessible.
