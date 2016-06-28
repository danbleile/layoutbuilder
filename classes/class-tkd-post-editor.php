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
		
		$items_html = $this->get_editor_items_html( $items );
		
		var_dump( $items_html);
		
	} // end the_layout_editor
	
	
	public function get_editor_items_html( $items ){
		
		$html = '';
		
		foreach( $items as $item ){
			
			if ( $children = $item->get_children() ){
				
				$inner_content = $this->get_editor_items_html( $children );
				
			} else {
				
				$inner_content = $item->get_editor_content();
				
			} // end if
			
			$html .= $item->get_editor_html( $inner_content );
			
		} // end foreach
		
		return $html;
		
	} // end get_editor_items_html
	
} // end TKD_Post_Editor