# PiPass
PiPass is an extention to the Pi-Hole project which adds easy temporary unblocking functionality and a visually appealing blockpage. The whole project, currently, is written in PHP, so it will integrate very easily with your existing Pi-Hole system. The blockpage is very easy to use, presenting three distinct options, an automated, temporary unblock button among them.

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
