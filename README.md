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
* Knowledge of which user PHP is running as
* Optional: Domain or subdomain linked to your Pi-Hole

Install
------
Installing PiPass is straightforward and simple. All it requires is a small change to your Pi-Hole's permissions, moving around some files, filling out a configuration file, and changing some settings with your webserver.
1. We'll get the most difficult stuff out of the way first. Use ``sudo visudo`` to edit your ``/etc/sudoers`` file. We will use this to give PHP permission to make changes to the whitelist. Add the following line to the _bottom_ of the file. Substitute ``USER_RUNNING_PHP`` in the file with the user that is running PHP on your system.
``USER_RUNNING_PHP ALL=(ALL) NOPASSWD: /usr/local/bin/pihole -w *, /usr/local/bin/pihole -w -d *``
> The /etc/sudoers file is a critical file to the security of your Linux installation. Adding anything other than what is above can expose your system to security threats.
2. 
