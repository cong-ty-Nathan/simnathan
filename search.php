<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Travelme
 */

get_header();
?>

	<div class="page-header">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-caption">
                            <h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'travelme' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.page-header-->
        <!-- blog-section -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <?php if ( have_posts() ) : ?>
                        <?php while ( have_posts() ) : the_post(); ?>
                            <?php get_template_part( 'template-parts/content', 'search' ); ?>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <div class="col-12">
                            <?php get_template_part( 'template-parts/content', 'none' ); ?>
                        </div>
                    <?php endif; ?>
                    
                    
                    <!-- pagination start -->
                    <?php custom_pagination($wp_query); ?>
                    <!-- pagination close -->
                </div>
            </div>
        </div>

<?php

get_footer();
