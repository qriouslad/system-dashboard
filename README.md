# System Dashboard

Contributors: qriouslad  
Donate link: https://paypal.me/qriouslad
Tags: system monitor, wordpress components, action filter hooks, server info, developer  
Requires at least: 4.8  
Tested up to: 5.9.2  
Stable tag: 1.3.1  
Requires PHP: 5.6  
License: GPLv2 or later  
License URI: http://www.gnu.org/licenses/gpl-2.0.html

![](.wordpress-org/banner-772x250.png)

Centralized dashboard to monitor various WordPress components, stats and data, including the server.

## Description

This plugin provides a centralized dashboard to monitor various WordPress components, stats and data, including server hardware, software and resource usage. 

### Features

* WordPress dashboard modules currently include: Overview, Directories, Database, Post Types & Taxonomies, Media, Custom Fields, Users, Options, Transients, Cron (Jobs), Hooks, Classes, Functions, Constants.
* Server dashboard modules currently include: Overview, Monitor (CPU, RAM, Disk), Hardware and PHP.

### Technical Notes

* Requires shell_exec and exec functions enabled for some modules to work properly. 
* First load of the dashboard may take up to 60 seconds because the plugin is scanning hooks from active theme and plugins.

### Give Back

* [A nice review](https://wordpress.org/plugins/system-dashboard/#reviews) would be great!
* [Github repo](https://github.com/qriouslad/system-dashboard) to contribute code.
* [PayPal.me](https://paypal.me/qriouslad) to fuel my dev work with a supply of milk tea.

## Screenshots

1. The dashboard
   ![The dashboard](.wordpress-org/screenshot-1.png)

## Frequently Asked Questions

### How was this plugin built?

System Dashboard was built with: [WordPress Plugin Boilerplate](https://github.com/devinvinson/WordPress-Plugin-Boilerplate/) | [wppb.me](https://wppb.me/) | [CodeStar framework](https://github.com/Codestar/codestar-framework)

## Changelog

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
