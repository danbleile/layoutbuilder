<?php

class TKD_Item_Text extends TKD_Item {
	
	protected $slug = 'text';
	
	protected $title = 'Text/HTML';
	
	protected function get_editor_default_content(){
		
		return '<div class="tkd-editor-default">Click to add text ...</div>';
		
	} // end get_editor_default_content
	
	
	protected function the_form( $settings , $content ){
		
		$input = $this->forms->get_content_prefix() . $this->get_id();
		
		$html = $this->forms->get_textarea( $input , $content );
		
		return $html;
		
	} // end the_form
	
}