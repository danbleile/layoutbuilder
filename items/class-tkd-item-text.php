<?php

class TKD_Item_Text extends TKD_Item {
	
	protected $slug = 'tkdtext';
	
	protected $title = 'Text/HTML';
	
	protected $desc = 'Insert a custom block of text/html.';
	
	protected $modal_size = 'large';
	
	protected $is_dynamic_editor = true;
	
	protected $default_settings = array(
		'csshook' 					=> '',
		'align_center' 				=> '',
		'text_color' 				=> '',
		'text_align' 				=> '',
		'font_size' 				=> '',
		'font_weight' 				=> '',
		'letter_spacing' 			=> '',
		'line_height' 				=> '',
		'font_family' 				=> '',
		'padding_top' 				=> '',
		'padding_right' 			=> '',
		'padding_bottom' 			=> '',
		'padding_left' 				=> '',
		'max_width' 				=> '',
	);
	
	
	
	protected function get_editor_default_content(){
		
		return '<div class="tkd-editor-default">Click to add text ...</div>';
		
	} // end get_editor_default_content
	
	
	protected function the_item( $settings , $content ){
		
		$style = apply_filters( 'tkd_builder_item_style' , $this->get_item_style( $settings ), $this , $settings );
		
		$html = apply_filters( 'tkd_the_content' , $content );
		
		if ( ! empty( $style ) ){
		
			$html = '<div class="tkd-text"  style="' . implode( ';' , $style ) . '">' . $html . '</div>';
		
		} // end if
		
		return $html;
		
	} // end the_item
	
	
	protected function the_form( $settings , $content ){
		
		$input = $this->forms->get_content_prefix() . $this->get_id();
		
		ob_start();
		
		wp_editor( $content , $input );
		
		//$html = $this->forms->get_textarea( $input , $content );
		
		$basic = ob_get_clean();
		
		$form = array( 
			'Basic' 			=> $basic, 
			'Layout & Spacing' 	=> $this->form_fields->get_control_set( 'layout' , $settings, $this->get_input_name() ), 
			'Text' 				=> $this->form_fields->get_control_set( 'text' , $settings, $this->get_input_name() ), 
		);
		
		return $form;
		
	} // end the_form
	
	
	protected function clean_settings( $settings ){
		
		$clean = array();
		
		$this->form_fields->sanitize_control_set( $clean, 'text' , $settings );
		$this->form_fields->sanitize_control_set( $clean, 'layout' , $settings );
		
		return $clean;
		
	} // end clean_settings
	
	
}