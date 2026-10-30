<?php
get_header();

?>
<!-- slider -->
<div class="slider">
    <div class="owl-carousel owl-one owl-theme">
        <?php
        //Bước 1: Lấy dữ liệu từ ACF với field name = slider_banner
        $slider_home = get_field("slider_banner");
        //Bước 2: Kiểm tra dữ liệu có tồn tại hay không
        if (!is_null($slider_home)) :
            // echo "<pre>";
            // var_dump($slider_home);
            // echo "</pre>";
        ?>
            <!-- Bước 4: Duyệt qua từng slide -->
            <?php foreach ($slider_home as $slide) : ?>
                <div class="item">
                    <div class="slider-img">
                        <img src="<?= esc_url($slide["slide_image"]["url"]); ?> " alt="">
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                <div class="slider-captions">
                                    <h1 class="slider-title"><?= esc_html($slide["slide_title"]); ?></h1>
                                    <?php if (!is_null($slide["slide_button"])) : ?>
                                        <a href="<?= esc_url($slide["slide_button"]["url"]); ?>" class="btn btn-primary" target="<?= esc_attr($slide["slide_button"]["target"]); ?>"><?= esc_html($slide["slide_button"]["title"]); ?></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <!-- Bước 3: đóng lệnh if -->
        <?php endif; ?>

    </div>
</div>
<!-- /.slider -->
<!-- enguiry-form -->
<div class="bg-default enquiry-form ">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                <!-- form -->
                <form action="<?= get_post_type_archive_link('tour'); ?>" method="GET">
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-3 col-12">
                            <div class="form-group">
                                <label class="control-label sr-only" for="select"></label>
                                <div class="select">
                                    <select id="select" name="country" class="form-control">
                                        <option value="">Bạn dự định đi đâu?</option>
                                        <option value="viet-nam">Việt Nam</option>
                                        <option value="trung-quoc">Trung Quốc</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-3 col-12">
                            <div class="form-group">
                                <label class="control-label sr-only" for="datepicker"></label>
                                <div class="input-group">
                                    <input id="datepicker" name="datepicker" type="text" placeholder="Ngày khởi hành" class="form-control">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="post_type" value="tour">
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-3 col-12">
                            <button type="submit" class="btn btn-primary btn-lg">Enquiry Now</button>
                        </div>
                    </div>
                </form>
                <!-- /.form -->
            </div>
        </div>
    </div>
</div>
<!-- /.enguiry-form -->
<!-- tour-service -->
<div class="space-medium">
    <div class="container">
        <?php
        // Lấy các terms từ taxonomy tour-type
        $tour_terms = get_terms(array(
            'taxonomy' => 'tour-type',
            'hide_empty' => false,
        ));

        if (!empty($tour_terms) && !is_wp_error($tour_terms)) :
            $idx = 1;
            // echo "<pre>";
            // var_dump($tour_terms);
            // echo "</pre>";
            foreach ($tour_terms as $term) :
                // Lấy ACF fields nếu có
                $term_image = get_field('tour_type_image', $term);
                $term_link = get_term_link($term);

                // Nếu không có fields, dùng giá trị mặc định
                $image_url = !empty($term_image) ? esc_url($term_image['url']) : get_template_directory_uri() . '/assets/images/tour_img_1.jpg';

        ?>
                <?php if ($idx % 2 === 0) : ?>
                    <!-- tour-item -->
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 offset-md-1 col-md-4 col-sm-12 col-12 mb40">
                            <div class="tour-img">
                                <a href="<?= esc_url($term_link); ?>" class="imghover">
                                    <img src="<?= $image_url; ?>" alt="<?= esc_attr($term->name); ?>" class="img-fluid">
                                </a>
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-5 offset-md-1 col-md-5 col-sm-12 col-12 mb40">
                            <div class="tour-block">
                                <div class="tour-content">
                                    <h2 class="mb30"><a href="<?= esc_url($term_link); ?>" class="title"><?= esc_html($term->name); ?></a></h2>
                                    <p class="mb30"><?= $term->description; ?></p>
                                    <a href="<?= esc_url($term_link); ?>" class="btn-link">Go For <?= esc_html($term->name); ?><i class="fa fa-angle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="row">
                        <div class="col-xl-5 col-lg-5 offset-md-1 col-md-5 col-sm-12 col-12 mb40">
                            <div class="tour-block">
                                <div class="tour-content">
                                    <h2 class="mb30"><a href="<?= esc_url($term_link); ?>" class="title"><?= esc_html($term->name); ?></a></h2>
                                    <p class="mb30"><?= $term->description; ?></p>
                                    <a href="<?= esc_url($term_link); ?>" class="btn-link">Go For <?= esc_html($term->name); ?><i class="fa fa-angle-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 offset-md-1 col-md-4 col-sm-12 col-12 mb40">
                            <div class="tour-img">
                                <a href="<?= esc_url($term_link); ?>" class="imghover">
                                    <img src="<?= $image_url; ?>" alt="<?= esc_attr($term->name); ?>" class="img-fluid">
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- /.tour-item -->
        <?php
                endif;
                $idx++;

            endforeach;
        endif;
        ?>

    </div>
</div>
<!-- /.tour-service -->
<!-- destination-section -->
<div class="space-medium">
    <div class="container-fluid">
        <div class="row">
            <!-- section-title -->
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                <div class="section-title">
                    <h2>Điểm đến nổi bật</h2>
                </div>
            </div>
            <!-- /.section-title -->
        </div>
        <div class="row">
            <?php
            //Bước 1: xây dựng câu truy vấn dữ liệu
            $tour_query = array(
                "post_type" => "tour",
                "posts_per_page" => 4,
                "orderBy"   => "desc",
                "order"    => "date",
                "no_found_rows" => false
            );

            //Bước 2: Chạy câu truy vấn
            $data = new WP_Query($tour_query);
            //Bước 3: Kiểm tra câu truy vấn có dữ liệu ko ?
            if ($data->have_posts()) :
                while ($data->have_posts()) : $data->the_post();

            ?>
                    <?php get_template_part('template-parts/content', 'tourv2'); ?>

                <?php endwhile;
                wp_reset_postdata();
                ?>


            <?php endif; ?>

        </div>
    </div>
</div>
<!-- /.destination-section -->
<!-- about-section -->
<div class="space-medium">
    <?php
    $about_title = get_field("about_title");
    $about_des   = get_field("about_des");
    $about_left_col = get_field("about_column_left");
    $about_right_col = get_field("about_column_right");

    ?>
    <div class="container">
        <!-- about-head -->
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 mb60">
                <div class="">
                    <h2><?= esc_html($about_title); ?></h2>
                </div>
            </div>
            <div class="col-xl-8 col-lg-8 offset-md-1 col-md-8 col-sm-12 col-12 mb60">
                <div class="">
                    <p class="lead"><?= esc_html($about_des); ?></p>
                </div>
            </div>
        </div>
        <!-- /.about-head -->
        <div class="row">
            <!-- feature-section -->
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                <div class="well-block">
                    <?php if (!is_null($about_left_col)): ?>
                        <!-- feature-left -->
                        <?php foreach ($about_left_col as $col): ?>
                            <div class="feature-left">
                                <div class="feature-icon"><img src="<?= esc_url($col['icon']); ?>" alt=""></div>
                                <div class="feature-content">
                                    <h4><?= esc_html($col['title']); ?></h4>
                                    <p><?= esc_html($col['meta']); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <!-- /.feature-section -->
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                <div class="well-block">
                    <?php if (!is_null($about_right_col)): ?>
                        <?php foreach ($about_right_col as $col): ?>
                            <div class="counter-block">
                                <h1 class="counter-numbers"><?= esc_html($col['count_number']); ?></h1>
                                <div class="counter-content">
                                    <h4><?= esc_html($col['title']); ?></h4>
                                    <p><?= esc_html($col['meta']); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.about-section -->
<!-- service-section -->
<div class="space-medium service-wrapper" style="background-image: url(<?= !empty($service_bg) ? esc_url($service_bg) : get_template_directory_uri() . '/assets/images/service_wrapper.jpg'; ?>);">
    <?php
    $service_title = get_field("service_title");
    $service_des = get_field("service_des");
    $service_bg  = get_field("service_bg");
    $service_list = get_field("service_items");

    ?>
    <div class="container">
        <!-- service-head -->
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 mb60">
                <div class="">
                    <h2><?= !empty($service_title) ? esc_html($service_title) : 'Our Services'; ?></h2>
                </div>
            </div>
            <div class="col-xl-8 col-lg-8 offset-md-1 col-md-8 col-sm-12 col-12 mb60">
                <div class="">
                    <p class="lead"><?= !empty($service_des) ? esc_html($service_des) : 'Suctus felis non nibh maximus consectetuis sed nisl eniullase pellentesque euismod eronon ntesque tortor molestieege.'; ?></p>
                </div>
            </div>
        </div>
        <!-- /.service-head -->
        <div class="row">
            <!-- service-block -->
            <?php if (!is_null($service_list)): ?>
                <?php foreach ($service_list as $service): ?>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 nopr">
                        <div class="service-block border-bottom border-right">
                            <div class="service-img"><img src="<?= $service["icon"]["url"]; ?>" alt=""></div>
                            <div class="service-content">
                                <h3 class="service-title"><?= $service["title"]; ?></h3>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </div>
</div>
<!-- /.service-section -->
<!-- testimonial-section -->
<div class="space-medium bg-light">
    <div class="container">
        <div class="row">
            <!-- testimonial-head -->
            <?php $slide_review__title = get_field("review_title");
            $slide_reviews = get_field("review_slider");

            ?>
            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mb60">
                <div class="testimonial-head">
                    <div class="quote-icon">
                        <img src="<?= get_template_directory_uri(); ?>/assets/images/left_quote.png" alt="">
                    </div>
                    <?php if (!empty($slide_review__title)) : ?>
                        <h2 class="mb40"><?= $slide_review__title; ?></h2>
                    <?php endif; ?>
                </div>
            </div>
            <!-- /.testimonial-head -->
            <div class="col-xl-6 col-lg-6 offset-md-1 col-md-6 col-sm-12 col-12 mb60">
                <div class="testimonial-carousel">
                    <div class="owl-carousel owl-theme testimonial-owl">
                        <!-- testimonial-item -->
                        <?php if (!is_null($slide_reviews)): ?>
                            <?php foreach ($slide_reviews as $review): ?>
                                <div class="item">
                                    <div class="testimonial-block">
                                        <div class="testimonial-content">
                                            <p class="testimonial-text"><?= $review['slide_content']; ?></p>
                                            <span class="testi-meta"><?= $review['slide_name']; ?></span>
                                            <div class="testi-arrow"></div>
                                        </div>
                                        <div class="testi-img">
                                            <img src="<?= $review['slide_image']['url']; ?>" alt="" class="rounded-circle">
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- testimonial-section -->
<!-- /.client-section -->
<div class="space-small">
    <div class="container">
        <div class="row">
            <!-- client-logo -->
            <?php $logo_partners = get_field("logo_partners"); ?>
            <?php if ($logo_partners): ?>
                <?php foreach ($logo_partners as $partner): ?>
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6 col-6">
                        <div class="client-logo">
                            <a href="#"><img src="<?= $partner['logo_image']['url']; ?>" alt="<?= $partner['logo_image']['alt']; ?>"></a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- /.client-section -->


<?php get_footer(); ?>