<?php
/**
 * Theme Setup Class
 *
 * Registers theme supports, menus, sidebars, and core WordPress hooks
 *
 * @package MarketHub
 */

namespace MarketHub\Core;

class Theme {
    
    /**
     * Constructor - register all hooks
     */
    public function __construct() {
        $this->register_hooks();
    }
    
    /**
     * Register WordPress hooks
     */
    private function register_hooks(): void {
        add_action('after_setup_theme', [$this, 'setup_theme']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
        add_action('widgets_init', [$this, 'register_sidebars']);
    }
    
    /**
     * Theme setup: supports, menus, title tag
     */
    public function setup_theme(): void {
        // Core WordPress features
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support('automatic-feed-links');
        add_theme_support('html5', [
            'comment-list',
            'comment-form',
            'search-form',
            'gallery',
            'caption'
        ]);
        
        // WooCommerce support (for Project 1)
        add_theme_support('woocommerce');
        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');
        
        // Register navigation menus
        register_nav_menus([
            'primary' => __('Primary Menu', 'markethub'),
            'footer' => __('Footer Menu', 'markethub'),
            'vendor' => __('Vendor Dashboard Menu', 'markethub')
        ]);
        
        // Set content width for embeds
        if (!isset($GLOBALS['content_width'])) {
            $GLOBALS['content_width'] = 1200;
        }
    }
    
    /**
     * Enqueue styles and scripts
     * 
     * Note: Actual enqueue logic moves to Assets.php in next step
     * This is a placeholder to verify Theme class loads correctly
     */
    public function enqueue_assets(): void {
        // Temporary placeholder
        wp_enqueue_style(
            'markethub-style',
            get_stylesheet_uri(),
            [],
            '1.0.0'
        );
    }
    
    /**
     * Register widget sidebars
     */
    public function register_sidebars(): void {
        register_sidebar([
            'name' => __('Sidebar', 'markethub'),
            'id' => 'sidebar-1',
            'description' => __('Main sidebar for widgets', 'markethub'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>'
        ]);
        
        register_sidebar([
            'name' => __('Footer Widget Area', 'markethub'),
            'id' => 'footer-1',
            'description' => __('Footer widget columns', 'markethub'),
            'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="footer-widget-title">',
            'after_title' => '</h3>'
        ]);
    }
}
