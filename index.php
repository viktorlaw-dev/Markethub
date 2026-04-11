<?php
/**
 * Main fallback template
 *
 * @package MarketHub
 */

get_header();
?>

<main class="site-main">
    <div class="container">
        <h1>MarketHub Theme Active</h1>
        
        <?php
        // WordPress Loop (for future content)
        if (have_posts()) :
            while (have_posts()) :
                the_post();
                the_content();
            endwhile;
        endif;
        ?>
    </div>
</main>

<?php
get_footer();