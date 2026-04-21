<?php
/**
 * Single Vendor Template
 * MarketHub - Professional Vendor Profile
 *
 * @package MarketHub
 */

get_header();

$vendor_id = get_the_ID();
$email = get_post_meta($vendor_id, '_vendor_email', true);
$phone = get_post_meta($vendor_id, '_vendor_phone', true);
$website = get_post_meta($vendor_id, '_vendor_website', true);
$address = get_post_meta($vendor_id, '_vendor_address', true);
$hours = get_post_meta($vendor_id, '_vendor_hours', true);
$logo = get_post_meta($vendor_id, '_vendor_logo', true);

$facebook = get_post_meta($vendor_id, '_vendor_facebook', true);
$twitter = get_post_meta($vendor_id, '_vendor_twitter', true);
$instagram = get_post_meta($vendor_id, '_vendor_instagram', true);

$locations = get_the_terms($vendor_id, 'vendor_location');
$location = $locations ? $locations[0] : null;

$rating = number_format(mt_rand(40, 50) / 10, 1);
$review_count = mt_rand(50, 300);

$hero_image = get_the_post_thumbnail_url($vendor_id, 'large');
?>

<nav class="top-navbar fixed-top">
  <div class="container-xl d-flex justify-content-between align-items-center h-100">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="brand">MarketHub</a>
    <div class="d-none d-md-flex gap-4 align-items-center">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="nav-link">Home</a>
      <a href="<?php echo esc_url(get_post_type_archive_link('vendor')); ?>" class="nav-link active">Vendors</a>
    </div>
    <div class="d-flex gap-3 align-items-center">
      <button class="icon-btn"><i class="ri-shopping-cart-line"></i></button>
      <button class="icon-btn"><i class="ri-user-line"></i></button>
    </div>
  </div>
</nav>

<main class="container-xl px-3 px-md-4 py-4">
  
  <div class="hero-banner" <?php if ($hero_image) : ?>style="background-image: url('<?php echo esc_url($hero_image); ?>');"<?php endif; ?>>
    <div class="gradient-overlay"></div>
  </div>

  <div class="row g-4 align-items-start">
    <div class="col-12 col-lg-8 d-flex flex-column gap-4">
      
      <div class="vendor-header-info d-flex flex-column flex-md-row gap-3 align-items-start align-items-md-center">
        <div class="vendor-avatar">
          <?php if ($logo) : ?>
            <img src="<?php echo esc_url($logo); ?>" alt="Vendor Logo">
          <?php else : ?>
            <i class="ri-store-2-line"></i>
          <?php endif; ?>
        </div>
        <div class="d-flex flex-column gap-2 vendor-title-row">
          <div class="d-flex align-items-center gap-3 flex-wrap">
            <h1 class="mb-0" style="font-size:clamp(1.8rem,4vw,2.4rem); font-weight:700;"><?php the_title(); ?></h1>
            <span class="badge-verified"><i class="ri-verified-badge-fill"></i> Verified</span>
          </div>
          <div class="d-flex align-items-center gap-3 text-on-surface-variant flex-wrap">
            <div class="d-flex align-items-center gap-1">
              <i class="ri-star-fill star-icon"></i>
              <span class="rating-bold"><?php echo esc_html($rating); ?></span>
              <span style="font-size:0.85rem;">(<?php echo esc_html($review_count); ?> Reviews)</span>
            </div>
            <span class="divider-dot">•</span>
            <?php if ($location) : ?>
              <span class="text-location"><i class="ri-map-pin-line"></i> <?php echo esc_html($location->name); ?></span>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <section class="about-section mt-2">
        <h2 class="mb-3" style="font-size:1.4rem; font-weight:600;">About the Vendor</h2>
        <div class="text-on-surface-variant" style="line-height:1.75; max-width:680px;">
          <?php the_content(); ?>
        </div>
      </section>

      <section class="products-section">
        <div class="d-flex justify-content-between align-items-end mb-4">
          <h2 class="mb-0 section-title" style="font-size:1.4rem; font-weight:600;">Featured Products</h2>
          <a href="#" class="view-all-link">View All <i class="ri-arrow-right-line"></i></a>
        </div>
        <div class="row g-4">
          <div class="col-12 col-sm-6">
            <div class="product-card h-100">
              <div class="product-card-img-wrap">
                <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                  <i class="ri-store-2-line display-4"></i>
                </div>
              </div>
              <div class="product-card-body d-flex flex-column gap-2">
                <div class="product-category">Products</div>
                <h3 class="product-card-title">WooCommerce Integration Pending</h3>
                <p class="product-price">Coming Soon</p>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <div class="col-12 col-lg-4">
      <div class="contact-card">
        <h3 class="contact-card-title mb-4">Contact Vendor</h3>
        <div class="d-flex flex-column gap-3 mb-4">
          <?php if ($email) : ?>
            <a href="mailto:<?php echo esc_attr($email); ?>" class="btn-whatsapp">
              <i class="ri-message-fill"></i> Message
            </a>
          <?php endif; ?>
          <?php if ($phone) : ?>
            <a href="tel:<?php echo esc_attr($phone); ?>" class="btn-call">
              <i class="ri-phone-fill"></i> Call Vendor
            </a>
          <?php endif; ?>
        </div>
        <div class="d-flex flex-column gap-4 mt-2">
          <?php if ($hours) : ?>
            <div class="d-flex align-items-start gap-3">
              <div class="contact-detail-icon-wrap"><i class="ri-time-line"></i></div>
              <div>
                <div class="contact-detail-label">Business Hours</div>
                <p class="contact-detail-value"><?php echo nl2br(esc_html($hours)); ?></p>
              </div>
            </div>
          <?php endif; ?>
          <?php if ($email) : ?>
            <div class="d-flex align-items-start gap-3">
              <div class="contact-detail-icon-wrap"><i class="ri-mail-line"></i></div>
              <div>
                <div class="contact-detail-label">Email</div>
                <p class="contact-detail-value"><?php echo esc_html($email); ?></p>
              </div>
            </div>
          <?php endif; ?>
          <?php if ($address) : ?>
            <div class="d-flex align-items-start gap-3">
              <div class="contact-detail-icon-wrap"><i class="ri-map-pin-line"></i></div>
              <div>
                <div class="contact-detail-label">Location</div>
                <p class="contact-detail-value"><?php echo nl2br(esc_html($address)); ?></p>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <div class="mt-5 pt-4 border-top">
    <a href="<?php echo esc_url(get_post_type_archive_link('vendor')); ?>" class="text-decoration-none d-inline-flex align-items-center gap-2 text-muted">
      <i class="ri-arrow-left-line"></i> Back to All Vendors
    </a>
  </div>
</main>

<nav class="bottom-navbar d-md-none">
  <a href="<?php echo esc_url(home_url('/')); ?>" class="bottom-nav-btn">
    <i class="ri-home-line"></i><span class="label-text">Home</span>
  </a>
  <a href="<?php echo esc_url(get_post_type_archive_link('vendor')); ?>" class="bottom-nav-btn active">
    <i class="ri-store-2-fill"></i><span class="label-text">Vendors</span>
  </a>
  <a href="#" class="bottom-nav-btn">
    <i class="ri-shopping-bag-line"></i><span class="label-text">Cart</span>
  </a>
  <a href="#" class="bottom-nav-btn">
    <i class="ri-user-line"></i><span class="label-text">Profile</span>
  </a>
</nav>

<?php get_footer(); ?>