<?php

// Set Content Width
if ( ! isset( $content_width ) )
	$content_width = 860;

/*==================================== THEME SETUP ====================================*/

// Load default style.css and Javascripts
add_action('wp_enqueue_scripts', 'dynamicnews_enqueue_scripts');

if ( ! function_exists( 'dynamicnews_enqueue_scripts' ) ):
function dynamicnews_enqueue_scripts() {

	// Get Theme Options from Database
	$theme_options = dynamicnews_theme_options();
	
	// Register and Enqueue Stylesheet
	wp_enqueue_style('dynamicnews-stylesheet', get_stylesheet_uri());
	
	// Register Genericons
	wp_enqueue_style('dynamicnews-genericons', get_template_directory_uri() . '/css/genericons.css');

	// Register and Enqueue FlexSlider JS and CSS if necessary
	if ( ( isset($theme_options['slider_activated_blog']) and $theme_options['slider_activated_blog'] == true )
		|| ( isset($theme_options['slider_activated_front_page']) and $theme_options['slider_activated_front_page'] == true ) ) :

		// FlexSlider CSS
		wp_enqueue_style('dynamicnews-flexslider', get_template_directory_uri() . '/css/flexslider.css');

		// FlexSlider JS
		wp_enqueue_script('dynamicnews-jquery-flexslider', get_template_directory_uri() .'/js/jquery.flexslider-min.js', array('jquery'));

		// Register and enqueue slider.js
		wp_enqueue_script('dynamicnews-jquery-frontpage_slider', get_template_directory_uri() .'/js/slider.js', array('dynamicnews-jquery-flexslider'));

	endif;

	// Register and enqueue navigation.js
	wp_enqueue_script('dynamicnews-jquery-navigation', get_template_directory_uri() .'/js/navigation.js', array('jquery'));

}
endif;

// Load comment-reply.js if comment form is loaded and threaded comments activated
add_action( 'comment_form_before', 'dynamicnews_enqueue_comment_reply' );

function dynamicnews_enqueue_comment_reply() {
	if( get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}


// Setup Function: Registers support for various WordPress features
add_action( 'after_setup_theme', 'dynamicnews_setup' );

if ( ! function_exists( 'dynamicnews_setup' ) ):
function dynamicnews_setup() {

	// init Localization
	load_theme_textdomain('dynamicnews', get_template_directory() . '/languages' );

	// Add Theme Support
	add_theme_support('post-thumbnails');
	add_theme_support('automatic-feed-links');
	add_editor_style();
	
	// Add Custom Background
	add_theme_support('custom-background', array('default-color' => 'e5e5e5'));

	// Add Custom Header
	add_theme_support('custom-header', array(
		'header-text' => false,
		'width'	=> 1340,
		'height' => 200,
		'flex-height' => true));
		
	// Add theme support for Jetpack Featured Content
	add_theme_support( 'featured-content', array(
		'featured_content_filter' => 'dynamicnews_get_featured_content',
		'max_posts'  => 20
		)
	);

	// Register Navigation Menus
	register_nav_menu( 'primary', __('Main Navigation', 'dynamicnews') );
	register_nav_menu( 'footer', __('Footer Navigation', 'dynamicnews') );
	
	// Register Social Icons Menu
	register_nav_menu( 'social', __('Social Icons', 'dynamicnews') );

}
endif;


// Add custom Image Sizes
add_action( 'after_setup_theme', 'dynamicnews_add_image_sizes' );

if ( ! function_exists( 'dynamicnews_add_image_sizes' ) ):
function dynamicnews_add_image_sizes() {

	// Add Custom Header Image Size
	add_image_size( 'custom_header_image', 1340, 200, true);


	// Add Featured Image Size
	add_image_size( 'featured_image', 860, 9999);

	// Add Slider Image Size
	add_image_size( 'slider_image', 880, 9999);

	// Add Frontpage Thumbnail Sizes
	add_image_size( 'category_posts_wide_thumb', 420, 140, true);
	add_image_size( 'category_posts_small_thumb', 90, 90, true);

	// Add Widget Post Thumbnail Size
	add_image_size( 'widget_post_thumb', 75, 75, true);

}
endif;


// Register Sidebars
add_action( 'widgets_init', 'dynamicnews_register_sidebars' );

if ( ! function_exists( 'dynamicnews_register_sidebars' ) ):
function dynamicnews_register_sidebars() {

	// Register Sidebars
	register_sidebar( array(
		'name' => __( 'Sidebar', 'dynamicnews' ),
		'id' => 'sidebar',
		'description' => __( 'Appears on posts and pages except front page and fullwidth template.', 'dynamicnews' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widgettitle"><span>',
		'after_title' => '</span></h3>',
	));
	register_sidebar( array(
		'name' => __( 'Magazine Front Page', 'dynamicnews' ),
		'id' => 'frontpage-magazine',
		'description' => __( 'Appears on Magazine Front Page page template only. You can use the Category Posts widgets here.', 'dynamicnews' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	));

	//Register Footer Widgets
	register_sidebar( array(
		'name' => __( 'Footer Left', 'dynamicnews' ),
		'id' => 'footer-left',
		'description' => __( 'Appears on footer on the left hand side.', 'dynamicnews' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	));
	register_sidebar( array(
		'name' => __( 'Footer Center Left', 'dynamicnews' ),
		'id' => 'footer-center-left',
		'description' => __( 'Appears on footer on center left position.', 'dynamicnews' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	));
	register_sidebar( array(
		'name' => __( 'Footer Center Right', 'dynamicnews' ),
		'id' => 'footer-center-right',
		'description' => __( 'Appears on footer on center right position.', 'dynamicnews' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	));
	register_sidebar( array(
		'name' => __( 'Footer Right', 'dynamicnews' ),
		'id' => 'footer-right',
		'description' => __( 'Appears on footer on the right hand side.', 'dynamicnews' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	));
}
endif;


/*==================================== THEME FUNCTIONS ====================================*/

// Creates a better title element text for output in the head section
add_filter( 'wp_title', 'dynamicnews_wp_title', 10, 2 );

function dynamicnews_wp_title( $title, $sep = '' ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'dynamicnews' ), max( $paged, $page ) );

	return $title;
}


// Add Default Menu Fallback Function
function dynamicnews_default_menu() {
	echo '<ul id="mainnav-menu" class="menu">'. wp_list_pages('title_li=&echo=0') .'</ul>';
}


// Get Featured Posts
function dynamicnews_get_featured_content() {
	return apply_filters( 'dynamicnews_get_featured_content', false );
}


// Display Credit Link Function
function dynamicnews_credit_link() {
	
	// Get Theme Options from Database
	$theme_options = dynamicnews_theme_options();
	
	if ( isset($theme_options['credit_link']) and $theme_options['credit_link'] == true ) :
	
		printf(__( 'Powered by %1$s and %2$s.', 'dynamicnews' ), 
				sprintf( '<a href="http://wordpress.org" title="WordPress">%s</a>', __( 'WordPress', 'dynamicnews' ) ),
				sprintf( '<a href="http://themezee.com/themes/dynamicnews/" title="Dynamic News WordPress Theme">%s</a>', __( 'Dynamic News', 'dynamicnews' ) )
			);
		
	endif;
}


// Change Excerpt Length
add_filter('excerpt_length', 'dynamicnews_excerpt_length');
function dynamicnews_excerpt_length($length) {
    return 60;
}


// Slideshow Excerpt Length
function dynamicnews_slideshow_excerpt_length($length) {
    return 30;
}

// Frontpage Category Excerpt Length
function dynamicnews_frontpage_category_excerpt_length($length) {
    return 25;
}

// Change Excerpt More
add_filter('excerpt_more', 'dynamicnews_excerpt_more');
function dynamicnews_excerpt_more($more) {
    return '';
}


// Custom Template for comments and pingbacks.
if ( ! function_exists( 'dynamicnews_list_comments' ) ):
function dynamicnews_list_comments($comment, $args, $depth) {

	$GLOBALS['comment'] = $comment;

	if( $comment->comment_type == 'pingback' or $comment->comment_type == 'trackback' ) : ?>

		<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
			<p><?php _e( 'Pingback:', 'dynamicnews' ); ?> <?php comment_author_link(); ?>
			<?php edit_comment_link( __( '(Edit)', 'dynamicnews' ), '<span class="edit-link">', '</span>' ); ?>
			</p>

	<?php else : ?>

		<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">

			<div id="div-comment-<?php comment_ID(); ?>" class="comment-body">

				<div class="comment-author vcard clearfix">
					<span class="fn"><?php echo get_comment_author_link(); ?></span>
					<div class="comment-meta commentmetadata">
						<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
							<?php echo get_comment_date(); ?>
							<?php echo get_comment_time(); ?>
						</a>
						<?php edit_comment_link(__('(Edit)', 'dynamicnews'),'  ','') ?>
					</div>

				</div>

				<div class="comment-content clearfix">

					<?php echo get_avatar( $comment, 72 ); ?>

					<?php if ($comment->comment_approved == '0') : ?>
						<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'dynamicnews' ); ?></p>
					<?php endif; ?>

					<?php comment_text(); ?>

				</div>

				<div class="reply">
					<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
				</div>

			</div>

<?php
	endif;

}
endif;


/*==================================== INCLUDE FILES ====================================*/

// include Theme Info page
require( get_template_directory() . '/inc/theme-info.php' );

// include Theme Customizer Options
require( get_template_directory() . '/inc/customizer/customizer.php' );
require( get_template_directory() . '/inc/customizer/default-options.php' );

// include Customization Files
require( get_template_directory() . '/inc/customizer/frontend/custom-colors.php' );
require( get_template_directory() . '/inc/customizer/frontend/custom-fonts.php' );
require( get_template_directory() . '/inc/customizer/frontend/custom-layout.php' );
require( get_template_directory() . '/inc/customizer/frontend/custom-jscript.php' );

// include Template Functions
require( get_template_directory() . '/inc/template-tags.php' );
require( get_template_directory() . '/inc/front-page-functions.php' );

// include Widget Files
require( get_template_directory() . '/inc/widgets/widget-social-icons.php' );
require( get_template_directory() . '/inc/widgets/widget-recent-comments.php' );
require( get_template_directory() . '/inc/widgets/widget-recent-posts.php' );
require( get_template_directory() . '/inc/widgets/widget-popular-posts.php' );
require( get_template_directory() . '/inc/widgets/widget-tabbed-content.php' );

require( get_template_directory() . '/inc/widgets/widget-category-posts-boxed.php' );
require( get_template_directory() . '/inc/widgets/widget-category-posts-columns.php' );
require( get_template_directory() . '/inc/widgets/widget-category-posts-grid.php' );

// Include Featured Content class in case it does not exist yet (e.g. user has not Jetpack installed)
if ( ! class_exists( 'Featured_Content' ) && 'plugins.php' !== $GLOBALS['pagenow'] ) {
	require( get_template_directory() . '/inc/featured-content.php' );
}

?>