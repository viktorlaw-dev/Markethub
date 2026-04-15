<?php
/**
 * Vendor Archive Template
 *
 * Displays all vendors in a grid layout
 *
 * @package MarketHub
 */

get_header();
?>

<main class="site-main">
    <div class="container py-5">
        <h1 class="mb-4">Our Vendors</h1>
        
        <?php
        $args = [
            'post_type' => 'vendor',
            'posts_per_page' => 12,
            'paged' => get_query_var('paged') ?: 1,
        ];
        
        $vendor_query = new WP_Query($args);
        
        if ($vendor_query->have_posts()) :
            echo '<div class="row">';
            
            while ($vendor_query->have_posts()) :
                $vendor_query->the_post();
                
                $website = get_post_meta(get_the_ID(), '_vendor_website', true);
                $email = get_post_meta(get_the_ID(), '_vendor_email', true);
                ?>
                
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h2 class="card-title">
                                <a href="<?php the_permalink(); ?>" class="text-decoration-none">
                                    <?php the_title(); ?>
                                </a>
                            </h2>
                            
                            <?php if ($website) : ?>
                                <p class="card-text">
                                    <a href="<?php echo esc_url($website); ?>" target="_blank" rel="noopener">
                                        Visit Website
                                    </a>
                                </p>
                            <?php endif; ?>
                            
                            <?php if ($email) : ?>
                                <p class="card-text text-muted">
                                    <?php echo esc_html($email); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                        <div class="card-footer">
                            <a href="<?php the_permalink(); ?>" class="btn btn-primary">View Profile</a>
                        </div>
                    </div>
                </div>
                
                <?php
            endwhile;
            
            echo '</div>';
            
            wp_reset_postdata();
            
        else :
            echo '<div class="alert alert-info">No vendors found.</div>';
        endif;
        ?>
    </div>
</main>

<?php
get_footer();