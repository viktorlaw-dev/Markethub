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
        // Contact Information
        add_meta_box(
            'vendor-contact-info',
            __('Contact Information', 'markethub'),
            [$this, 'render_contact_meta_box'],
            'vendor',
            'normal',
            'high'
        );
        
        // Vendor Logo
        add_meta_box(
            'vendor-logo',
            __('Vendor Logo', 'markethub'),
            [$this, 'render_logo_meta_box'],
            'vendor',
            'side',
            'default'
        );
        
        // Social Media
        add_meta_box(
            'vendor-social-media',
            __('Social Media', 'markethub'),
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
                <th><label for="vendor_email">Email Address</label></th>
                <td>
                    <input type="email" id="vendor_email" name="vendor_email" 
                           value="<?php echo esc_attr($email); ?>" class="regular-text" />
                </td>
            </tr>
            <tr>
                <th><label for="vendor_phone">Phone Number</label></th>
                <td>
                    <input type="text" id="vendor_phone" name="vendor_phone" 
                           value="<?php echo esc_attr($phone); ?>" class="regular-text" />
                </td>
            </tr>
            <tr>
                <th><label for="vendor_website">Website</label></th>
                <td>
                    <input type="url" id="vendor_website" name="vendor_website" 
                           value="<?php echo esc_attr($website); ?>" class="regular-text" />
                </td>
            </tr>
            <tr>
                <th><label for="vendor_address">Business Address</label></th>
                <td>
                    <textarea id="vendor_address" name="vendor_address" 
                              rows="3" class="large-text"><?php echo esc_textarea($address); ?></textarea>
                </td>
            </tr>
            <tr>
                <th><label for="vendor_hours">Business Hours</label></th>
                <td>
                    <textarea id="vendor_hours" name="vendor_hours" 
                              rows="3" class="large-text"><?php echo esc_textarea($hours); ?></textarea>
                    <p class="description">Example: Mon - Sat: 9:00 AM - 6:00 PM</p>
                </td>
            </tr>
        </table>
        <?php
    }
    
    public function render_logo_meta_box(\WP_Post $post): void {
        $logo = get_post_meta($post->ID, self::META_PREFIX . 'logo', true);
        ?>
        <div class="vendor-logo-upload">
            <input type="hidden" id="vendor_logo" name="vendor_logo" value="<?php echo esc_attr($logo); ?>" />
            <button type="button" class="button" id="upload_logo_btn">Upload Logo</button>
            <button type="button" class="button" id="remove_logo_btn" style="display: <?php echo $logo ? 'inline' : 'none'; ?>;">Remove Logo</button>
            <div id="logo_preview" style="margin-top: 10px;">
                <?php if ($logo) : ?>
                    <img src="<?php echo esc_url($logo); ?>" alt="Vendor Logo" style="max-width: 150px; height: auto; border-radius: 8px;" />
                <?php endif; ?>
            </div>
        </div>
        
        <script>
        jQuery(document).ready(function($) {
            var mediaUploader;
            
            $('#upload_logo_btn').click(function(e) {
                e.preventDefault();
                
                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }
                
                mediaUploader = wp.media({
                    title: 'Choose Vendor Logo',
                    button: { text: 'Use this image' },
                    library: { type: 'image' },
                    multiple: false
                });
                
                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    $('#vendor_logo').val(attachment.url);
                    $('#logo_preview').html('<img src="' + attachment.url + '" alt="Vendor Logo" style="max-width: 150px; height: auto; border-radius: 8px;" />');
                    $('#remove_logo_btn').show();
                });
                
                mediaUploader.open();
            });
            
            $('#remove_logo_btn').click(function(e) {
                e.preventDefault();
                $('#vendor_logo').val('');
                $('#logo_preview').html('');
                $(this).hide();
            });
        });
        </script>
        <?php
    }
    
    public function render_social_meta_box(\WP_Post $post): void {
        $facebook = get_post_meta($post->ID, self::META_PREFIX . 'facebook', true);
        $twitter = get_post_meta($post->ID, self::META_PREFIX . 'twitter', true);
        $instagram = get_post_meta($post->ID, self::META_PREFIX . 'instagram', true);
        ?>
        <div class="vendor-social-fields">
            <p>
                <label for="vendor_facebook"><strong>Facebook</strong></label><br/>
                <input type="url" id="vendor_facebook" name="vendor_facebook" 
                       value="<?php echo esc_attr($facebook); ?>" class="regular-text" placeholder="https://facebook.com/yourpage" />
            </p>
            <p>
                <label for="vendor_twitter"><strong>Twitter / X</strong></label><br/>
                <input type="url" id="vendor_twitter" name="vendor_twitter" 
                       value="<?php echo esc_attr($twitter); ?>" class="regular-text" placeholder="https://twitter.com/yourhandle" />
            </p>
            <p>
                <label for="vendor_instagram"><strong>Instagram</strong></label><br/>
                <input type="url" id="vendor_instagram" name="vendor_instagram" 
                       value="<?php echo esc_attr($instagram); ?>" class="regular-text" placeholder="https://instagram.com/yourhandle" />
            </p>
        </div>
        <?php
    }
    
    public function save_vendor_meta(int $post_id, \WP_Post $post): void {
        // Verify nonce
        if (!isset($_POST['vendor_meta_nonce_field']) || 
            !wp_verify_nonce($_POST['vendor_meta_nonce_field'], 'vendor_meta_nonce')) {
            return;
        }
        
        // Check autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        
        // Check permissions
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        
        // Contact info
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
        
        // Logo
        if (isset($_POST['vendor_logo'])) {
            update_post_meta($post_id, self::META_PREFIX . 'logo', esc_url_raw($_POST['vendor_logo']));
        }
        
        // Social media
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