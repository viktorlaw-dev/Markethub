<?php
/**
 * Vendor Custom Post Type
 *
 * Registers the 'vendor' post type for marketplace sellers
 *
 * @package MarketHub
 */

namespace MarketHub\Setup;

class Vendor_CPT {
    
    /**
     * Constructor - register hooks
     */
    public function __construct() {
        add_action('init', [$this, 'register_vendor_cpt']);
        add_action('init', [$this, 'register_vendor_taxonomies']);
    }
    
    /**
     * Register Vendor post type
     */
    public function register_vendor_cpt(): void {
        $labels = [
            'name' => __('Vendors', 'markethub'),
            'singular_name' => __('Vendor', 'markethub'),
            'menu_name' => __('Vendors', 'markethub'),
            'add_new' => __('Add New', 'markethub'),
            'add_new_item' => __('Add New Vendor', 'markethub'),
            'edit_item' => __('Edit Vendor', 'markethub'),
            'new_item' => __('New Vendor', 'markethub'),
            'view_item' => __('View Vendor', 'markethub'),
            'search_items' => __('Search Vendors', 'markethub'),
            'not_found' => __('No vendors found', 'markethub'),
            'not_found_in_trash' => __('No vendors found in trash', 'markethub'),
            'all_items' => __('All Vendors', 'markethub'),
        ];
        
        $args = [
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => ['slug' => 'vendor'],
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => 20,
            'menu_icon' => 'dashicons-businessperson',
            'supports' => [
                'title',
                'editor',
                'thumbnail',
                'excerpt',
                'custom-fields'
            ],
            'show_in_rest' => true, // Enable Gutenberg/REST API
        ];
        
        register_post_type('vendor', $args);
    }
    
    /**
     * Register Vendor taxonomies
     */
    public function register_vendor_taxonomies(): void {
        // Vendor Category taxonomy
        $category_labels = [
            'name' => __('Vendor Categories', 'markethub'),
            'singular_name' => __('Vendor Category', 'markethub'),
            'search_items' => __('Search Categories', 'markethub'),
            'all_items' => __('All Categories', 'markethub'),
            'edit_item' => __('Edit Category', 'markethub'),
            'add_new_item' => __('Add New Category', 'markethub'),
            'new_item_name' => __('New Category Name', 'markethub'),
            'menu_name' => __('Categories', 'markethub'),
        ];
        
        register_taxonomy('vendor_category', 'vendor', [
            'labels' => $category_labels,
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => ['slug' => 'vendor-category'],
            'show_in_rest' => true,
        ]);
        
        // Vendor Location taxonomy
        $location_labels = [
            'name' => __('Vendor Locations', 'markethub'),
            'singular_name' => __('Vendor Location', 'markethub'),
            'search_items' => __('Search Locations', 'markethub'),
            'all_items' => __('All Locations', 'markethub'),
            'edit_item' => __('Edit Location', 'markethub'),
            'add_new_item' => __('Add New Location', 'markethub'),
            'new_item_name' => __('New Location Name', 'markethub'),
            'menu_name' => __('Locations', 'markethub'),
        ];
        
        register_taxonomy('vendor_location', 'vendor', [
            'labels' => $location_labels,
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => ['slug' => 'vendor-location'],
            'show_in_rest' => true,
        ]);
    }
}