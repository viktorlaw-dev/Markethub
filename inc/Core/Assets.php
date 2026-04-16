<?php
/**
 * Asset Management Class
 *
 * Enqueues styles and scripts with proper versioning and dependencies
 *
 * @package MarketHub
 */

namespace MarketHub\Core;

class Assets {
    
    /**
     * Constructor - register hooks
     */
    public function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'register_assets']);
    }
    
    /**
     * Register and enqueue assets
     */
    public function register_assets(): void {
        // === STYLES ===
        wp_enqueue_style(
            'markethub-main',
            get_stylesheet_directory_uri() . '/assets/dist/css/main.css',
            [], // Dependencies (none, Bootstrap is bundled)
            $this->get_version('assets/dist/css/main.css'),
            'all'
        );
        
        // === SCRIPTS ===
        wp_enqueue_script(
            'markethub-main',
            get_stylesheet_directory_uri() . '/assets/dist/js/main.js',
            [], // Dependencies (Bootstrap is bundled in webpack)
            $this->get_version('assets/dist/js/main.js'),
            true // Load in footer
        );
        
        // === LOCALIZE SCRIPT (Pass data to JS) ===
        wp_localize_script('markethub-main', 'markethubData', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('markethub_nonce'),
            'siteUrl' => get_site_url()
        ]);
    }
    
    /**
     * Get file version based on modification time
     *
     * @param string $path Relative path to file
     * @return string Version number
     */
    private function get_version(string $path): string {
        $file = get_stylesheet_directory() . '/' . $path;
        return file_exists($file) ? (string) filemtime($file) : '1.0.0';
    }
}
