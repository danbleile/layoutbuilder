<?php

class TKD_Item_Text extends TKD_Item {
	
	protected $slug = 'text';
	
	protected $title = 'Text/HTML';
	
	protected $modal_size = 'large';
	
	protected function get_editor_default_content(){
		
		return '<div class="tkd-editor-default">Click to add text ...</div>';
		
	} // end get_editor_default_content
	
	
	protected function the_form( $settings , $content ){
		
		$input = $this->forms->get_content_prefix() . $this->get_id();
		
		ob_start();
		
		wp_editor( $content , $input );
		
		//$html = $this->forms->get_textarea( $input , $content );
		
		$basic = ob_get_clean();
		
		return array( 'Basic' => $basic );
		
	} // end the_form
	
	
}