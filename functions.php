<?php

/**
 * Travelme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Travelme
 */

if (! defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.2');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function travelme_setup()
{
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Travelme, use a find and replace
		* to change 'travelme' to the name of your theme in all the template files.
		*/
	load_theme_textdomain('travelme', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support('title-tag');

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support('post-thumbnails');

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__('Primary', 'travelme'),
		)
	);

	register_nav_menus(
		array(
			'quick-links' => esc_html__('Quick Links', 'travelme'),
		)
	);


	register_nav_menus(
		array(
			'tour-packages' => esc_html__('Tour Packages', 'travelme'),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'travelme_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
	require_once get_template_directory() . '/inc/acf-func.php';
}
add_action('after_setup_theme', 'travelme_setup');

/**
 * Remove the rewrite base from public taxonomy term links.
 */
function travelme_remove_taxonomy_base_from_term_link($url, $term, $taxonomy)
{
	if (is_object($term) && isset($term->taxonomy)) {
		$taxonomy = $term->taxonomy;
	}

	$taxonomy_object = get_taxonomy($taxonomy);

	if (!$taxonomy_object || !$taxonomy_object->public || !$taxonomy_object->publicly_queryable || empty($taxonomy_object->rewrite)) {
		return $url;
	}

	$rewrite_slug = trim($taxonomy_object->rewrite['slug'] ?? $taxonomy, '/');
	if ($rewrite_slug === '') {
		return $url;
	}

	global $wp_rewrite;
	$front = !empty($taxonomy_object->rewrite['with_front']) ? $wp_rewrite->front : '';
	$taxonomy_base = trailingslashit(home_url($front . $rewrite_slug));
	if (strpos($url, $taxonomy_base) !== 0) {
		return $url;
	}

	return home_url($front . ltrim(substr($url, strlen($taxonomy_base)), '/'));
}
add_filter('term_link', 'travelme_remove_taxonomy_base_from_term_link', 10, 3);

/**
 * Find a public taxonomy term using its base-free URL path.
 */
function travelme_find_taxonomy_term_by_path($path)
{
	$path = trim(rawurldecode($path), '/');
	if ($path === '') {
		return null;
	}

	$segments = explode('/', $path);
	$last_segment = end($segments);
	$matches = array();

	foreach (get_taxonomies(array('public' => true), 'objects') as $taxonomy_name => $taxonomy_object) {
		if (!$taxonomy_object->publicly_queryable || empty($taxonomy_object->rewrite)) {
			continue;
		}

		if (!$taxonomy_object->hierarchical && count($segments) !== 1) {
			continue;
		}

		$terms = get_terms(array(
			'taxonomy'   => $taxonomy_name,
			'slug'       => $last_segment,
			'hide_empty' => false,
		));
		if (is_wp_error($terms) || empty($terms)) {
			continue;
		}

		foreach ($terms as $term) {
			if ($taxonomy_object->hierarchical) {
				$ancestor_ids = array_reverse(get_ancestors($term->term_id, $taxonomy_name, 'taxonomy'));
				$term_path = array();

				foreach ($ancestor_ids as $ancestor_id) {
					$ancestor = get_term($ancestor_id, $taxonomy_name);
					if (!$ancestor || is_wp_error($ancestor)) {
						continue 2;
					}
					$term_path[] = $ancestor->slug;
				}

				$term_path[] = $term->slug;
				if (implode('/', $term_path) !== $path) {
					continue;
				}
			}

			$matches[] = array(
				'taxonomy' => $taxonomy_object,
				'term'     => $term,
			);
		}
	}

	return count($matches) === 1 ? $matches[0] : null;
}

/**
 * Register a fallback route and resolve it only when it matches one taxonomy term.
 */
function travelme_register_short_taxonomy_routes()
{
	add_rewrite_tag('%travelme_taxonomy_path%', '(.+)');
	add_rewrite_rule('^(.+?)/?$', 'index.php?travelme_taxonomy_path=$matches[1]', 'bottom');

	if (get_option('travelme_short_taxonomy_rewrite_version') !== '1') {
		flush_rewrite_rules(false);
		update_option('travelme_short_taxonomy_rewrite_version', '1');
	}
}
add_action('init', 'travelme_register_short_taxonomy_routes', 20);

function travelme_add_short_taxonomy_query_var($query_vars)
{
	$query_vars[] = 'travelme_taxonomy_path';
	return $query_vars;
}
add_filter('query_vars', 'travelme_add_short_taxonomy_query_var');

function travelme_resolve_short_taxonomy_request($query_vars)
{
	$path = $query_vars['travelme_taxonomy_path'] ?? $query_vars['pagename'] ?? $query_vars['name'] ?? '';
	if (!is_string($path) || $path === '') {
		return $query_vars;
	}

	$post_types = get_post_types(array('public' => true));
	if (get_page_by_path($path, OBJECT, $post_types)) {
		unset($query_vars['travelme_taxonomy_path']);
		if (!empty($query_vars['pagename']) || !empty($query_vars['name'])) {
			return $query_vars;
		}
		$query_vars['pagename'] = $path;
		return $query_vars;
	}

	$match = travelme_find_taxonomy_term_by_path($path);
	unset($query_vars['travelme_taxonomy_path']);

	if (!$match) {
		if (empty($query_vars['pagename']) && empty($query_vars['name'])) {
			$query_vars['pagename'] = $path;
		}
		return $query_vars;
	}

	unset($query_vars['pagename'], $query_vars['name'], $query_vars['attachment'], $query_vars['attachment_id'], $query_vars['error']);

	if ($match['taxonomy']->query_var) {
		unset($query_vars[$match['taxonomy']->query_var]);
	}

	$query_vars['tax_query'] = array(
		array(
			'taxonomy'         => $match['taxonomy']->name,
			'field'            => 'term_id',
			'terms'            => array($match['term']->term_id),
			'include_children' => false,
		),
	);

	return $query_vars;
}
add_filter('request', 'travelme_resolve_short_taxonomy_request');
/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function travelme_content_width()
{
	$GLOBALS['content_width'] = apply_filters('travelme_content_width', 640);
}
add_action('after_setup_theme', 'travelme_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function travelme_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__('Sidebar', 'travelme'),
			'id'            => 'sidebar-1',
			'description'   => esc_html__('Add widgets here.', 'travelme'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__('Greeting', 'travelme'),
			'id'            => 'greeting',
			'description'   => esc_html__('Add widgets here.', 'travelme'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'travelme_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function travelme_scripts()
{
	wp_enqueue_style('travelme-style', get_stylesheet_uri(), array(), _S_VERSION);
	wp_style_add_data('travelme-style', 'rtl', 'replace');

	// Theme CSS (from assets)
	wp_enqueue_style('travelme-bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), _S_VERSION);
	wp_enqueue_style('travelme-owl', get_template_directory_uri() . '/assets/css/owl.carousel.css', array(), _S_VERSION);
	wp_enqueue_style('travelme-owl-theme', get_template_directory_uri() . '/assets/css/owl.theme.default.css', array('travelme-owl'), _S_VERSION);
	wp_enqueue_style('travelme-jquery-ui', get_template_directory_uri() . '/assets/css/jquery-ui.css', array(), _S_VERSION);
	wp_enqueue_style('travelme-fontawesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css', array(), _S_VERSION);
	wp_enqueue_style('travelme-main', get_template_directory_uri() . '/assets/css/style.css', array('travelme-style'), _S_VERSION);
	wp_enqueue_style('travelme-custom-css', get_template_directory_uri() . '/style.css', array(), _S_VERSION);

	// Theme JS (load in footer)
	// Prefer WP's built-in jQuery; do not register a separate jquery.min.js unless necessary.
	wp_enqueue_script('travelme-jquery', get_template_directory_uri() . '/assets/js/jquery.min.js', array(), _S_VERSION, true);
	wp_enqueue_script('travelme-bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('travelme-jquery'), _S_VERSION, true);
	wp_enqueue_script('travelme-menumaker', get_template_directory_uri() . '/assets/js/menumaker.js', array('travelme-jquery',), _S_VERSION, true);
	wp_enqueue_script('travelme-sticky', get_template_directory_uri() . '/assets/js/jquery.sticky.js', array('travelme-jquery'), _S_VERSION, true);
	wp_enqueue_script('travelme-sticky-header', get_template_directory_uri() . '/assets/js/sticky-header.js', array('travelme-jquery'), _S_VERSION, true);
	wp_enqueue_script('travelme-owl', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array('travelme-jquery'), _S_VERSION, true);
	wp_enqueue_script('travelme-multiple-carousel', get_template_directory_uri() . '/assets/js/multiple-carousel.js', array('travelme-jquery', 'travelme-owl'), _S_VERSION, true);
	wp_enqueue_script('travelme-jquery-ui', get_template_directory_uri() . '/assets/js/jquery-ui.js', array('travelme-jquery'), _S_VERSION, true);
	wp_enqueue_script('travelme-date', get_template_directory_uri() . '/assets/js/date.js', array('travelme-jquery'), _S_VERSION, true);
	wp_enqueue_script('travelme-return-to-top', get_template_directory_uri() . '/assets/js/return-to-top.js', array('travelme-jquery'), _S_VERSION, true);
	wp_enqueue_script('travelme-popup-gallery', get_template_directory_uri() . '/assets/js/popup-gallery.js', array('travelme-jquery', 'travelme-magnific'), _S_VERSION, true);
	wp_enqueue_script('travelme-magnific', get_template_directory_uri() . '/assets/js/jquery.magnific-popup.min.js', array('travelme-jquery'), _S_VERSION, true);
	wp_enqueue_script('travelme-owl-thumb', get_template_directory_uri() . '/assets/js/owl.carousel2.thumbs.min.js', array('travelme-jquery'), _S_VERSION, true);
	wp_enqueue_script('travelme-thumb', get_template_directory_uri() . '/assets/js/thumb.js', array('travelme-jquery', 'travelme-owl-thumb'), _S_VERSION, true);

	// Navigation script (kept from starter)
	wp_enqueue_script('travelme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);

	if (is_front_page() || is_page_template('custom-template/eSim-country.php')) {
		wp_enqueue_style('travelme-esim-country', get_template_directory_uri() . '/assets/css/esim-country.css', array('travelme-style'), _S_VERSION);
		wp_enqueue_script('travelme-esim-country', get_template_directory_uri() . '/assets/js/esim-country.js', array(), _S_VERSION, true);
	}

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}

	wp_enqueue_script('travelme-tour-booking', get_template_directory_uri() . '/js/tour-booking.js', array('jquery'), _S_VERSION, true);
	wp_localize_script(
		'travelme-tour-booking',
		'tour_booking',
		[
			'ajax_url' => admin_url('admin-ajax.php')
		]
	);


	// wp_enqueue_script('travelme-map-js', get_template_directory_uri() . '/js/map.js', array(), _S_VERSION, true);
	// wp_enqueue_script('travelme-google-map', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBZib4Lvp0g1L8eskVBFJ0SEbnENB6cJ-g&amp;callback=initMap', array('travelme-map-js'), _S_VERSION, true);
}
add_action('wp_enqueue_scripts', 'travelme_scripts');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}


add_action('acf/init', function () {
	if (function_exists('acf_add_options_page')) {

		acf_add_options_page(array(
			'page_title'    => 'Theme General Settings',
			'menu_title'    => 'Theme Settings',
			'menu_slug'     => 'theme-general-settings',
			'capability'    => 'edit_posts',
			'redirect'      => false
		));
	}
});
//Bước 4: Lưu field rating xuống database
function save_comment_rating($comment_id)
{
	if (isset($_POST['rating'])) {
		$rating = intval(wp_unslash($_POST['rating']));
		if ($rating >= 1 && $rating <= 5) {
			update_comment_meta($comment_id, 'rating', $rating);
		}
	}
}
add_action('comment_post', 'save_comment_rating');

//Thêm cột mới vào bảng quản lý bình luận
add_filter('manage_edit-comments_columns', 'add_comment_meta_column');
function add_comment_meta_column($columns)
{
	$columns["rating_column"] = 'Rating Comment';
	return $columns;
}

//Hiển thị dữ liệu comment meta (rating) ra cột đó

add_action('manage_comments_custom_column', 'show_comment_rating_column', 10, 2);

function show_comment_rating_column($column_name, $comment_id)
{
	if ($column_name === 'rating_column') {
		$comment_rating = get_comment_meta($comment_id, 'rating', true);
		echo !empty($comment_rating) ? esc_html($comment_rating) . " Stars" : "-";
	}
}

function prevent_html_in_comments( $commentdata ) {
    $commentdata['comment_content'] = esc_html( $commentdata['comment_content'] );
    return $commentdata;
}
add_filter( 'preprocess_comment', 'prevent_html_in_comments', 10, 1 );


function custom_tour_archive_query($query)
{
    if (!is_admin() && $query->is_main_query() && is_post_type_archive('tour')) {

        // Search tour titles/content only when a keyword was provided.
        if (isset($_GET['keyword']) && is_string($_GET['keyword'])) {
            $keyword = trim(sanitize_text_field(wp_unslash($_GET['keyword'])));
            if ($keyword !== '') {
                $query->set('s', $keyword);
            }
        }

        // Add a date condition only when a non-empty, valid date was provided.
        if (isset($_GET['datepicker']) && is_string($_GET['datepicker'])) {
            $date_input = trim(sanitize_text_field(wp_unslash($_GET['datepicker'])));
            $date_timestamp = strtotime($date_input);

            if ($date_input !== '' && $date_timestamp !== false) {
                $meta_query = array();
                $meta_query[] = array(
                    'key'         => 'department_date_',
                    'compare_key' => 'LIKE',
                    'value'       => date('Ymd', $date_timestamp),
                    'compare'     => '=',
                );
            }
        }

        if (!empty($meta_query)) {
            $query->set('meta_query', $meta_query);
        }
    }
}
add_action('pre_get_posts', 'custom_tour_archive_query');

//Hàm xử lý hiển thị phân trang
function custom_pagination($query = null)
{

?>
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
		<div class="st-pagination">

			<?php
			$archive_pagination = paginate_links(
				array(
					// cho chúng ta biết là mình đang ở trang nào
					'current'   => max(1, get_query_var('paged')),
					//Tổng số phân trang (ví dụ: tổng bài viết = 6; mỗi trang hiển thị 2 bài => tổng số phân trang = 3)
					'total'     => $query->max_num_pages,
					//Kiểu Mảng 
					'type'      => 'array',
					//Bật cho hiển thị lên 2 nút prev và next
					'prev_next' => true,
					//Nội dung hiển thị cho nút prev
					'prev_text' => esc_html__('Previous', 'travelme'),
					//Nội dung hiển thị cho nút next
					'next_text' => esc_html__('Next', 'travelme'),
				)
			);

			if (!is_null($archive_pagination)) :
			?>
				<ul class="pagination justify-content-center">
					<?php foreach ($archive_pagination as $page_link) : ?>
						<li class="<?php echo false !== strpos($page_link, 'current') ? 'active' : ''; ?>">
							<?php echo wp_kses_post($page_link); ?>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
	</div>
<?php
}



//Để xử lý Ajax, chúng ta cần tạo một hàm xử lý và đăng ký nó với WordPress. Dưới đây là ví dụ về cách bạn có thể làm điều đó:
add_action('wp_ajax_tour_booking', 'handle_tour_booking');
add_action('wp_ajax_nopriv_tour_booking', 'handle_tour_booking');

function handle_tour_booking()
{
	$product_id = intval($_POST['product_id']);
	$departure_date = sanitize_text_field($_POST['departure_date']);
	$guest_count = intval($_POST['guest_count']);

	if (!$product_id || !$guest_count) {
		wp_send_json_error('Invalid data.');
	}

	WC()->cart->empty_cart();

	$cart_item_data = array(
		'departure_date' => $departure_date,
		'guest_count' => $guest_count,

	);


	$cart_item_key = WC()->cart->add_to_cart($product_id, 1, 0, array(), $cart_item_data);


	if ($cart_item_key) {
		wp_send_json_success(array('redirect_url' => wc_get_checkout_url()));
	} else {
		wp_send_json_error('Failed to add to cart.');
	}
}

//display depature date and guest count in checkout page
add_filter('woocommerce_get_item_data', 'display_info_checkout', 10, 2);

function display_info_checkout($item_data, $cart_data)
{
	if (isset($cart_data["departure_date"])) {
		$item_data[] = [
			'key' => 'Departure Date',
			'value' => $cart_data["departure_date"]
		];
	}

	if (isset($cart_data["guest_count"])) {
		$item_data[] = [
			'key' => 'Guest Count',
			'value' => $cart_data["guest_count"]
		];
	}
	return $item_data;
}

//save order infor into database
add_action("woocommerce_checkout_create_order_line_item", "save_booking_data_to_order", 10, 4);

function save_booking_data_to_order(
	$item,
	$cart_item_key,
	$values,
	$order
) {
	// echo "<pre>";
	// var_dump($values);
	// echo "</pre>";

	if (isset($values["departure_date"])) {
		$item->add_meta_data(
			'Departure Date',
			$values["departure_date"]
		);
	}

	if (isset($values["guest_count"])) {
		$item->add_meta_data(
			'Guest Count',
			$values['guest_count']
		);
	}
}

function custom_wp_search_by_title_only($query)
{
	// Kiểm tra xem có đang ở trang tìm kiếm chính thống của WordPress và không phải trong trang quản trị (admin)
	if (! is_admin() && $query->is_main_query() && $query->is_search()) {

		// 1. Chỉ định chỉ tìm với post_type là 'post' (loại bỏ trang, sản phẩm, v.v.)
		$query->set('post_type', 'post');

		// 2. Can thiệp vào phần xử lý từ khóa tìm kiếm để chỉ tìm theo tiêu đề (title)
		add_filter('posts_search', 'custom_search_where_title_only', 10, 2);
	}
}
add_action('pre_get_posts', 'custom_wp_search_by_title_only');

/**
 * Hàm bổ trợ để giới hạn câu lệnh SQL WHERE chỉ tìm theo post_title
 */
function custom_search_where_title_only($search, $query)
{
	global $wpdb;

	// Lấy từ khóa tìm kiếm từ truy vấn
	$search_term = $query->get('s');

	if (empty($search_term)) {
		return $search;
	}

	// Xóa bộ lọc ngay sau khi chạy để tránh ảnh hưởng đến các truy vấn khác trên trang
	remove_filter('posts_search', 'custom_search_where_title_only', 10);

	// Tách các từ khóa nếu người dùng tìm kiếm nhiều từ (ví dụ: "lập trình wordpress")
	$like = '%' . $wpdb->esc_like($search_term) . '%';

	// Tạo câu lệnh SQL mới chỉ quét qua trường post_title và trạng thái là publish
	$search = $wpdb->prepare(" AND {$wpdb->posts}.post_title LIKE %s AND {$wpdb->posts}.post_status = 'publish' ", $like);

	return $search;
}

/* loại bỏ thẻ br*/
add_filter('wpcf7_autop_or_not', '__return_false');

//load tour weather info
require_once get_template_directory() . '/inc/weather.php';
function get_weather_info($code)
{
	switch ($code) {
		case 0:
			return ['text' => 'Trời quang đãng', 'icon' => '☀️'];
		case 1:
		case 2:
		case 3:
			return ['text' => 'Có mây / Nhiều mây', 'icon' => '⛅'];
		case 45:
		case 48:
			return ['text' => 'Có sương mù', 'icon' => '🌫️'];
		case 51:
		case 53:
		case 55:
		case 56:
		case 57:
			return ['text' => 'Mưa phùn nhẹ', 'icon' => '🌧️'];
		case 61:
		case 63:
		case 65:
		case 66:
		case 67:
			return ['text' => 'Có mưa', 'icon' => '🌧️'];
		case 71:
		case 73:
		case 75:
		case 77:
			return ['text' => 'Có tuyết rơi', 'icon' => '❄️'];
		case 80:
		case 81:
		case 82:
			return ['text' => 'Mưa rào', 'icon' => '🌦️'];
		case 85:
		case 86:
			return ['text' => 'Mưa tuyết', 'icon' => '🌨️'];
		case 95:
		case 96:
		case 99:
			return ['text' => 'Dông bão', 'icon' => '⚡'];
		default:
			return ['text' => 'Bình thường', 'icon' => '🌡️'];
	}
}


//add contact icon
add_action('wp_footer', function() {
    ?>
    <style>
    .fixed-contact-buttons {
        position: fixed;
        bottom: 80px;
        right: 24px;
        z-index: 99999;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }
    .contact-btn {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 52px;
        height: 52px;
        border-radius: 50%;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.18);
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }
    .contact-btn:hover {
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
    }
    .contact-btn.phone-btn {
        background: linear-gradient(135deg, #34D399 0%, #10B981 100%);
    }
    .contact-btn.zalo-btn {
        background: linear-gradient(135deg, #0088FF 0%, #0052CC 100%);
    }
    .contact-btn.messenger-btn {
        background: linear-gradient(135deg, #00B2FF 0%, #006AFF 100%);
    }
    .contact-btn.phone-btn::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        border: 2px solid #10B981;
        animation: phone-pulse 2s infinite;
        pointer-events: none;
    }
    @keyframes phone-pulse {
        0% { transform: scale(1); opacity: 0.8; }
        100% { transform: scale(1.5); opacity: 0; }
    }
    .contact-btn svg {
        width: 26px;
        height: 26px;
        fill: #ffffff;
    }
    @media (max-width: 768px) {
        .fixed-contact-buttons { bottom: 16px; right: 16px; gap: 10px; }
        .contact-btn { width: 46px; height: 46px; }
        .contact-btn svg { width: 22px; height: 22px; }
    }
    </style>

    <div class="fixed-contact-buttons">
        <a href="tel:0708375980" class="contact-btn phone-btn" title="Gọi hotline">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
        </a>
        <a href="https://zalo.me/0708375980" target="_blank" rel="noopener noreferrer" class="contact-btn zalo-btn" title="Chat Zalo">
            <svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg"><path d="M24 4C12.95 4 4 12.95 4 24c0 4.14 1.28 7.98 3.47 11.14L5.5 41.5l6.68-1.83C15.58 41.92 19.64 43 24 43c11.05 0 20-8.95 20-20S35.05 4 24 4zm-4.71 23.32c-.39.54-1.07.78-1.74.61-.83-.21-1.38-1.01-1.29-1.87.11-1.01.69-2.09 1.6-2.91 1.01-.91 2.26-1.55 3.63-1.84.7-.15 1.43.19 1.74.83.31.64.14 1.42-.42 1.91l-1.05.93c-.32.28-.78.36-1.18.2-1.04-.41-2.02-.99-2.9-1.73-.34-.29-.82-.29-1.16 0-.34.29-.34.78 0 1.07.99.85 2.1 1.51 3.3 1.95.46.17.77.63.74 1.13-.03.5-.41.91-.91.95-.59.05-1.16-.14-1.58-.51z" fill="#fff"/></svg>
        </a>
        <a href="https://m.me/1345740091964074" target="_blank" rel="noopener noreferrer" class="contact-btn messenger-btn" title="Chat Messenger" aria-label="Chat Messenger">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M12 2C6.48 2 2 6.16 2 11.29c0 2.92 1.42 5.52 3.64 7.22V22l3.33-1.83c.96.27 1.98.42 3.03.42 5.52 0 10-4.16 10-9.29S17.52 2 12 2zm1.02 12.51-2.55-2.72-4.97 2.72 5.47-5.81 2.61 2.72 4.91-2.72-5.47 5.81z"/></svg>
        </a>
    </div>
    <?php
});
