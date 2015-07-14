<?php // Opening PHP tag - nothing should be before this, not even whitespace

// Custom Function to Include
if ( ! function_exists( 'dynamicnews_display_postmeta' ) ) {

	function dynamicnews_display_postmeta() { ?>
	    <span class="meta-author" style="color:#777">
		<?php printf(__('By <a href="%1$s" title="%2$s" rel="author" style="color:#777">%3$s</a>, Cannon Writer ', 'dynamicnews'), 
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_attr( sprintf( __( 'View all posts by %s', 'dynamicnews' ), get_the_author() ) ),
				get_the_author()
			);
		?>
		</span>

		<span class="meta-date">
		<?php printf(__('<a href="%1$s" title="%2$s" rel="bookmark"><time datetime="%3$s"> %4$s</time></a>', 'dynamicnews'), 
				esc_url( get_permalink() ),
				esc_attr( get_the_time() ),
				esc_attr( get_the_date( 'c' ) ),
				esc_html( get_the_date() )
			);
		?>
		</span>
		
		
	    <?php
	}
}

if ( ! function_exists( 'dynamicnews_display_postinfo_single' ) ):
	
	function dynamicnews_display_postinfo_single() {

		$tag_list = get_the_tag_list('', ', ');
		if ( $tag_list ) : ?>
			<span class="meta-tags">
				<?php printf(__('Tagged with: %1$s', 'dynamicnews'), $tag_list); ?>
			</span>
	<?php
		endif;
	?>

<?php

	}
	
endif;?>
<?php
add_action( 'widgets_init', 'dynamicnews_register_sidebars' );

if ( ! function_exists( 'dynamicnews_register_sidebars' ) ):
function dynamicnews_register_sidebars() {
	//added a second sidebar just for news!
	register_sidebar( array(
		'name' => __( 'News Sidebar', 'dynamicnews' ),
		'id' => 'news-sidebar',
		'description' => __( 'sidebar just for news.', 'dynamicnews' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widgettitle"><span>',
		'after_title' => '</span></h3>',
	));

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
?>
