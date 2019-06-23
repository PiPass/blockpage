# Uninstalling
We will miss you, but we want to make this an easy breakup.

To uninstall, execute the following command in the Terminal:
``bash <(wget -qO- https://kubrick.roen.us/pipass/scripts/uninstall.sh)``

## Feedback

Please take the time to submit [feedback](https://github.com/roenw/PiPass/issues) addressing the issues or limitations that are moving you to uninstall.

## Ensuring Full Removal

The uninstall script will attempt to revert all changes the PiPass installer made, but is not perfect. Here are some things to check once the uninstaller has completed.

1. Check if the PiPass entry in ``/etc/sudoers`` has been removed. (``sudo cat /etc/sudoers | grep \/usr\/local\/bin\/pihole``
2. Make sue 404 redirects have been disabled (``cat /etc/lighttpd/lighttpd.conf | grep 404``)
3. Check if PiPass files have been removed (``ls /var/www/ | grep blockpage``)
4. Optional: Make sure you have reverted ``NODATA``-based blocking (``cat /etc/pihole/pihole-FTL.conf | grep BLOCKINGMODE``)

That's it. PiPass should be uninstalled.