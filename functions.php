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


function custom_tour_archive_query($query)
{
	if (! is_admin() && $query->is_main_query() && is_post_type_archive('tour')) {
		$meta_query = array('relation' => 'OR');
		// 1. Lọc theo Thành phố
		if (! empty($_GET['country'])) {
			$tax_query = array(
				array(
					'taxonomy' => 'country',
					'field' => 'slug',
					'terms' => sanitize_text_field($_GET['country']),
				),
			);
			$query->set('tax_query', $tax_query);
		}

		//2. Lọc the ngày
		if (isset($_GET['datepicker']) && is_string($_GET['datepicker']) && $_GET['datepicker'] !== '') {
			$date_input = sanitize_text_field($_GET['datepicker']);
			$date_timestamp = strtotime($date_input);
			if ($date_timestamp !== false) {
				$meta_query[] = array(
					'key' => 'department_date_',
					'compare_key' => 'LIKE',
					'value' => date('Ymd', $date_timestamp),
					'compare' => '=',
				);
			}
		}
		//Cập nhật lại meta_query cho Query chính của wordpress
		$query->set('meta_query', $meta_query);
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
