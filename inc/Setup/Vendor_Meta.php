<?php
/**
 * Vendor Meta Boxes
 *
 * Handles custom meta fields for Vendor post type
 *
 * @package MarketHub
 */

namespace MarketHub\Setup;

class Vendor_Meta {
    
    private const META_PREFIX = '_vendor_';
    
    public function __construct() {
        add_action('add_meta_boxes', [$this, 'add_vendor_meta_boxes']);
        add_action('save_post_vendor', [$this, 'save_vendor_meta'], 10, 2);
    }
    
    public function add_vendor_meta_boxes(): void {
        add_meta_box(
            'vendor-contact-info',
            __('Contact Information', 'markethub'),
            [$this, 'render_contact_meta_box'],
            'vendor',
            'normal',
            'high'
        );
        
        add_meta_box(
            'vendor-social-links',
            __('Social Media Links', 'markethub'),
            [$this, 'render_social_meta_box'],
            'vendor',
            'side',
            'default'
        );
    }
    
    public function render_contact_meta_box(\WP_Post $post): void {
        wp_nonce_field('vendor_meta_nonce', 'vendor_meta_nonce_field');
        
        $email = get_post_meta($post->ID, self::META_PREFIX . 'email', true);
        $phone = get_post_meta($post->ID, self::META_PREFIX . 'phone', true);
        $website = get_post_meta($post->ID, self::META_PREFIX . 'website', true);
        $address = get_post_meta($post->ID, self::META_PREFIX . 'address', true);
        $hours = get_post_meta($post->ID, self::META_PREFIX . 'hours', true);
        ?>
        <table class="form-table">
            <tr>
                <th><label for="vendor_email"><?php _e('Email Address', 'markethub'); ?></label></th>
                <td>
                    <input type="email" id="vendor_email" name="vendor_email" 
                           value="<?php echo esc_attr($email); ?>" class="regular-text" />
                </td>
            </tr>
            <tr>
                <th><label for="vendor_phone"><?php _e('Phone Number', 'markethub'); ?></label></th>
                <td>
                    <input type="text" id="vendor_phone" name="vendor_phone" 
                           value="<?php echo esc_attr($phone); ?>" class="regular-text" />
                </td>
            </tr>
            <tr>
                <th><label for="vendor_website"><?php _e('Website', 'markethub'); ?></label></th>
                <td>
                    <input type="url" id="vendor_website" name="vendor_website" 
                           value="<?php echo esc_attr($website); ?>" class="regular-text" />
                </td>
            </tr>
            <tr>
                <th><label for="vendor_address"><?php _e('Business Address', 'markethub'); ?></label></th>
                <td>
                    <textarea id="vendor_address" name="vendor_address" 
                              rows="3" class="large-text"><?php echo esc_textarea($address); ?></textarea>
                </td>
            </tr>
            <tr>
                <th><label for="vendor_hours"><?php _e('Business Hours', 'markethub'); ?></label></th>
                <td>
                    <textarea id="vendor_hours" name="vendor_hours" 
                              rows="3" class="large-text"><?php echo esc_textarea($hours); ?></textarea>
                </td>
            </tr>
        </table>
        <?php
    }
    
    public function render_social_meta_box(\WP_Post $post): void {
        $facebook = get_post_meta($post->ID, self::META_PREFIX . 'facebook', true);
        $twitter = get_post_meta($post->ID, self::META_PREFIX . 'twitter', true);
        $instagram = get_post_meta($post->ID, self::META_PREFIX . 'instagram', true);
        ?>
        <div class="vendor-social-fields">
            <p>
                <label for="vendor_facebook"><?php _e('Facebook', 'markethub'); ?></label><br/>
                <input type="url" id="vendor_facebook" name="vendor_facebook" 
                       value="<?php echo esc_attr($facebook); ?>" class="regular-text" />
            </p>
            <p>
                <label for="vendor_twitter"><?php _e('Twitter', 'markethub'); ?></label><br/>
                <input type="url" id="vendor_twitter" name="vendor_twitter" 
                       value="<?php echo esc_attr($twitter); ?>" class="regular-text" />
            </p>
            <p>
                <label for="vendor_instagram"><?php _e('Instagram', 'markethub'); ?></label><br/>
                <input type="url" id="vendor_instagram" name="vendor_instagram" 
                       value="<?php echo esc_attr($instagram); ?>" class="regular-text" />
            </p>
        </div>
        <?php
    }
    
    public function save_vendor_meta(int $post_id, \WP_Post $post): void {
        if (!isset($_POST['vendor_meta_nonce_field']) || 
            !wp_verify_nonce($_POST['vendor_meta_nonce_field'], 'vendor_meta_nonce')) {
            return;
        }
        
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        
        if (isset($_POST['vendor_email'])) {
            update_post_meta($post_id, self::META_PREFIX . 'email', sanitize_email($_POST['vendor_email']));
        }
        
        if (isset($_POST['vendor_phone'])) {
            update_post_meta($post_id, self::META_PREFIX . 'phone', sanitize_text_field($_POST['vendor_phone']));
        }
        
        if (isset($_POST['vendor_website'])) {
            update_post_meta($post_id, self::META_PREFIX . 'website', esc_url_raw($_POST['vendor_website']));
        }
        
        if (isset($_POST['vendor_address'])) {
            update_post_meta($post_id, self::META_PREFIX . 'address', sanitize_textarea_field($_POST['vendor_address']));
        }
        
        if (isset($_POST['vendor_hours'])) {
            update_post_meta($post_id, self::META_PREFIX . 'hours', sanitize_textarea_field($_POST['vendor_hours']));
        }
        
        if (isset($_POST['vendor_facebook'])) {
            update_post_meta($post_id, self::META_PREFIX . 'facebook', esc_url_raw($_POST['vendor_facebook']));
        }
        
        if (isset($_POST['vendor_twitter'])) {
            update_post_meta($post_id, self::META_PREFIX . 'twitter', esc_url_raw($_POST['vendor_twitter']));
        }
        
        if (isset($_POST['vendor_instagram'])) {
            update_post_meta($post_id, self::META_PREFIX . 'instagram', esc_url_raw($_POST['vendor_instagram']));
        }
    }
}