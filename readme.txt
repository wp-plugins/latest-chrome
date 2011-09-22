=== Plugin Name ===
Contributors: xslidian
Donate link: http://lidian.info/
Tags: Chrome, gadget
Requires at least: 2.0.2
Tested up to: 3.2.1
Stable tag: trunk

A gadget including the latest Chrome downloads and a script to check if the visitor is using a latest version.

== Description ==

This gadget will show the latest version numbers of most branches of Google Chrome.

There is also a tip telling if the user is using one of the latest versions of Chrome / Chromium.

Only the cron script will consume incoming bandwidth.

== Installation ==

1. Unzip `latest-chrome` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Add `/wp-content/plugins/latest-chrome/cron.php` as a cron job in your server's control panel

== Frequently Asked Questions ==

= How accurately do the scripts work? =

Checks for Chrome browsers are based on official data, while only the branch number will be checked for Chromium's User-Agents.

== Screenshots ==

1. widget in work

== Changelog ==

= 0.0.1 =
* Initial release.