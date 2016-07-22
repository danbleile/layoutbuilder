<?php

class TKD_Item_Text extends TKD_Item {
	
	protected $slug = 'text';
	
	protected $title = 'Text/HTML';
	
	protected $desc = 'Insert a custom block of text/html.';
	
	protected $modal_size = 'large';
	
	protected function get_editor_default_content(){
		
		return '<div class="tkd-editor-default">Click to add text ...</div>';
		
	} // end get_editor_default_content
	
	
	protected function the_item( $settings , $content ){
		
		$html = apply_filters( 'tkd_the_content' , $content );
		
		return $html;
		
	} // end the_item
	
	
	protected function the_form( $settings , $content ){
		
		$input = $this->forms->get_content_prefix() . $this->get_id();
		
		ob_start();
		
		wp_editor( $content , $input );
		
		//$html = $this->forms->get_textarea( $input , $content );
		
		$basic = ob_get_clean();
		
		return array( 'Basic' => $basic );
		
	} // end the_form
	
	
}