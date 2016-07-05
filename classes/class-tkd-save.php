<?php

class TKD_Save {
	
	protected $items_factory;
	
	protected $shortcodes;
	
	public function __construct( $items_factory , $shortcodes ){
		
		$this->items_factory = $items_factory;
		
		$this->shortcodes = $shortcodes;
		
	} // end __construct
	
	
	public function init(){
		
		add_filter( 'content_save_pre' , array( $save , 'save_content' ) , 99 );
		
	} // end init
	
	
	public function save_content( $content ){
		
		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {

			return $content;

		} // end if
		
		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {

			return $content;

		} // end if
		
	} // end save_content
	
	
	
} // end TKD_Save