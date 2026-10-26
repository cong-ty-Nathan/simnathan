<?php get_header(); ?>

<?php if (have_posts()): ?>
    <?php while (have_posts()) : the_post(); ?>
        <?php
        $single_tour__price = get_field("tour_price", get_the_ID());
        $single_tour__hightlight = get_field("tour_highlight", get_the_ID());
        $single_tour__view_title = get_field("tour_views_title", get_the_ID());
        $single_tour__gallery    = get_field("tour_gallery", get_the_ID());
        $single_tour__journey    = get_field("tour_journey", get_the_ID());
        $single_tour__included   = get_field("tour_included", get_the_ID());
        $single_tour__video      = get_field("tour_video", get_the_ID());
        $single_tour__map        = get_field("tour_map", get_the_ID());
        $single_tour__consultant = get_field("tour_consultant", get_the_ID());
        $single_tour__duration   = get_field("tour_duration", get_the_ID());
        $single_tour__departure_dates = get_field("department_date", get_the_ID());
        // Lấy tọa độ thời tiết
        $lat = get_field('tour_lat', get_the_ID());
        $lng = get_field('tour_lng', get_the_ID());
        // Chuyển đổi sang số và kiểm tra tính hợp lệ
        $lat = !empty($lat) ? floatval($lat) : '';
        $lng = !empty($lng) ? floatval($lng) : '';
        ?>

        <!-- page-header -->
        <div class="tour-pageheader" <?php if (has_post_thumbnail()) : ?> style="background-image: url('<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full')); ?>');" <?php endif; ?>>
            <div class="container">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="tour-caption">
                            <h1 class="text-white tour-title"><?php the_title(); ?></h1>
                            <p class="tour-caption-text text-white"><strong class="tour-rate">$<?= $single_tour__price; ?></strong>( <?= $single_tour__duration; ?> )</p>
                            <a href="#booking_tour" class="btn btn-primary mb10">Đặt tour</a>
                            <a href="#contact-map" class="btn btn-white mb10">Xem bản đồ</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 col-lg-8 col-md-7 col-sm-12 col-12">
                        <div class="highlights-section mb60">
                            <h3>Nổi bật</h3>
                            <?php if (!empty($single_tour__hightlight)) : ?>
                                <?= $single_tour__hightlight; ?>
                            <?php endif; ?>
                            <?php if (!empty($single_tour__view_title)) : ?>
                                <h4 class="mb30"><?= $single_tour__view_title; ?></h4>
                            <?php endif; ?>
                            <div class="slide-thumb-gallery">
                                <div class="owl-carousel" data-slider-id="1">
                                    <?php if (!is_null($single_tour__gallery)) : ?>
                                        <?php foreach ($single_tour__gallery as $item) : ?>
                                            <div><img src="<?= $item["url"]; ?>" alt="" class="img-fluid"></div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>

                                </div>
                                <div class="owl-thumbs" data-slider-id="1">
                                    <?php if (!is_null($single_tour__gallery)) :
                                    ?>
                                        <?php foreach ($single_tour__gallery as $item) : ?>
                                            <button class="owl-thumb-item"><img src="<?= $item["url"]; ?>" alt="" class="img-fluid" style="width:165px!important;height:100px!important;object-fit:cover;"></button>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="journey-section mb60">
                            <h3 class="mb30">Hành trình chi tiết</h3>
                            <?php if (!is_null($single_tour__journey)) : ?>
                                <?php foreach ($single_tour__journey as $journey) : ?>
                                    <?= $journey["journey_content"]; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>

                        </div>
                        <section class="tour-packing-section mb60" aria-labelledby="tour-packing-title">
                            <div class="tour-packing-heading">
                                <span class="fa fa-suitcase" aria-hidden="true"></span>
                                <div>
                                    <h3 id="tour-packing-title">Đồ dùng mang theo</h3>
                                    <p lang="en">What to bring</p>
                                </div>
                            </div>
                            <ul class="tour-packing-list">
                                <li>
                                    <span class="fa fa-shirtsinbulk" aria-hidden="true"></span>
                                    <span>Quần áo dài tay<small lang="en">Long-sleeved clothes</small></span>
                                </li>
                                <li>
                                    <span class="fa fa-tint" aria-hidden="true"></span>
                                    <span>Đồ bơi<small lang="en">Swimwear</small></span>
                                </li>
                                <li>
                                    <span class="fa fa-sun-o" aria-hidden="true"></span>
                                    <span>Kính mát, mũ<small lang="en">Hat, sunglasses</small></span>
                                </li>
                                <li>
                                    <span class="fa fa-bug" aria-hidden="true"></span>
                                    <span>Thuốc chống côn trùng<small lang="en">Insect repellent</small></span>
                                </li>
                                <li>
                                    <span class="fa fa-shield" aria-hidden="true"></span>
                                    <span>Kem chống nắng<small lang="en">Sunscreen</small></span>
                                </li>
                                <li>
                                    <span class="fa fa-camera" aria-hidden="true"></span>
                                    <span>Máy ảnh<small lang="en">Camera</small></span>
                                </li>
                            </ul>
                        </section>
                        <?php
                        $table_prices = get_field('table_price', get_the_ID());
                        // Lọc dữ liệu và reset index an toàn
                        $table_head = $table_prices[0];
                        $table_heading__filtered = array_filter($table_head, function ($value) {
                            return !empty($value) && $value !== "";
                        });
                        //xóa mảng đầu tiên trong table_prices để tránh hiển thị tiêu đề trong phần thân bảng
                        // $table_body = array_shift($table_prices);
                        array_shift($table_prices); // Xóa phần tử đầu tiên (tiêu đề) khỏi mảng
                        ?>
                        <div class="table-responsive">
                            <div style="text-align: right; color: #cc0000; font-weight: bold; font-size: 14px; margin-bottom: 5px;">
                                BẢNG GIÁ TOUR (VNĐ)
                            </div>
                            <table class="table table-bordered text-center" style="border: 1px solid #4a90e2; vertical-align: middle;">
                                <thead style="background-color: #5c93d8; color: #ffffff;">
                                    <tr>
                                        <?php foreach ($table_heading__filtered as $key => $value) : ?>
                                            <th style="width: 40%; vertical-align: middle; border: 1px solid #ffffff;"><?= $value; ?></th>
                                        <?php endforeach; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($table_prices as $key => $row) :
                                        $filtered_row = array_filter($row, function ($value) {
                                            return !empty($value) && $value !== "";
                                        });
                                    ?>
                                        <tr style="background-color: #ffb703; color: #000000; font-weight: bold;">
                                            <?php foreach ($filtered_row as $key => $value) : ?>
                                                <td style="text-align: left; vertical-align: middle; border: 1px solid #ffffff; padding-left: 15px;"><?= $value; ?></td>
                                            <?php endforeach; ?>
                                        </tr>
                                    <?php endforeach;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="included-section mb60">
                            <h3 class="mb30">Dịch vụ bao gồm</h3>
                            <div class="row">
                                <?php if (!empty($single_tour__included)) : ?>
                                    <?= $single_tour__included; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="reviews-section mb60">
                            <h3 class="mb40">Đánh giá của khách hàng</h3>
                            <?php
                            $review_comments = get_comments(
                                array(
                                    'post_id' => get_the_ID(),
                                    'status'  => 'approve',
                                    'order'   => 'ASC'
                                )
                            );

                            if (!is_null($review_comments)) :
                                foreach ($review_comments as $comment):
                                    $comment_rating = get_comment_meta($comment->comment_ID, 'rating', true);

                            ?>
                                    <div id="comment-<?php echo $comment->comment_ID; ?>" class="<?= $comment->comment_parent ? 'childern' : 'review-block'; ?>">
                                        <div class="review-img"><?= get_avatar($comment, 80); ?></div>
                                        <div class="review-content">
                                            <h5 class="title-bold d-inline"><?= $comment->comment_author; ?></h5>
                                            <?php if ($comment_rating > 1) : ?>
                                                <div class="star-rating">
                                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                                        <span><i class="fa <?= $i <= $comment_rating ? 'fa-star' : 'fa-star-o'; ?>"></i></span>
                                                    <?php endfor; ?>

                                                </div>
                                            <?php endif; ?>
                                            <p><?= $comment->comment_content; ?></p>
                                            <?php if (!$comment->comment_parent) :  ?>
                                                <div class="">
                                                    <a href="<?php echo esc_url(get_permalink()) ?>?replytocom=<?php echo $comment->comment_ID; ?>#respond" class="btn-link mb30">Reply <i class="fa fa-angle-right"></i></a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                <?php endforeach; ?>

                            <?php endif; ?>

                            <div class="leave-comments mt40">
                                <h4 class="leave-comments-title">Để lại đánh giá</h4>
                                <form id="respond" class="review-form" action="<?php echo esc_url(site_url('/wp-comments-post.php')); ?>" method="post">

                                    <div class="form-group">
                                        <label for="review-full-name">Họ và tên</label>
                                        <input type="text" id="review-full-name" name="author" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="review-email">Email</label>
                                        <input type="email" id="review-email" name="email" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="review-star">Đánh giá</label>
                                        <select id="review-star" name="rating" class="form-control" required>
                                            <option value="">Chọn mức độ</option>
                                            <option value="5">5 stars</option>
                                            <option value="4">4 stars</option>
                                            <option value="3">3 stars</option>
                                            <option value="2">2 stars</option>
                                            <option value="1">1 star</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="review-comment">Comment</label>
                                        <textarea id="review-comment" name="comment" class="form-control" rows="5" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="submit-form">Submit</button>
                                    <?php comment_id_fields(); ?>
                                    <?php do_action('comment_form', get_the_ID()); ?>
                                </form>
                            </div>
                            <?php if (isset($single_tour__video) && $single_tour__video !== "") : ?>
                                <div class="video-section">
                                    <h3 class="mb30">Video</h3>
                                    <div class="video-block">
                                        <div class="video-img">
                                            <img src="images/video_img.jpg" alt="">
                                            <a href="#" class="video-btn">
                                                <img src="images/play_btn.png" alt="">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-5 col-sm-12 col-12">
                        <!-- WIDGET THỜI TIẾT TẠI ĐIỂM ĐẾN -->
                        <?php if (isset($lat) && isset($lng)) :
                            $weather = get_tour_weather($lat, $lng);

                            if ($weather && isset($weather['daily'])) :
                        ?>
                                <div class="widget-weather mb-4" style="background: #ffffff; border: 1px solid #e1e8ed; border-radius: 8px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                                    <h4 style="font-size: 18px; font-weight: bold; margin-bottom: 15px; color: #2c3e50; border-bottom: 2px solid #f0f2f5; padding-bottom: 10px;">
                                        <i class="fa fa-cloud-sun" style="color: #f39c12; margin-right: 8px;"></i> Thời tiết điểm đến
                                    </h4>
                                    <div class="weather-sidebar-list" style="display: flex; flex-direction: column; gap: 10px; max-height: 320px; overflow-y: auto; padding-right: 4px;">
                                        <?php
                                        for ($i = 0; $i < count($weather['daily']['time']); $i++) {
                                            $date     = $weather['daily']['time'][$i];
                                            $max_temp = $weather['daily']['temperature_2m_max'][$i];
                                            $min_temp = $weather['daily']['temperature_2m_min'][$i];
                                            $code     = $weather['daily']['weathercode'][$i];
                                            $info     = get_weather_info($code);

                                            // Highlight ngày đầu tiên (Hôm nay)
                                            $is_today = ($i === 0);
                                            $item_bg = $is_today ? '#f0f7ff' : '#fcfcfc';
                                            $item_border = $is_today ? '#bce8f1' : '#eee';
                                        ?>
                                            <div class="weather-item-row" style="display: flex; align-items: center; justify-content: space-between; background: <?= $item_bg; ?>; border: 1px solid <?= $item_border; ?>; padding: 8px 12px; border-radius: 6px;">
                                                <div style="display: flex; align-items: center; gap: 10px;">
                                                    <span style="font-size: 22px;"><?= $info['icon']; ?></span>
                                                    <div>
                                                        <strong style="display: block; font-size: 13px; color: #333;"><?= $is_today ? 'Hôm nay (' . date('d/m', strtotime($date)) . ')' : date('d/m/Y', strtotime($date)); ?></strong>
                                                        <span style="font-size: 11px; color: #666;"><?= $info['text']; ?></span>
                                                    </div>
                                                </div>
                                                <div style="text-align: right; font-size: 12px;">
                                                    <span style="color: #d9534f; font-weight: bold;"><?= $max_temp; ?>°C</span>
                                                    <span style="color: #888; margin-left: 4px;">/ <?= $min_temp; ?>°C</span>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                        <?php endif;
                        endif; ?>
                        <div class="widget-primary support-list">
                            <div class="widget-primary-title">
                                <h3>Tại sao nên đặt tour với chúng tôi?</h3>
                            </div>
                            <?php if (!empty($single_tour__consultant)) : ?>
                                <?= $single_tour__consultant ?>
                            <?php endif; ?>
                        </div>
                        <!-- enguiry-form -->
                        <div class="widget-form" id="booking_tour">
                            <h3 class="text-white mb30"> Đặt tour của bạn</h3>
                            <!-- HÀM GỌI CONTACT FORM 7 -->
                            <?php echo do_shortcode('[contact-form-7 id="4ef78d6" title="Booking Tour"]'); ?>
                        </div>
                        <!-- /.enguiry-form -->
                        <div id="contact-map" class="widget-map">
                            <?= $single_tour__map; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
<?php endif; ?>

<div class="bg-light similar-package">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="section-title">
                    <h2>Chuyến đi tương tự</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <?php
            $current_tour_id = get_the_ID();
            $taxonomy_name   = 'tour-type';
            $terms  = get_the_terms($current_tour_id, $taxonomy_name);

            if (!is_null($terms) && !is_wp_error($terms)) {
                $term_ids = wp_list_pluck($terms, 'term_id');
                $args = array(
                    'post_type' => 'tour',
                    'posts_per_page' => 3,
                    'post__not_in' => array($current_tour_id),
                    'orderBy'   => 'date',
                    'order'     => 'DESC',
                    'tax_query' => array(
                        array(
                            'taxonomy' => $taxonomy_name,
                            'field'    => 'term_id',
                            'terms'    => $term_ids,
                            'operator' => 'IN'
                        ),
                    ),
                );
                $tour_query = new WP_Query($args);
                if ($tour_query->have_posts()) {
                    while ($tour_query->have_posts()) {
                        $tour_query->the_post();
                        get_template_part('template-parts/content', get_post_type());
                    }
                    wp_reset_postdata();
                }
            }
            ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>