<?php
/**
 * Vendor Archive Template
 *
 * Displays all vendors with filtering capabilities
 *
 * @package MarketHub
 */

// Get filter values from URL
$search = isset($_GET['search']) ? sanitize_text_field($_GET['search']) : '';
$category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';
$location = isset($_GET['location']) ? sanitize_text_field($_GET['location']) : '';
$sort = isset($_GET['sort']) ? sanitize_text_field($_GET['sort']) : 'popular';

// Build query args
$args = [
    'post_type' => 'vendor',
    'posts_per_page' => 12,
    'paged' => get_query_var('paged') ?: 1,
    'orderby' => 'date',
    'order' => 'DESC',
];

// Add search
if ($search) {
    $args['s'] = $search;
}

// Add taxonomy filters
$tax_query = ['relation' => 'AND'];

if ($category) {
    $tax_query[] = [
        'taxonomy' => 'vendor_category',
        'field' => 'slug',
        'terms' => $category,
    ];
}

if ($location) {
    $tax_query[] = [
        'taxonomy' => 'vendor_location',
        'field' => 'slug',
        'terms' => $location,
    ];
}

if (count($tax_query) > 1) {
    $args['tax_query'] = $tax_query;
}

// Add sorting
switch ($sort) {
    case 'rating':
        $args['orderby'] = 'title';
        $args['order'] = 'ASC';
        break;
    case 'newest':
        $args['orderby'] = 'date';
        $args['order'] = 'DESC';
        break;
    case 'popular':
    default:
        $args['orderby'] = 'date';
        $args['order'] = 'DESC';
        break;
}

$vendor_query = new WP_Query($args);

get_header();
?>

<main class="vendor-archive py-5">
    <div class="container">
        
        <!-- Archive Header -->
        <header class="vendor-archive__header mb-5">
            <h1>Find Your Preferred Vendor</h1>
            <p>Discover high-quality local consumable brands curated for your taste and health needs.</p>
        </header>

        <!-- Filters -->
        <section class="vendor-archive__filters mb-5">
            <form method="GET" action="<?php echo esc_url(get_post_type_archive_link('vendor')); ?>">
                <div class="row g-4">
                    <!-- Search -->
                    <div class="col-lg-3">
                        <div class="filter-group">
                            <label for="vendor-search">Search</label>
                            <div class="search-wrapper">
                                <i class="ri ri-search-line"></i>
                                <input 
                                    type="text" 
                                    id="vendor-search" 
                                    name="search" 
                                    placeholder="Search by name..." 
                                    value="<?php echo esc_attr($search); ?>"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Category -->
                    <div class="col-lg-2">
                        <div class="filter-group">
                            <label for="vendor-category">Category</label>
                            <select id="vendor-category" name="category">
                                <option value="">All Categories</option>
                                <?php
                                $categories = get_terms([
                                    'taxonomy' => 'vendor_category',
                                    'hide_empty' => true,
                                ]);
                                foreach ($categories as $cat) :
                                    ?>
                                    <option value="<?php echo esc_attr($cat->slug); ?>" <?php selected($category, $cat->slug); ?>>
                                        <?php echo esc_html($cat->name); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Location -->
                    <div class="col-lg-2">
                        <div class="filter-group">
                            <label for="vendor-location">Location</label>
                            <select id="vendor-location" name="location">
                                <option value="">All Locations</option>
                                <?php
                                $locations = get_terms([
                                    'taxonomy' => 'vendor_location',
                                    'hide_empty' => true,
                                ]);
                                foreach ($locations as $loc) :
                                    ?>
                                    <option value="<?php echo esc_attr($loc->slug); ?>" <?php selected($location, $loc->slug); ?>>
                                        <?php echo esc_html($loc->name); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="col-lg-3">
                        <div class="filter-group">
                            <label>&nbsp;</label>
                            <div class="vendor-archive__filters__actions">
                                <button type="submit" class="vendor-archive__filters__btn-apply">Apply</button>
                                <a href="<?php echo esc_url(get_post_type_archive_link('vendor')); ?>" class="vendor-archive__filters__btn-reset" title="Reset Filters">
                                    <i class="ri-refresh-line"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>

        <!-- Results Info & Sorting -->
        <section class="vendor-archive__results-info">
            <div class="vendor-archive__results-info__count">
                <?php echo esc_html($vendor_query->found_posts); ?>
                <span>vendors found</span>
            </div>
            <div class="vendor-archive__results-info__sort">
                <label>Sort By:</label>
                <select onchange="window.location.href=this.value">
                    <option value="<?php echo esc_url(add_query_arg('sort', 'popular', get_permalink())); ?>" <?php selected($sort, 'popular'); ?>>Most Popular</option>
                    <option value="<?php echo esc_url(add_query_arg('sort', 'rating', get_permalink())); ?>" <?php selected($sort, 'rating'); ?>>Highest Rated</option>
                    <option value="<?php echo esc_url(add_query_arg('sort', 'newest', get_permalink())); ?>" <?php selected($sort, 'newest'); ?>>Newest Arrival</option>
                </select>
            </div>
        </section>

        <!-- Vendor Grid -->
        <?php if ($vendor_query->have_posts()) : ?>
            <section class="vendor-archive__grid row">
                <?php while ($vendor_query->have_posts()) : $vendor_query->the_post(); ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <?php get_template_part('template-parts/vendor/vendor-card'); ?>
                    </div>
                <?php endwhile; ?>
            </section>

            <!-- Pagination -->
            <div class="vendor-archive__pagination">
                <?php
                echo paginate_links([
                    'total' => $vendor_query->max_num_pages,
                    'current' => max(1, get_query_var('paged')),
                    'prev_text' => '<span class="ri ri-arrow-left-s-line"></span>',
                    'next_text' => '<span class="ri ri-arrow-right-s-line"></span>',
                    'mid_size' => 2,
                    'type' => 'list',
                ]);
                ?>
            </div>

            <?php wp_reset_postdata(); ?>
        <?php else : ?>
            <div class="vendor-archive__empty-state">
                <h3>No Vendors Found</h3>
                <p>Try adjusting your filters or check back soon!</p>
                <a href="<?php echo esc_url(get_post_type_archive_link('vendor')); ?>" class="btn btn-primary">View All Vendors</a>
            </div>
        <?php endif; ?>
    </div>
</main>

<!-- Mobile Bottom Navigation -->
<nav class="mobile-nav">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="mobile-nav__item">
        <span class="ri ri-home-line"></span>
        <span>Home</span>
    </a>
    <a href="<?php echo esc_url(get_post_type_archive_link('vendor')); ?>" class="mobile-nav__item active">
        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">storefront</span>
        <span>Vendors</span>
    </a>
    <a href="#" class="mobile-nav__item">
        <span class="ri ri-compass-line"></span>
        <span>Explore</span>
    </a>
    <a href="#" class="mobile-nav__item">
        <span class="ri ri-user-line"></span>
        <span>Profile</span>
    </a>
</nav>

<?php
get_footer();