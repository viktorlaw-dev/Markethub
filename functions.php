<?php
/**
 * MarketHub Theme Bootstrap
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once get_stylesheet_directory() . '/inc/Core/Autoloader.php';
MarketHub\Core\Autoloader::register();

new MarketHub\Core\Theme();
new MarketHub\Core\Assets();
new MarketHub\Setup\Vendor_CPT();
new MarketHub\Setup\Vendor_Meta();