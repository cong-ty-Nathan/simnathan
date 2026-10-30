<?php
$tour_duration = get_field("tour_duration", get_the_ID());
$tour_hotel    = get_field("tour_hotel", get_the_ID());
$tour_meal    = get_field("tour_meal", get_the_ID());
$tour_price   = get_field("tour_price", get_the_ID());
?>

<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 nopl nopr px-3">
    <!-- destination-section -->
    <div class="destination-block">
        <div class="desti-img">
            <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
            <a href="<?php the_permalink(); ?>" class="desti-title"><?php the_title(); ?></a>
            <div class="overlay">
            </div>
            <div class="text">
                <h3 class="mb20 text-white"><?php the_title(); ?></h3>
                <ul class="angle list-none">
                    <li><?= $tour_duration; ?></li>
                    <li><?= $tour_hotel; ?></li>
                    <li><?= $tour_meal; ?></li>
                </ul>
                <p class="price"><?= $tour_price; ?></p>
                <a href="<?php the_permalink(); ?>" class="btn-link">Go for <?php the_title(); ?> <i class="fa fa-angle-right"></i></a>
            </div>
        </div>
    </div>
    <!-- /.destination-section -->
</div>



