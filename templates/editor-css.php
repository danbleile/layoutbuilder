<?php

global $wp_styles;

do_action( 'wp_enqueue_scripts' );

$style_urls = array();

///var_dump( $wp_styles->registered );

foreach( $wp_styles->registered as $key => $style ){
	
	if ( ( strpos( $style->src , '/wp-admin/' ) === false ) && ( strpos( $style->src , '/wp-includes/' ) === false ) ){
		
		$style_urls[ $style->handle ] = $style->src;
		
	} // end if
	
} // end foreach

$css = '';

foreach( $style_urls as $handle => $css_file ){
	
	if ( $css_file ){
	
		$css .= @file_get_contents( $css_file );
	
	} // end if
	
} // end foreach

echo $css;