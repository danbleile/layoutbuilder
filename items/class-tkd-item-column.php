<?php

class TKD_Item_Column extends TKD_Item {
	
	protected $slug = 'tkdcolumn';
	
	protected $title = 'Column';
	
	protected $allowed_childen = 'content';
	
	protected $default_children = 'tkdtext';
	
	protected $default_settings = array(
		'padding' 					=> '',
		'full_bleed_right' 			=> '',
		'full_bleed_left' 			=> '',
		'css_hook'					=> '',
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
		'background_color' 			=> '',
		'background_image_src' 		=> '',
		'background_bleed_right' 	=> '',
		'background_bleed_left' 	=> '',
	);
	
	
	
	protected function the_item( $settings , $content ){
		
		global $tkd_column_index;
		
		$class = apply_filters( 'tkd_builder_item_class' , $this->get_item_classes( $settings , array( 'tkd-column' , 'tkd-column-' . $this->get_index_text( $tkd_column_index ) ) ), $this , $settings );
		
		$exclude = array('background-image','background-color');
		
		$style = apply_filters( 'tkd_builder_item_style' , $this->get_item_style( $settings  ), $this , $settings );
		
		$content = apply_filters( 'tkd_builder_item_content' , $content , $this , $settings );
		
		ob_start();
		
		include plugin_dir_path( dirname( __FILE__ ) ) . 'inc/inc-tkd-item-column.php';
		
		$html = ob_get_clean();
		
		$tkd_column_index++;
		
		return $html;
		
	} // end the_item
	
	
	
	protected function the_editor( $settings , $content ){
		
		$class = array( 
			'tkd-builder-item', 
			'tkd-column' ,
			'tkd-column-' . $this->get_index_text( $this->get_index() ),
			);
		
		$id = $this->get_id();
		
		$child_ids = implode( ',' , $this->get_child_ids() );
		
		$input_name = $this->get_input_name( false, false );
		
		ob_start();
		
		include plugin_dir_path( dirname( __FILE__ ) ) . 'inc/inc-editor-item-column.php';
		
		return ob_get_clean();
		
	} // end the_editor
	
	
	protected function the_form( $settings , $content ){
		
		$html .= $this->form_fields->get_field( 
			'select', 
			$this->get_input_name( 'padding' ), 
			$args = array( 
				'value' => $settings['padding'],
				'label' => 'Padding',
				'options' => array(
					'auto' => 'Auto',
					'none' => 'None',
					'small' => 'Small',
					'medium' => 'Medium',
					'large' => 'Large',
				) 
			) 
		);
		
		$html .= $this->form_fields->get_field( 
			'checkbox', 
			$this->get_input_name( 'align_center' ), 
			$args = array( 
				'value' => 1,
				'label' => 'Align Center',
				'current_value' =>  $settings['align_center'],
			) 
		);
		
		
		$form = array( 
			'Basic' 			=> $html, 
			'Layout & Spacing' 	=> $this->form_fields->get_control_set( 'layout' , $settings, $this->get_input_name() ), 
			'Background' 		=> $this->form_fields->get_control_set( 'background' , $settings, $this->get_input_name() ), 
			'Text' 				=> $this->form_fields->get_control_set( 'text' , $settings, $this->get_input_name() ), 
		);
		
		return $form;
		
	} // end the_form
	
	
	protected function clean_settings( $settings ){
		
		$clean = array();
			
		$this->form_fields->sanitize_control_set( $clean, 'text' , $settings );
		$this->form_fields->sanitize_control_set( $clean, 'layout' , $settings );
		$this->form_fields->sanitize_control_set( $clean, 'background' , $settings );
		
		return $clean;
		
	} // end clean_settings
	
}