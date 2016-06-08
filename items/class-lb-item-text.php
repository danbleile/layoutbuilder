<?php

class LB_Item_Text extends LB_Item {
	
	protected $slug = 'text';
	
	protected $name = 'Text/HTML';
	
	
	public function get_form_html( $settings , $content ){
		
		ob_start();
		
		wp_editor( $content , '_content_' . $this->get_id() );
		
		$html = ob_get_clean();
		
		return $html;
		
	} // end $content
	
	
}