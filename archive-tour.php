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
            <div class="col-12 mb-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                    <p class="mb-3 mb-md-0" aria-live="polite">
                        <?php
                        printf(
                            esc_html__('%s tours found', 'travelme'),
                            esc_html(number_format_i18n($wp_query->found_posts))
                        );
                        ?>
                    </p>
                    <form class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center" method="get" action="<?php echo esc_url(get_post_type_archive_link('tour')); ?>">
                        <?php if (!empty($_GET['country']) && is_string($_GET['country'])) : ?>
                            <input type="hidden" name="country" value="<?php echo esc_attr(sanitize_text_field(wp_unslash($_GET['country']))); ?>">
                        <?php endif; ?>
                        <?php if (!empty($_GET['datepicker']) && is_string($_GET['datepicker'])) : ?>
                            <input type="hidden" name="datepicker" value="<?php echo esc_attr(sanitize_text_field(wp_unslash($_GET['datepicker']))); ?>">
                        <?php endif; ?>
                        <label class="mb-2 mb-sm-0 mr-sm-2" for="tour-price-sort"><?php esc_html_e('Sắp xếp theo giá', 'travelme'); ?></label>
                        <select class="form-control mb-2 mb-sm-0 mr-sm-2" id="tour-price-sort" name="tour_sort" aria-label="<?php esc_attr_e('Sắp xếp tour theo giá', 'travelme'); ?>">
                            <option value="" <?php selected('', $selected_tour_sort); ?>><?php esc_html_e('Mặc định', 'travelme'); ?></option>
                            <option value="price_asc" <?php selected('price_asc', $selected_tour_sort); ?>><?php esc_html_e('Giá thấp đến cao', 'travelme'); ?></option>
                            <option value="price_desc" <?php selected('price_desc', $selected_tour_sort); ?>><?php esc_html_e('Giá cao đến thấp', 'travelme'); ?></option>
                        </select>
                        <button class="btn btn-primary" type="submit"><?php esc_html_e('Áp dụng', 'travelme'); ?></button>
                    </form>
                </div>
            </div>

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