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
	
endif;