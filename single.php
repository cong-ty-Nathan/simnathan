<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Travelme
 */

get_header();
?>

<main id="primary" class="site-main">

	<?php
	while (have_posts()) :
		the_post();
	?>
		<!-- /. header-section-->
		<!-- page-header -->
		
			<div class="post-pageheader" style="background: url(<?php echo get_the_post_thumbnail_url(); ?>) no-repeat; background-position: top center; background-size:cover;">
				<div class="container">
					<div class="row">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							<div class=" post-captions">
								<h3 class="post-title"><a href="#" class="title"><?php the_title(); ?></a></h3>
								<div class="meta">
									<span class="meta-date"><?php echo get_the_date("d F Y"); ?></span>
									<span>/</span>
									<span class="meta-admin ">By <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" class="meta-link"><?php the_author(); ?></a></span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		
		<!-- /.page-header-->
		<!-- blog-section -->
		<div class="content">
			<div class="container">
				<div class="row ">
					<div class="col-xl-8 col-lg-8 col-md-7 col-sm-12 col-12">
						<div class="post-holder">
							<?php the_content(); ?>
						</div>
						<div class="post-navigation">
							<!-- post navigation -->
							<?php
							$previous_post = get_previous_post();
							$next_post = get_next_post();

							?>
							<div class="row">
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
									<?php if (!is_null($previous_post) && is_object($previous_post)) :
									?>
										<div class="nav-previous">
											<!-- nav previous -->
											<div class="prev-link"> <a href="<?= get_permalink($previous_post->ID); ?>"><i class="fa fa-angle-left "></i></a></div>
											<h4 class="previous-next-title"><a href="<?= get_permalink($previous_post->ID); ?>" class="title"><?= $previous_post->post_title; ?></a></h4>
										</div>
									<?php endif; ?>
									<!-- /. nav previous -->
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
									<?php if (!is_null($next_post) && is_object($next_post)) :

									?>
										<div class="nav-next text-right">
											<!-- nav next -->
											<div class="next-link"> <a href="<?= get_permalink($next_post->ID); ?>"><i class="fa fa-angle-right "></i></a></div>
											<h4 class="previous-next-title"><a href="<?= get_permalink($next_post->ID); ?>" class="title"><?= $next_post->post_title; ?></a></h4>
										</div>
									<?php endif; ?>
									<!-- /.nav previous -->
								</div>
							</div>
						</div>

						<!-- /. post navigation -->
						<?php if (!is_product()) : ?>
							<div class="related-post-block">
								<div class="row">
									<div class="col-xl-12 col-lg-12 col-sm-12 col-md-12 col-12">
										<h3 class="related-title mb30">Recommended Posts</h3>
									</div>
								</div>
								<div class="row">
									<?php
									$recomment_posts = get_posts(array(
										'numberposts' => 2,
										'post__not_in' => array(get_the_ID()),
										'orderby' => 'rand',
									));

									foreach ($recomment_posts as $post) :

									?>
										<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
											<div class="related-post">
												<!-- related post -->
												<div class="related-img">
													<a href="<?= get_permalink($post->ID); ?>" class="imghover"><img src="<?= get_the_post_thumbnail_url($post->ID); ?>" alt="" class="img-responsive" style="object-fit: cover!important;"></a>
												</div>
												<div class="related-post-content">
													<h4 class="related-post-title"><a href="<?= get_permalink($post->ID); ?>" class="title"><?= $post->post_title; ?></a></h4>
												</div>
											</div>
											<!-- /.related post -->
										</div>
									<?php endforeach; ?>

								</div>
							</div>
						<?php endif; ?>
						<!-- /.related post block -->
						<!-- /.post author -->
					</div>

					<div class="col-xl-4 col-lg-4 col-md-5 col-sm-12 col-12">
						<!-- widget-search-start -->
						<!-- widget-search-close -->
						<!-- widget-categories-start -->
						<div class=" widget widget-categories">
							<h2 class="widget-title">Chuyên Mục</h2>
							<ul class="list-none">
								<?php
								$categories = get_categories();
								foreach ($categories as $category) :
								?>

									<li><a href="<?= get_category_link($category->term_id); ?>"><?= $category->name; ?></a></li>
								<?php endforeach; ?>
							</ul>
						</div>
						<!-- widget-categories-close -->
						<!-- widget-recent-post-start -->
						<div class=" widget widget-recent-post">
							<h2 class="widget-title">Bài viết gần đây</h2>
							<ul class="list-none">
								<?php
								$recent_posts = get_posts(
									array(
										'numberposts' => 3,
										'post__not_in' => array(get_the_ID()),
										'orderby' => 'ID',
										'order' => 'DESC',
									)
								);

								foreach ($recent_posts as $post) :

								?>
									<li>
										<div class="recent-post">
											<div class="recent-pic">
												<a href="<?= get_permalink($post->ID); ?>" class="imghover">
													<?php if (has_post_thumbnail($post->ID)) : ?>
														<img src="<?= get_the_post_thumbnail_url($post->ID); ?>" alt="" class="img-fluid" style="width:60px; height:60px; object-fit:cover;">
													<?php endif; ?>
												</a>
											</div>
											<div class="recent-content">
												<h5 class="recent-title"><a href="<?= esc_url(get_permalink($post->ID)); ?>" class="title"><?= esc_html(wp_trim_words(get_the_title($post->ID), 6, '')); ?>...</a></h5>
												<div class="meta">
													<span class="meta-date"><?= get_the_date("d F Y", $post->ID); ?></span>
												</div>
											</div>
										</div>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
						<!-- widget-recent-post-close-->
						<!-- widget-archives-start -->
						
							<div class=" widget widget-archives">
								<h2 class="widget-title">Archives</h2>
								<ul class="list-none">
									<?php
									wp_get_archives(
										array(
											'type' => 'monthly',
											'limit' => 12,
											'show_post_count' => false,
										)
									);
									?>
								</ul>
							</div>
							<!-- widget-archives-close -->
							
							<!-- widget-Tag close -->
						
					</div>
				</div>
			</div>
		</div>

	<?php

	endwhile; // End of the loop.
	?>

</main><!-- #main -->

<?php

get_footer();
