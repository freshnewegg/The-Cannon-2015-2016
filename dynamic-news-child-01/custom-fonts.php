<?php
    // Include Fonts from Google Web Fonts API
function child_dynamicnews_load_web_fonts() { 
	// Get Theme Options from Database
	$theme_options = dynamicnews_theme_options();
	
	// Default Fonts which haven't to be load from Google
	$default_fonts = array('Arial', 'Verdana', 'Tahoma', 'Times New Roman');
	
	// Embed Text Font
	if( isset($theme_options['text_font']) and !in_array($theme_options['text_font'], $default_fonts)) :
		
		wp_register_style('dynamicnews-text-font', '//fonts.googleapis.com/css?family=' . $theme_options['text_font']);
		wp_enqueue_style('dynamicnews-text-font');
		
		// add embedded font to array to prevent second font embed
		$default_fonts[] = $theme_options['text_font']; 
	endif;
	
	// Embed Title Font
	if( isset($theme_options['title_font']) and !in_array($theme_options['title_font'], $default_fonts)) :
		
		wp_register_style('dynamicnews-title-font', '//fonts.googleapis.com/css?family=' . $theme_options['title_font']);
		wp_enqueue_style('dynamicnews-title-font');
		
		// add embedded font to array to prevent second font embed
		$default_fonts[] = $theme_options['title_font']; 
	endif;
	
	// Embed Navigation Font
	if( isset($theme_options['navi_font']) and !in_array($theme_options['navi_font'], $default_fonts)) :
		
		wp_register_style('dynamicnews-navi-font', '//fonts.googleapis.com/css?family=' . $theme_options['navi_font']);
		wp_enqueue_style('dynamicnews-navi-font');
		
		// add embedded font to array to prevent second font embed
		$default_fonts[] = $theme_options['navi_font']; 
	endif;

	// Embed Widget Title Font
	if( isset($theme_options['widget_title_font']) and !in_array($theme_options['widget_title_font'], $default_fonts)) :
		
		wp_register_style('dynamicnews-widget-title-font', '//fonts.googleapis.com/css?family=' . $theme_options['widget_title_font']);
		wp_enqueue_style('dynamicnews-widget-title-font');
		
		// add embedded font to array to prevent second font embed
		$default_fonts[] = $theme_options['widget_title_font']; 
	endif;
}
add_action('wp_enqueue_scripts', 'child_dynamicnews_load_web_fonts');

function child_remove_parent_function() {
    remove_action( 'wp_enqueue_scripts', 'dynamicnews_load_web_fonts' );
}
add_action( 'wp_loaded', 'child_remove_parent_function' );
?>