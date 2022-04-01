# System Dashboard

Contributors: qriouslad  
Donate link: https://paypal.me/qriouslad
Tags: system monitor, wordpress components, action filter hooks, server info, developer  
Requires at least: 4.8  
Tested up to: 5.9.2  
Stable tag: 2.2.0  
Requires PHP: 5.6  
License: GPLv2 or later  
License URI: http://www.gnu.org/licenses/gpl-2.0.html

![](.wordpress-org/banner-772x250.png)

Centralized dashboard to monitor various WordPress components, stats and data, including the server.

## Description

This plugin provides a centralized dashboard to monitor various WordPress components, stats and data, including server hardware, software and resource usage. Pairs well with [Query Monitor](https://wordpress.org/plugins/query-monitor/) and [WP Console](https://wordpress.org/plugins/wp-console/) to help you do some solid dev work.

Despite having 18 WordPress modules and 4 server modules, the single-page dashboard loads fast as queries are optimized and most modules employ fast AJAX loading of data. It does not weight down wp-admin, and nothing is loaded on the front-end. Install, activate and let it sit there ready to summon the info/data you need.

To preview the module screenshots more easily, please scroll down the [github repo](https://github.com/qriouslad/system-dashboard). Here's a rundown of the available modules...

### WordPress Modules (18)

#### 1. Overview: 

* Site health status
* Quick stats of active theme and plugins
* Timezone and current time
* Your IP address

#### 2. Directories: 

* Root path
* Directory size of WP installation, wp-content directory, uploads directory, plugins directory, themes directory
* Filesystem permissions

#### 3. Database: 

* Software info
* Uptime
* Data size
* Index size
* List of WP core tables with data/index size and number of rows/records of each table
* List of tables created/used by themes and plugins with the origin theme/plugin, data/index size and number of rows/records of each table
* Key database info, e.g. innodb_buffer_pool_size
* Detailed specifications

#### 4. Post Types & Taxonomies: 

* List of post types and posts count for each
* List of taxonomies and terms count for each
* Comment count
* List of old slugs and the corresponding posts

#### 5. Media: 

* List of media types and files count for each
* List of allowed mime types and the corresponding file extensions
* Media handling info, e.g. max file upload size

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
* AJAX loading of option value with interactive tree viewer for array and object value types 

#### 9. Transients: 

* Total number of transients
* Total number and size of autoloaded transients
* List of transients with expiration, including time left to expiry
* List of expired transients
* List of transients that do not expire
* AJAX loading of transient value with interactive tree viewer for array and object value types 

#### 10. Cron:

* List of cron event hooks and recurrences, categorized by core vs non-core

#### 11. Rewrite Rules:

* List of rewrite rules

#### 12. Shortcodes:

* List of shortcodes and renderers (callback functions)

#### 13. Viewer: 

* wp-config.php viewer
* .htaccess viewer
* REST API viewer
* robots.txt viewer
* Link to sitemap

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

### Server Modules (3)

#### 1. Overview: 

* Server operating system
* Web server software
* Server IP address
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
* This plugin has been tested to work with servers powered by NGINX, Apache and Litespeed, and also sites using PHP 8+.

### Give Back

* [A nice review](https://wordpress.org/plugins/system-dashboard/#reviews) would be great!
* [Give feedback](https://wordpress.org/support/plugin/system-dashboard/) and help improve future versions.
* [Github repo](https://github.com/qriouslad/system-dashboard) to contribute code.
* [Donate](https://paypal.me/qriouslad) and support my work. Close to 200 dev hours have been spent towards v2.0.0 so far.

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
13. Viewer module
   ![Viewer module](.wordpress-org/screenshot-13.png)
14. Hooks module
   ![Hooks module](.wordpress-org/screenshot-14.png)
15. Classes module
   ![Classes module](.wordpress-org/screenshot-15.png)
16. Functions module
   ![Functions module](.wordpress-org/screenshot-16.png)
17. Globals module
   ![Globals module](.wordpress-org/screenshot-17.png)
18. Constants module
   ![Constants module](.wordpress-org/screenshot-18.png)
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