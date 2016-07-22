<?php

class TKD_Item_Subtitle extends TKD_Item {
	
	protected $slug = 'subtitle';
	
	protected $title = 'Subtitle';
	
	protected $desc = 'Add Subtitle to content.';
	
	protected $default_settings = array(
		'title' => '',
		'tag'   => 'h3',
	);
	
	protected $modal_size = 'small';
	
	
	protected function get_editor_default_content(){
		
		return '<h1 class="tkd-editor-default">Add Subtitle ...</h1>';
		
	} // end get_editor_default_content
	
	
	protected function the_item( $settings , $content ){
		
		$html = '';
		
		return $html;
		
	} // end the_item
	
	
	protected function the_form( $settings , $content ){
		
		$form = $this->forms->get_text_field( $this->get_input_name('title') , '' ); 
		
		return $form;
		
	} // end the_form
	
	
	protected function clean_settings( $settings ){
		
		$clean = array();
		
		if ( isset( $settings['title'] ) ) {
			
			$clean['title'] = sanitize_text_field( $settings['title'] );
			
		} // end if
		
		if ( isset( $settings['tag'] ) ) {
			
			$clean['tag'] = sanitize_text_field( $settings['tag'] );
			
		} // end if
		
		return $clean;
		
	} // end clean_settings
	
	
}