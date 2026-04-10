<?php
/**
 * PSR-4 Autoloader
 *
 * Maps MarketHub\ namespace to inc/ directory
 *
 * @package MarketHub
 */

namespace MarketHub\Core;

class Autoloader {
    
    /**
     * Namespace prefix
     */
    private const NAMESPACE_PREFIX = 'MarketHub\\';
    
    /**
     * Base directory for namespace
     */
    private const BASE_DIR = __DIR__ . '/../';
    
    /**
     * Register autoloader
     */
    public static function register(): void {
        spl_autoload_register([self::class, 'autoload']);
    }
    
    /**
     * Autoload callback
     *
     * @param string $class Fully qualified class name
     */
    public static function autoload(string $class): void {
        // Check if class belongs to our namespace
        if (strpos($class, self::NAMESPACE_PREFIX) !== 0) {
            return;
        }
        
        // Remove namespace prefix
        $relative_class = substr($class, strlen(self::NAMESPACE_PREFIX));
        
        // Convert namespace separators to directory separators
        $file_path = self::BASE_DIR . str_replace('\\', '/', $relative_class) . '.php';
        
        // Load file if exists
        if (file_exists($file_path)) {
            require_once $file_path;
        }
    }
}
