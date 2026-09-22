=== matchHeight ===

Contributors: neilgee
Donate link: https://wpbeaches.com/
Tags: match, height, size, equal height
Requires at least: 5.8
Tested up to: 7.1
Requires PHP: 7.2
Stable tag: 1.2.1
License: GPL-2.0-or-later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Makes selected elements equal in height using the jQuery matchHeight library.

== Description ==

matchHeight loads the jQuery matchHeight library and applies it to the CSS selectors entered in the plugin settings.

The plugin makes the height of all matched elements equal. It does not collect personal data, make external requests, or add front-end assets when no selectors are configured.

= Usage =

1. Go to Settings > matchHeight.
2. Enter the CSS selectors for the elements you want to equalize.
3. Separate multiple selectors with commas, for example: `.card, .feature`.
4. Save the changes.

The plugin is a WordPress wrapper for [jQuery matchHeight.js by Liam Brummitt](https://github.com/liabru/jquery-match-height).

== Installation ==

1. Upload the `matchheight` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the Plugins screen in WordPress.
3. Go to Settings > matchHeight and add your selectors.

== Frequently Asked Questions ==

= Does the plugin load scripts on every page? =

The scripts load on the front end only when at least one selector has been saved in the settings.

= Can I use selectors other than classes and IDs? =

Yes. You can use any selector supported by jQuery, including attribute selectors and combinators.

== Screenshots ==

1. The matchHeight settings screen.

== Changelog ==

= 1.2.1 =

* Tested with WordPress 7.1.
* Improved compatibility with current WordPress coding and security practices.
* Corrected the bundled matchHeight library version used for browser cache busting.
* Avoided loading front-end scripts when the selector setting is empty.
* Improved settings sanitization, escaping, translations, and direct file-access protection.
* Added graceful handling for invalid CSS selectors.
* Added a Settings link on the Plugins screen.
* Updated plugin metadata, documentation, and secure URLs.

= 1.2.0 =

* Upgraded the matchHeight library to version 0.7.2.

= 1.1.0 =

* Upgraded the matchHeight library to version 0.7.0.

= 1.0.0 =

* Initial release.

== Upgrade Notice ==

= 1.2.1 =

Maintenance and compatibility update for current WordPress versions. Existing selector settings are preserved.
