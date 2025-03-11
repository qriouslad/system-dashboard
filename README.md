# System Dashboard

Contributors: qriouslad  
Donate link: https://bowo.io/dotorg-sponsor-sd
Tags: system monitor, wordpress components, action filter hooks, server info, developer  
Requires at least: 4.8  
Tested up to: 6.7.2  
Stable tag: 2.8.20  
Requires PHP: 5.6  
License: GPLv2 or later  
License URI: http://www.gnu.org/licenses/gpl-2.0.html

![](.wordpress-org/banner-772x250.png)

Central dashboard to monitor various WordPress components, processes and data, including the server.

## Description

This plugin provides a central dashboard to monitor various WordPress components, processes and data, including server hardware, software and resource usage. Pairs well with [Query Monitor](https://wordpress.org/plugins/query-monitor/) to help you do some solid dev work.

_"**A must-have for serious WordPress developers**."_ ~[Jeff Starr](https://digwp.com/2023/06/plugins-troubleshoot-debug-wordpress/)

_"**A power tool** for WordPress site builders and plugin/theme developers that **will save a ton of time**."_ ~[Ivan Arnaudov](https://wordpress.org/support/topic/a-swiss-army-knife-with-on-board-nuclear-reactor/)

_"Hands down **one of the best plugins for developers**. Keep up the good work!"_ ~[Abracadabra DGTL](https://wordpress.org/support/topic/simple-yet-effective-71/)

Despite having 20 WordPress modules and 4 server modules, the single-page dashboard loads fast as queries are optimized and most modules employ fast AJAX loading of data. It does not weight down wp-admin, and nothing is loaded on the front-end. Install, activate and let it sit there ready to summon the info/data you need.

To preview the module screenshots more easily, please scroll down the [github repo](https://github.com/qriouslad/system-dashboard). Here's a rundown of the available modules...

### WordPress Modules (20)

#### 1. Overview: 

* Site health status
* Quick stats of active theme and plugins
* Permalink structure
* Search engine visibility
* Timezone and current time
* Your IP address

#### 2. Database: 

* Software info
* Uptime
* Data size
* Index size
* List of WP core tables with data/index size and number of rows/records of each table
* List of tables created/used by themes and plugins with the origin theme/plugin, data/index size and number of rows/records of each table
* Key database info, e.g. innodb_buffer_pool_size
* Detailed specifications

#### 3. Post Types & Taxonomies: 

* List of post types and posts count for each
* List of taxonomies and terms count for each
* Comment count
* List of old slugs and the corresponding posts

#### 4. Media: 

* List of media types and files count for each
* List of allowed mime types and the corresponding file extensions
* List of registered image sizes
* Media handling info, e.g. max file upload size

#### 5. Directories: 

* Root path
* Directory size and total number of files in WP installation, wp-admin, wp-includes, wp-content directory, uploads directory, plugins directory, themes directories
* Filesystem permissions

#### 6. Custom Fields:

* List of public custom fields
* List of private custom fields, i.e. keys that start with an undersocre _

#### 7. Users:

* List of user roles and users count for each
* List of roles and capabilities. Including custom roles and custom capabilities.

#### 8. Options: 

* Total number of options
* Total number and size of autoloaded options
* Filterable list of options from WordPress core with ID, autoload, size and type info
* Filterable list of options from plugins and theme with ID, autoload, size and type info
* List of 10 autoloaded options with the largest size
* AJAX loading of option value with interactive tree viewer for array and object value types 

#### 9. Transients: 

* Total number of transients
* Total number and size of autoloaded transients
* List of transients with expiration, including time left to expiry
* List of expired transients
* List of transients that do not expire
* AJAX loading of transient value with interactive tree viewer for array and object value types 

#### 10. Object Cache:

* Status of persistent object cache backend
* Stats of cache hit ratio
* List of global groups
* List of non-persistent groups
* List and viewer (AJAX) of cached items in the global $wp_object_cache variable
* List and viewer (AJAX) of cached items in memory. Currently supporting Redis and Memcached backends.
* Diagnostics info (if available)

#### 11. Cron:

* List of cron event hooks and recurrences, categorized by core vs non-core

#### 12. Rewrite Rules:

* List of rewrite rules

#### 13. Shortcodes:

* List of shortcodes and renderers (callback functions)

#### 14. Hooks:

* Filterable list of action and filter hooks from WordPress core with description, originating file path and link to WordPress Code Reference for each hook
* List of action and filter hooks from the active theme, with description, originating file path and link to file preview in the theme file editor
* List of action and filter hooks from active plugins, with description, originating file path and link to file preview in the plugin file editor

#### 15. Classes: 

* List of classes from WordPress core with methods, originating file path, and link to WordPress Code Reference for each class
* List of classes from the active theme with methods, originating file path, and link to preview the file in the theme file editor
* List of classes from active plugins with methods, originating file path, and link to preview the file in the plugin file editor

#### 16. Functions:

* Filterable list of functions from WordPress core with the originating file path and link to WordPress Code Reference for each function
* List of functions from the active theme with the originating file path and link to preview the file in the theme file editor
* List of functions from active plugins with the originating file path and link to preview the file in the plugin file editor

#### 17. Globals:

* Categorized list of global variables defined by WordPress
* List of PHP super globals
* List of global variables defined by themes and plugins

#### 18. Constants:

* List of defined constants by WordPress core (categorized), as well as by theme and plugins
* Documentation of each constant from WordPress core

#### 19. Viewer: 

* wp-config.php viewer, including path and writeability info.
* .htaccess viewer
* REST API viewer
* robots.txt viewer
* Link to sitemap
* Viewer for URLs, paths and fragments from various WP core functions and CONSTANTS like get_template_directory_uri() and ABSPATH, as well as those generated by PHP $\_SERVER superglobal such as $\_SERVER\['REQUEST_URI'\]
* Link to recent posts RSS feed
* Link to recent comments RSS feed

#### 20. Logs: 

* Page Access log. A simple logger of which pages are being accessed by site visitors. Disabled by default.
* PHP Errors log using native WP_DEBUG constants and a custom name and location for the debug log file for better security. Disabled by default.
* Email Delivery log: will log emails that the WordPress app has sent / tried sending and provide a way to quickly view and search through them. Disabled by default.

### Server Modules (3)

#### 1. Overview: 

* Server operating system
* Web server software
* Server IP address
* Server hostname
* Server location
* Server timezone and current date time

#### 2. Monitor: 

* Server uptime
* Server CPU load average: last 15 minutes, last 5 minutes, last 1 minute
* RAM usage
* Disk usage

#### 3. Hardware: 

* CPU type
* CPU count and cores count
* Total RAM
* Total disk space

#### 4. PHP:

* PHP version
* PHP user
* Key info: max execution time, max input time, max input vars, memory limit, post max size, upload max size, cURL version, allow_url_fopen, fsockopen, SoapClient, DOMDocument, GZip, SUHOSIN, Imagick
* Extensions loaded
* Disabled functions
* Detailed PHP specification from phpinfo()

### For All WordPress and Server Modules:

* List of relevant tools (plugins) and references (articles) for each module

### Technical Notes

* Requires shell_exec and exec functions enabled for some modules to work properly. e.g. the Hooks > Active Plugins tool.
* There's an MU (must-use) plugin that unloads all other plugins for admin-ajax calls initiated from the dashboard, so these calls stay fast no matter how complex and big your site is.
* The longest first load is probably the Hooks > Active Plugins tool, which scans action and filter hooks from all active plugins on the site. The more plugins are active, the longer it takes. If your server/hosting has a low execution time limit, you may need to load the module two or three times for the scan to complete. Once complete, subsequent loads of the module should be much much faster.
* This plugin has been tested to work with servers powered by NGINX, Apache and Litespeed, and also sites using PHP 7+ and 8+.

### Give Back

About 260 dev hours have been spent towards v2.6.2 so far.

* [A nice review](https://bowo.io/review-sd) would be great!
* [Give feedback](https://bowo.io/feedback-sd) and help improve future versions.
* [Github repo](https://bowo.io/github-sd) to contribute code.
* [Sponsor](https://bowo.io/dotorg-sponsor-sd) my work.
* Tell your colleagues about System Dashboard.

### Check These Out Too

* [Admin and Site Enhancements](https://wordpress.org/plugins/admin-site-enhancements/) helps you to easily enhance various admin workflows and site aspects while replacing multiple plugins doing it.
* [Debug Log Manager](https://wordpress.org/plugins/debug-log-manager/): Log PHP, database and JavaScript errors via WP_DEBUG with one click. Conveniently create, view, filter and clear the debug.log file.
* [Variable Inspector](https://wordpress.org/plugins/variable-inspector/): Inspect PHP variables on a central dashboard in wp-admin for convenient debugging.
* [Flexible Scroll Top](https://wordpress.org/plugins/flexible-scroll-top/) and [Floating Share Buttons](https://wordpress.org/plugins/floating-share-button/) is a lightweight combo with minimalist UI.
* [WordPress Newsboard](https://www.wpnewsboard.com/): The latest news, articles, podcasts and videos from 100+ WordPress-focused sources.

## Screenshots

1. The dashboard
   ![The dashboard](.wordpress-org/screenshot-1.png)
2. WordPress overview & the Database module
   ![WordPress overview & the Database module](.wordpress-org/screenshot-2.png)
3. Post Types & Taxonomies module
   ![Post Types & Taxonomies module](.wordpress-org/screenshot-3.png)
4. Media module
   ![Media module](.wordpress-org/screenshot-4.png)
5. Directories module
   ![Directories module](.wordpress-org/screenshot-5.png)
6. Custom Fields module
   ![Custom Fields module](.wordpress-org/screenshot-6.png)
7. Users module
   ![Users module](.wordpress-org/screenshot-7.png)
8. Options module
   ![Options module](.wordpress-org/screenshot-8.png)
9. Transients module
   ![Transients module](.wordpress-org/screenshot-9.png)
10. Cron module
   ![Cron module](.wordpress-org/screenshot-10.png)
11. Rewrite Rules module
   ![Rewrite Rules module](.wordpress-org/screenshot-11.png)
12. Shortcodes module
   ![Shortcodes module](.wordpress-org/screenshot-12.png)
13. Hooks module
   ![Hooks module](.wordpress-org/screenshot-14.png)
14. Classes module
   ![Classes module](.wordpress-org/screenshot-15.png)
15. Functions module
   ![Functions module](.wordpress-org/screenshot-16.png)
16. Globals module
   ![Globals module](.wordpress-org/screenshot-17.png)
17. Constants module
   ![Constants module](.wordpress-org/screenshot-18.png)
18. Viewer module
   ![Viewer module](.wordpress-org/screenshot-13.png)
19. Server overview and Monitor module
   ![Server overview and Monitor module](.wordpress-org/screenshot-19.png)
20. Hardware module
   ![Hardware module](.wordpress-org/screenshot-20.png)
21. PHP module
   ![PHP module](.wordpress-org/screenshot-21.png)

## Frequently Asked Questions

### How was this plugin built?

System Dashboard was built with: [WordPress Plugin Boilerplate](https://github.com/devinvinson/WordPress-Plugin-Boilerplate/) | [wppb.me](https://wppb.me/) | [CodeStar framework](https://github.com/Codestar/codestar-framework)

## Changelog

### 2.8.20 (2024.03.11)

* Internationlized UI strings so the plugin is ready for translations. This iteration covers the majority of UI elements, but excludes some of the strings in several tabs, e.g. Constants Documentation. Props to Valdemir for prompting this.

### 2.8.19 (2024.02.20)

* **[SECURITY FIX]** implemented authorization checks to page access log AJAX endpoint to fix "Missing Authorization to Authenticated (Subscriber) View Page Access Log" vulnerability as reponsibly disclosed by security researcher Trương Hữu Phúc (truonghuuphuc) via Pathstack.

### 2.8.18 (2024.02.05)

* **[SECURITY FIX]** Viewer - Fix Reflected Cross-Site Scripting vulnerability via Filename Parameter, responsibly disclosed via WordFrence by vgo0. Added proper validation, sanitization and escaping.

### 2.8.15 (2024.11.17)

* **[SECURITY FIX]** Page Access Log - Fix unauthenticated stored XSS vulnerability as reported by Bob, a security researcher for WPScan and Jetpack.

* **[SECURITY FIX]** Viewer - Fix path traversal vulnerability that allows admins to view the contents of arbitrary files on the server, as reported by Bob, a security researcher for WPScan and Jetpack.

* **[FIXED]** Disk Usage - fix fatal error in a certain scenario as [reported](https://wordpress.org/support/topic/fatal-error-uncaught-error-division-by-zero-2/) by [Rob M.](https://wordpress.org/support/users/rm54x/).

* **[FIXED]** Two PHP warnings as [reported](https://github.com/qriouslad/system-dashboard/issues/25) by [@reszel](https://github.com/reszel)

* **[UPDATED]** Codestar framework update from v2.2.8 to v2.3.1. This should fix deprecation notices as [reported](https://wordpress.org/support/topic/warnings-and-deprecated-messages/) by [@mbrsolution](https://wordpress.org/support/users/mbrsolution/).

### 2.8.14 (2023.12.19)

* **[FIXED]** Fixed PHP fatal error caused by undefined function introduced in the last release. Props to Adrien R. for reporting the issue.

### 2.8.13 (2023.12.18)

* **[FIXED]** Fixed PHP deprecation notice on detecting server CPU type and a PHP fatal error on displaying total server RAM. Props to [@darrenford77](https://wordpress.org/support/users/darrenford77/) for [reporting the issue](https://wordpress.org/support/topic/critical-error-viewing-dashboard-2/).

### 2.8.12 (2023.12.18)

* **[FIXED]** Fixed PHP deprecation notices and a fatal error on detection of server used RAM. Props to [@darrenford77](https://wordpress.org/support/users/darrenford77/) for [reporting the issue](https://wordpress.org/support/topic/critical-error-viewing-dashboard-2/).

### 2.8.11 (2023.12.18)

* **[FIXED]** Fixed PHP Fatal Error on detection of server uptime. Props to [@darrenford77](https://wordpress.org/support/users/darrenford77/) for [reporting the issue](https://wordpress.org/support/topic/critical-error-viewing-dashboard-2/).

* **[FIXED]** Fixed Warning Error on detection process of server OS. Props to [@darrenford77](https://wordpress.org/support/users/darrenford77/) for [reporting the issue](https://wordpress.org/support/topic/critical-error-viewing-dashboard-2/).

### 2.8.10 (2023.11.30)

* **[SECURITY]** Patched a Stored XSS vulnerability by X-Forward-For Header Injection. The vulnerability was responsibly disclosed by Dmitrii Ignatyev from Clean Talk inc on October 20, 2023. Apologies if this took me a while to get around to as I was fully occupied with the launch of [ASE Pro](https://www.wpase.com).

### 2.8.9 (2023.11.29)

* Improved: implement a more generic and robust method to get database server info used in the "Database >> System & Uptime section". Now uses the WP core method $wpdb->db_server_info(). Props to Adrien R. for the nudge to further improve this and help with providing technical details to help achieve that.

### 2.8.8 (2023.11.29)

* **[IMPORTANT][SECURITY]** Fixed vulnerabilities that caused sensitive data to be accessible by non-administrators via ajax requests. The vulnerability was responsibly disclosed by Dmitrii Ignatyev from Clean Talk inc on October 20, 2023. Apologies if this took me a while to get around to as I was fully occupied with the launch of [ASE Pro](https://www.wpase.com).

* Fixed: PHP fatal error - mysqli_get_server_info(): Argument #1 ($mysql) must be of type mysqli, bool given. Props to Adrien R. for [reporting](https://wordpress.org/support/topic/php-fatal-errror-regarding-mysqli/) the issue.

* Fixed: PHP fatal error - Class "Redis" not found. Props to [Julian Song](https://wordpress.org/support/users/julians3/) for [reporting this](https://wordpress.org/support/topic/fatal-error-4495/).

### 2.8.7 (2023.07.10)

* Fixed: PHP fatal error - Uncaught TypeError: Unsupported operand types: string / int. Props to [@pressimize](https://wordpress.org/support/users/pressimize/) for [reporting it](https://wordpress.org/support/topic/fatal-error-4486/).


### 2.8.6 (2023.07.09)

* Fixed: PHP fatal error for certain scenario in getting server location. Props to [@malaga16](https://wordpress.org/support/users/malaga16/) for [reporting it](https://wordpress.org/support/topic/fatal-error-when-try-to-open-the-dashboard-page/) and also [@clouddevelopment](https://wordpress.org/support/users/clouddevelopment/) for [another report of it](https://wordpress.org/support/topic/fatal-error-uncaught-error-cannot-access-offset-of-type-string-on-string-in/)
* Fixed: several PHP warnings. Props to [@alx359](https://wordpress.org/support/users/alx359/) for [reporting it](https://wordpress.org/support/topic/issues-wamp-php8-x/) and [@shawfactor](https://wordpress.org/support/users/alx359/) for [another report](https://wordpress.org/support/topic/issues-wamp-php8-x/).


### 2.8.5 (2023.04.15)

* Improve compatibility with localhost installation. Following up on reports by [@enterprisebranding](https://wordpress.org/support/topic/localhost-localwp-dot-com-fatal-error/) and [@brasofilo](https://wordpress.org/support/topic/localhost-wp-local-fatal-error-solution/).
* **[SPONSORSHIP]** If you like or have benefited from this plugin in your **personal project(s), paid work and/or client site(s)**, please kindly consider [sponsoring the ongoing development and maintenance](https://bowo.io/dotorg-sponsor-sd) of this plugin (and [my other plugins](https://profiles.wordpress.org/qriouslad/#content-plugins)) from as little as USD 1 / month. Thank you!

### 2.8.4 (2022.10.25)

* All admin notices are now suppressed, i.e. no longer shown, on the System Dashboard page

### 2.8.3 (2022.10.09)

* Hooks > Core: Update action and filter hooks definition to [WordPress v6.0](https://github.com/wp-hooks/wordpress-core). Include long description and "since WordPress version" info.
* Database > Themes & Plugins: Update table name <-> plugin relationships database from [WP-Optimize](https://wordpress.org/plugins/wp-optimize/) v3.2.9.
* Logs > PHP Erros: Make it work with existing [Debug Log Manager](https://wordpress.org/plugins/debug-log-manager/) log file, or other log file path defined in WP_DEBUG_LOG constant.
* Server > Hardware: Fix formatting of Total Disk Space
* Hide "Screen Options" drawer

### 2.8.2 (2022.09.24)

* Viewer >> wp-config.php: improve detection of it's location. Add path and writeability info.

### 2.8.1 (2022.08.31)

* Logs > PHP Errors: now only shows distinct/unique entries

### 2.8.0 (2022.08.26)

* Logs > Email Delivery: New module to log emails that the WordPress app has sent / tried sending and a way to see and filter through them quickly.
* Logs > Page Access: Now shows latest entries by default.
* Logs > Errors Log: Improve how debug log is parsed to ensure each log entry is cleanly split even when there is stack trace info included for fatal errors.
* Logs > Errors Log: Increase limit of entries being loaded to 50,000.
* Upon plugin deactivation, database tables for the Logs module are no longer dropped/deleted.

### 2.7.0 (2022.08.25)

* Implemented PHP Errors log under the Logs module employing WP_DEBUG with custom debug log file name and location for better security. Turned off by default. Will automatically add the necessary WP_DEBUG constants in wp-config.php when enabled and remove them when disabled.
* Fix for [PHP warning issue](https://wordpress.org/support/topic/php-warning-362/) related to Page Access log option in wp_option table not always set, e.g. for users upgrading from older version of the plugin, as reported by [@shawfactor](https://wordpress.org/support/users/shawfactor/).

### 2.6.5 (2022.06.19)

* Server > Monitor: Fixed "Unsupported operand types" error on disk usage reporting. Props to [@wpturnedup](https://profiles.wordpress.org/wpturnedup/) for [reporting the error](https://wordpress.org/support/topic/fails-to-run-and-throws-a-critical-error/). This happened for certain managed WP hosting like Kinsta.
* Server > Hardware: Fixed "Call to undefined function" error on total disk space calculation. This happened for certain managed WP hosting like Kinsta.
* Server > PHP: Fixed "Call to undefined function" error on getting PHP current user. This happened for certain managed WP hosting like Kinsta.
* WordPress > Viewer > URLs and Paths: Fixed undefined array key error. This happened for certain managed WP hosting like Kinsta.

### 2.6.4 (2022.05.28)

* Logs > Page Access: fix [PHP warning issue](https://wordpress.org/support/topic/triggering-a-warning/). Props to [@shawfactor](https://profiles.wordpress.org/shawfactor/).

### 2.6.3 (2022.05.27)

* Logs: Convert Page Access log entries table into a data table using the DataTables jQuery plugin
* WP Overview: minor tidy up

### 2.6.2 (2022.05.26)

* Tested for compatibility with WordPress 6.0

### 2.6.1 (2022.05.25)

* Directories: add total number of files in each directory for Directory Sizes tool
* Directories: add check mark for 'Writeable' and cross mark for 'Not writeable' in the Filesystem Permission tool to better indicate which is the desirable status

### 2.6.0 (2022.05.24)

* Logs: New module. Added Page Access logger to begin with. A simple logger of which pages are being accessed by site visitors. Turned off by default.

### 2.5.1 (2022.05.20)

* Viewer: View URLs, paths and fragments from various WP core functions and CONSTANTS like get_template_directory_uri() and ABSPATH, as well as those generated by PHP $\_SERVER superglobal such as $\_SERVER\['REQUEST_URI'\]
* Fix: error on plugin activation in sites with older PHP versions (up to v7.2) due to nowdoc syntax issue upon generating fast-ajax.php MU plugin. Props to [@dblomster](https://profiles.wordpress.org/dblomster/) for identifying the issue and [reporting it](https://wordpress.org/support/topic/plugin-could-not-be-activated-because-it-triggered-a-fatal-error-664/).

### 2.5.0 (2022.05.18)

* Media: add list of registered image sizes
* Viewer: add links to recent posts and recent comments RSS feeds
* WP Overview: add permalink structure and search engine visibility info
* Post Types & Taxonomies: add post types labels if they're defined
* Server overview: fix location info, now properly returns 'Undetectable'. Props to [@nawawijamili](https://profiles.wordpress.org/nawawijamili/).
* Constants: normalize "Defined Constants" for Array, Object and Boolean values. Props to [@nawawijamili](https://profiles.wordpress.org/nawawijamili/).

### 2.4.4 (2022.04.26)

* Polish: Remove CodeStar framework menu item under Tools

### 2.4.3 (2022.04.20)

* Options: Cache query results for 10 largest autoloaded options to remove duplicate query
* CodeStar Framework: downgrade to [free version](https://github.com/Codestar/codestar-framework) v2.2.8

### 2.4.2 (2022.04.20)

* Constants: Disable fast AJAX so constants from all plugins are properly listed
* Options: Add list of 10 autoloaded options with the largest size


### 2.4.1 (April 2022)

* Reduce duplicate $wpdb queries with object caching

### 2.4.0 (April 2022)

* Object Cache: Add list and viewer of cache items in the global $wp_object_cache variable and also in memory store (currently supporting Redis and Memcached backends)
* Reposition Viewer module after the Constants module

### 2.3.0 (April 2022)

* NEW: Object Cache module with status of persistent object cache backend, stats of cache hit ratio, list of global groups, list of non-persistent groups and diagnostics info (if available)
* Server Overview: improve location output

### 2.2.1 (April 2022)

* Polish: update wording for View (Themes & Plugins) Tables
* Server Overview: add hostname info
* Server Monitor: add raw value of CPU load average
* Rewrite Rules: fix TypeError in PHP 8 when rewrite_rules option is empty, e.g. fresh WP install

### 2.2.0 (April 2022)

* Database: split tables into WP core vs themes & plugins and add counter for each category
* Database: add character set and collation info in the Key Info section
* Database: add default WP core tables for multisite if on a multisite
* Database: add detection of and link to origin theme/plugin for non-core tables

### 2.1.3 (March 2022)

* Server > Monitor: Polish wording for disk usage stats
* Optimization: dequeue public-facing scripts and styles, which are mostly empty placeholders
* Optimization: in wp-admin, only load scripts and styles on the System Dashboard page

### 2.1.2 (March 2022)

* Fix Server overview layout issue

### 2.1.1 (March 2022)

* Improve indentation in Fast AJAX MU Plugin generation to fix "headers already sent" issue which maybe caused by whitespace before <?php ([reference](https://stackoverflow.com/a/8028987))

### 2.1.0 (March 2022)

* Implement AJAX loading on the following modules: Classes, Functions, Post Types & Taxonomies, Media, Directories, Custom Fields, Users, Rewrite Rules, Shortcodes. This cuts down dashboard page load time to under 2 seconds (most of the time).
* Post Types & Taxonomies: Improve layout of old slugs list
* Globals: Disable usage of Fast AJAX as some globals are dependent on the full list of active plugins, e.g. shortcode_tags
* Server overview: Improve server IP detection on Apache server by using HTTP_X_SERVER_ADDR server globals

### 2.0.2 (March 2022)

* Fix TypeError in disk usage calculation and typo in site health check function. Props to [@ivanarnaudov](https://profiles.wordpress.org/ivanarnaudov/).
* Tidy up display of RAM usage and CPUs/cores count when shell_exec is not enabled
* Improve server location detection when using Apache by using IP address from HTTP_X_SERVER_ADDR server global

### 2.0.1 (March 2022)

* Fix missing Fast AJAX MU Plugin for those upgrading from v1.9.0
* Fix malformed Code Reference URLs for core hooks containing the '>' symbol, e.g. save_post_{$post->post_type}

### 2.0.0 (March 2022)

* Optimize dashboard load time considerably by employing AJAX loading of module content, element and values
* Implement an MU plugin that keeps AJAX calls fast by unloading all other plugins during the AJAX calls
* Optimize DB queries considerably on the Options and Transients module
* Cron: split cron events between core and non-core
* Database, Post Types & Taxonomies, Media, Directories, Users, Rewrite Rules: tidy up layout
* Add review, feedback and donate links in dashboard header

### 1.9.0 (March 2022)

* [NEW] Globals module: Categorized list of all WordPress core global variables, PHP super globals and non WP core globals
* Add tools and references for Rewrite Rules and Shortcodes modules

### 1.8.0 (March 2022)

* [NEW] Rewrite Rules module 
* [NEW] Shortcodes module 
* Database: added DB engine info in Key Info section

### 1.7.2 (March 2022)

* Further optimize how System Dashboard is loaded on wp-admin pages. On wp-admin pages other than the System Dashboard page, only call function that adds a 'System' sub-menu under the 'Dashboard' menu. This considerably speeds up load time across the entire wp-admin and also speed up AJAX calls from inside the System Dashboard page.

### 1.7.1 (March 2022)

* Only load System Dashboard on wp-admin pages and optimize how it is loaded there. Only execute demanding queries on the System Dashboard page. This resulted in faster load time of admin pages that is not the System Dashboard page.
* Options: Enable filtering of options by autoload status, value size and value type

### 1.6.0 (March 2022)

* Add search filter on the following modules: Options (core and non-core), Hooks (core), Functions (core)
* Add counter for the following modules: Custom Fields (public and private), Functions (core, themes, plugins) 
* Fix: output of custom id and classes for several HTML partials in sd_html()
* Fix: miscellaneous CSS styling

### 1.5.2 (March 2022)

* Viewer: Improve parsing of virtual robots.txt generated by WordPress. Properly detect default sitemap URL and add it to robots.txt
* WordPress > Overview: fix "division by zero" error. Props to [@nawawijamili](https://profiles.wordpress.org/nawawijamili/)!
* Server > Monitor: Fix "non well formed numeric value encountered" errorrs. Props to [@nawawijamili](https://profiles.wordpress.org/nawawijamili/)!
* Add reference to Options module

### 1.5.1 (March 2022)

* Viewer: NEW module to view files. Implemented viewer for wp-config.php, .htaccess and robots.txt. Links to sitemap and REST API. Add list of tools and references.
* Add transients for several server info

### 1.4.0 (March 2022)

* Options: Add interactive JSON tree viewer for array and object value types
* Transients: Add interactive JSON tree viewer for array and object value types

### 1.3.2 (March 2022)

* Transients: Enable ajax loading of transient values
* Transients: Consolidate and clean up transient-related functions

### 1.3.1 (March 2022)

* All modules: Update list of tools and references
* Hooks: Improve readability of non-core hooks list
* Options: add autoloaded options count and total size
* Options: add option size and data type
* Options: fix display of object type and XML/HTML values

### 1.3.0 (March 2022)

* Add WordPress > Options module to inspect value of WordPress core and also plugins and theme options in the wp_options table

### 1.2.0 (March 2022)

* General: Update shell_exec and exec check command
* Directories: add filesystem permissions info
* Database: Update database extension and client info check
* Media: Add Media Handling info
* PHP: Add Imagick and SUHOSIN checks
* Server: Add server location info

### 1.1.1 (March 2022)

* Add site health status visual indicator (green or orange dot)
* Disable auto-registered Gutenberg block on the plugin info page

### 1.1.0 (March 2022)

* Add site health status
* Prioritize use of myslq_ over mysql_ function

### 1.0.0 (March 2022)

* Initial stable release

## Upgrade Notice

None required yet.