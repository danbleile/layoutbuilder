<?php

class TKD_Post_Editor {
	
	protected $item_factory;
	
	public function __construct( $item_factory ){
		
		$this->item_factory = $item_factory;
		
	} // end __construct
	
	
	public function init(){
		
		add_action( 'edit_form_after_title' , array( $this , 'the_editor' ), 99 );
		
	} // end init
	
	
	public function the_editor( $post ){
		
		echo 'test';
		
		$items = $this->item_factory->get_items_from_content( $post->post_content , array( 'row' ) , 'row' );
		
		$this->the_layout_editor( $post , $items );
		
	} // end the_editor
	
	public function the_layout_editor( $post , $items){
		
		var_dump( $items );
		
	} // end the_layout_editor
	
} // end TKD_Post_Editor