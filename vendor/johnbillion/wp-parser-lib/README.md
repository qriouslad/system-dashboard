# WP Parser Lib

This package contains the file scanning and hook parsing functionality from [WP Parser](https://github.com/WordPress/phpdoc-parser).

I did not write this code. I just abstracted it so it can be used independently of the WP Parser WordPress plugin.

## Requirements
* PHP 5.4+
* [Composer](https://getcomposer.org/)

## Installation

```bash
composer require johnbillion/wp-parser-lib
```

## Usage

```php
$files  = \WP_Parser\get_wp_files( $path );
$output = \WP_Parser\parse_files( $files, $path );
```

See [wp-hooks-generator](https://github.com/johnbillion/wp-hooks-generator/) as a full usage example.
