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
                        <section class="tour-details-section mb60">
                            <h3 class="mb30">KHÁM PHÁ HANG VOI &amp; THUNG LŨNG HA MA ĐA</h3>
                            <p><strong>Giá tour:</strong> 1.950.000 VNĐ</p>
                            <h4>II. ELEPHANT CAVE &amp; MA DA VALLEY JUNGLE TREK</h4>
                            <ul>
                                <li>Đi bộ băng rừng: 09 km <span lang="en">/ Trekking: 09 km</span></li>
                                <li>Bơi 600 m tại Hang Trạ Ang (không bắt buộc) <span lang="en">/ Swimming: 600 m at Tra Ang Cave (optional)</span></li>
                                <li>Mức độ mạo hiểm: Trung bình <span lang="en">/ Fitness level: Moderate</span></li>
                            </ul>
                            <p>Chương trình tour phù hợp cho những du khách chưa có nhiều kinh nghiệm leo núi chuyên nghiệp nhưng vẫn mong muốn trải nghiệm kỹ năng đi rừng, leo núi và hang động. Chương trình bắt đầu từ bìa rừng, dọc nhánh đường Hồ Chí Minh Tây, nằm trong khu vực Vườn Quốc gia Phong Nha - Kẻ Bàng; du khách khám phá Hang Voi, Thung lũng Ha Ma Đa (một trong những thung lũng đẹp nhất tại Phong Nha), và điểm cuối cùng là Hang Trạ Ang. Du khách còn được thưởng thức BBQ phong cách rừng xanh ngay bên bờ suối.</p>
                            <p lang="en">This trek is suitable for visitors without much professional climbing experience who still want to experience jungle trekking, mountain climbing, and caves. Starting from the edge of the jungle along the western branch of the Ho Chi Minh Trail in Phong Nha - Ke Bang National Park, the trek explores Elephant Cave and Ha Ma Da Valley (one of the most beautiful valleys in Phong Nha), and ends at Tra Ang Cave. Visitors can also enjoy a jungle-style BBQ by the stream.</p>

                            <h3 class="mb30">LỊCH TRÌNH: 01 NGÀY <span lang="en">/ ITINERARY: 01 DAY</span></h3>
                            <p><strong>Jungle Boss HQ - Elephant Cave - Ma Da Valley - Tra Ang Valley - Phong Nha</strong></p>
                            <ul class="list-none">
                                <li><strong>08:00</strong> Hướng dẫn viên và lái xe đón khách tại các khách sạn ở Phong Nha. <span lang="en">/ Guide and driver pick up guests at homestays in Phong Nha.</span></li>
                                <li><strong>08:45</strong> Gặp đoàn, nghe phổ biến chương trình tour và di chuyển tới điểm bắt đầu để khám phá 500 - 700 m Hang Voi. <span lang="en">/ Meet the group for a tour briefing, then depart for the starting point to explore 500 - 700 m of Elephant Cave.</span></li>
                                <li><strong>10:30</strong> Sau khi tham quan Hang Voi, bắt đầu hành trình khám phá Thung lũng Ha Ma Đa. <span lang="en">/ After visiting Elephant Cave, start the journey to explore Ha Ma Da Valley.</span></li>
                                <li><strong>11:45</strong> Bơi lội và thư giãn tại Hồ Ma Đa. <span lang="en">/ Swim and relax at Ma Da Crystal Lake.</span></li>
                                <li><strong>12:45</strong> Thưởng thức bữa trưa BBQ bên bờ suối. <span lang="en">/ Enjoy a BBQ lunch by the stream.</span></li>
                                <li><strong>14:00</strong> Di chuyển tới Hang Trạ Ang. <span lang="en">/ Trek to Tra Ang Cave.</span></li>
                                <li><strong>15:45</strong> Bơi và khám phá 600 m Hang Trạ Ang. <span lang="en">/ Swim and explore 600 m of Tra Ang Cave.</span></li>
                                <li><strong>16:30</strong> Kết thúc khám phá Hang Trạ Ang và đi bộ đến đường 20 Quyết Thắng. <span lang="en">/ Finish exploring Tra Ang Cave and hike to Road 20 Quyet Thang.</span></li>
                                <li><strong>17:00</strong> Đến đường 20 Quyết Thắng và thưởng thức đồ uống lạnh. <span lang="en">/ Arrive at Road 20 Quyet Thang and enjoy cold drinks.</span></li>
                                <li><strong>17:30</strong> Xe đón khách trở về Phong Nha. Kết thúc tour. <span lang="en">/ Transfer back to Phong Nha. End of tour.</span></li>
                            </ul>

                            <h3 class="mb30">NHỮNG ĐIỀU CẦN CHÚ Ý KHI THAM GIA TOUR <span lang="en">/ NOTICES WHEN JOINING THE TOUR</span></h3>
                            <ol>
                                <li>Độ tuổi tối thiểu: từ 9 tuổi trở lên. <span lang="en">/ Minimum age: 9 years old.</span></li>
                                <li>Giá tour áp dụng cho đoàn ghép từ 2 khách. <span lang="en">/ Tour price applies to groups of 2 guests or more.</span></li>
                                <li>Giá tour bao gồm <span lang="en">/ Tour price includes:</span>
                                    <ul>
                                        <li>Hướng dẫn viên và đội ngũ khuân vác <span lang="en">/ Tour guide and porter team</span></li>
                                        <li>Phương tiện di chuyển tại Phong Nha <span lang="en">/ Transportation in Phong Nha</span></li>
                                        <li>01 bữa trưa và nước uống <span lang="en">/ One lunch and drinking water</span></li>
                                        <li>Phí tham quan Vườn Quốc gia <span lang="en">/ National Park entrance fees</span></li>
                                        <li>Bảo hiểm 50.000.000 VNĐ/người <span lang="en">/ Insurance coverage of 50,000,000 VND per person</span></li>
                                    </ul>
                                </li>
                                <li>Tour khởi hành hằng ngày, từ 02 khách. <span lang="en">/ Tour departs daily, with a minimum of 2 guests.</span></li>
                                <li>Đồ dùng cần mang theo <span lang="en">/ What to bring:</span>
                                    <ul>
                                        <li>Quần áo dài tay, tất dài <span lang="en">/ Long-sleeved clothes and long socks</span></li>
                                        <li>Giày đi bộ, leo núi tốt <span lang="en">/ Good hiking and climbing shoes</span></li>
                                        <li>Đồ bơi <span lang="en">/ Swimwear</span></li>
                                        <li>Kính mát, mũ <span lang="en">/ Sunglasses and a hat</span></li>
                                        <li>Thuốc chống côn trùng <span lang="en">/ Insect repellent</span></li>
                                        <li>Máy ảnh <span lang="en">/ Camera</span></li>
                                    </ul>
                                </li>
                            </ol>
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