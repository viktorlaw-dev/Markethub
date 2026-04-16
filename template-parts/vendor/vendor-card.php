<?php
/**
 * Vendor Card Template Part
 *
 * Reusable component for displaying vendor cards
 *
 * @package MarketHub
 */

// Get vendor data
$vendor_id = get_the_ID();
$email = get_post_meta($vendor_id, '_vendor_email', true);
$phone = get_post_meta($vendor_id, '_vendor_phone', true);
$website = get_post_meta($vendor_id, '_vendor_website', true);

// Get taxonomy terms
$categories = get_the_terms($vendor_id, 'vendor_category');
$category = $categories ? $categories[0] : null;

$locations = get_the_terms($vendor_id, 'vendor_location');
$location = $locations ? $locations[0] : null;

// Get featured image
$thumbnail = get_the_post_thumbnail_url($vendor_id, 'medium');

// Generate initials for placeholder
$title = get_the_title();
$initials = strtoupper(substr($title, 0, 2));

// Placeholder rating (implement real ratings in Phase 2)
$rating = number_format(mt_rand(40, 50) / 10, 1);
?>

<article class="vendor-card">
    <!-- Card Image -->
    <div class="vendor-card__image-container">
        <?php if ($thumbnail) : ?>
            <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($title); ?>">
        <?php else : ?>
            <div class="vendor-card__placeholder" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); height: 100%; display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem; font-weight: bold;">
                <?php echo esc_html($initials); ?>
            </div>
        <?php endif; ?>

        <!-- Badges -->
        <div class="vendor-card__badges">
            <span class="vendor-card__badge vendor-card__badge--verified">
                <i class="ri-verified-badge-fill"></i>
                Verified
            </span>
        </div>
    </div>

    <!-- Card Body -->
    <div class="vendor-card__body">
        <!-- Category -->
        <?php if ($category) : ?>
            <span class="vendor-card__category"><?php echo esc_html($category->name); ?></span>
        <?php endif; ?>

        <!-- Rating -->
        <div class="vendor-card__rating">
            <i class="ri-star-fill"></i>
            <span><?php echo esc_html($rating); ?></span>
        </div>

        <!-- Vendor Name -->
        <h3 class="vendor-card__name">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>

        <!-- Location -->
        <?php if ($location) : ?>
            <div class="vendor-card__location">
                <i class="ri-map-pin-line"></i>
                <span><?php echo esc_html($location->name); ?></span>
            </div>
        <?php endif; ?>

        <!-- Description -->
        <?php if (has_excerpt()) : ?>
            <p class="vendor-card__description"><?php echo esc_html(get_the_excerpt()); ?></p>
        <?php endif; ?>

        <!-- Actions -->
        <div class="vendor-card__actions">
            <a href="<?php the_permalink(); ?>" class="vendor-card__btn-primary">View Profile</a>
            
            <?php if ($phone) : ?>
                <button class="vendor-card__btn-icon" title="Call Vendor">
                    <i class="ri-phone-line"></i>
                </button>
            <?php endif; ?>
            
            <?php if ($email) : ?>
                <button class="vendor-card__btn-icon" title="Contact Vendor">
                    <i class="ri-message-line"></i>
                </button>
            <?php endif; ?>
        </div>
    </div>
</article>