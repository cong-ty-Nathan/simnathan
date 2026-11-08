<?php get_header(); ?>

<?php
$selected_tour_sort = isset($_GET['tour_sort']) && is_string($_GET['tour_sort'])
    ? sanitize_key(wp_unslash($_GET['tour_sort']))
    : '';
?>

<!-- page-header -->
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-caption">
                    <h1 class="page-title">Tours</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.page-header-->
<!-- destination-section -->
<div class="content">
    <div class="container">
        <div class="row">
            

            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <?php get_template_part('template-parts/content', 'tour'); ?>

                <?php endwhile; ?>
            <?php else : ?>
                <div class="col-12">
                    <p><?php esc_html_e('No tours found.', 'travelme'); ?></p>
                </div>
            <?php endif; ?>

            <!-- pagination start -->
            <?php custom_pagination($wp_query); ?>
            <!-- pagination close -->
        </div>
    </div>
</div>
<!-- /.destination-section -->
<!-- newsletter-section -->


<?php get_footer(); ?>