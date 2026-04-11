<?php
/**
 * MarketHub Theme Bootstrap
 *
 * Initializes the theme by loading the autoloader and core classes.
 * Keep this file under 100 lines. All logic belongs in inc/ classes.
 *
 * @package MarketHub
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// 1. Hire the Librarian (Autoloader)
require_once get_stylesheet_directory() . '/inc/Core/Autoloader.php';
MarketHub\Core\Autoloader::register();

// 2. Hire the Manager (Theme)
new MarketHub\Core\Theme();

// 3. Hire the Asset Handler (Assets)
new MarketHub\Core\Assets();

// 4. Hire the Vendor CPT Registrar (Setup)
new MarketHub\Setup\Vendor_CPT();

// 5. Done. No logic below this line.