<?php

class TKD_Item_Row extends TKD_Item {
	
	protected $slug = 'tkdrow';
	
	protected $title = 'Row';
	
	protected $allowed_childen = array('tkdcolumn');
	
	protected $default_children = 'tkdcolumn';
	
	protected $default_settings = array(
		'layout' 				=> 'single',
		'background_color' 		=> '',
		'background_image_src' 	=> '',
		'padding' 				=> 'auto',
		'text_color' 			=> '',
		'align_center' 			=> '',
		'max_width'				=> '',
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
		
		$tkd_column_index = 0;
		
		if ( empty( $settings['layout'] ) ) $settings['layout'] = 'single';
		
		$class = apply_filters( 'tkd_builder_item_class' , $this->get_item_classes( $settings , array( 'tkd-row' , 'layout-' . $settings['layout'] ) ), $this , $settings );
		
		$style = apply_filters( 'tkd_builder_item_style' , $this->get_item_style( $settings ), $this , $settings );
		
		$content = apply_filters( 'tkd_builder_item_content' , $content , $this , $settings );
		
		ob_start();
		
		include plugin_dir_path( dirname( __FILE__ ) ) . 'inc/inc-tkd-item-row.php';
		
		$html = apply_filters( 'tkd_builder_item_html' , ob_get_clean() , $this , $settings );
		
		return $html;
		
	} // end the_item
	
	
	protected function the_editor( $settings , $content ){
		
		if ( empty( $settings['layout'] ) ) $settings['layout'] = 'single';
		
		$class = array( 'tkd-builder-item' , 'tkd-row' , $this->get_setting('layout') );
		
		$id = $this->get_id();
		
		$child_ids = implode( ',' , $this->get_child_ids() );
		
		$input_name = $this->get_input_name( false, false );
		
		ob_start();
		
		include plugin_dir_path( dirname( __FILE__ ) ) . 'inc/tkd-item-row.php';
		
		return ob_get_clean();
		
	} // end the_editor
	
	
	protected function the_form( $settings , $content ){
		
		$html = $this->form_fields->get_field( 
			'hidden', 
			$this->get_input_name( 'layout' ), 
			$args = array( 
				'value' => $settings['layout'] 
			) 
		);
		
		$html .= $this->form_fields->get_field( 
			'select', 
			$this->get_input_name( 'padding' ), 
			$args = array( 
				'value' => $settings['padding'],
				'label' => 'Padding Top',
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
		);
		
		return $form;
		
	} // end the_form
	
	protected function clean_settings( $settings ){
		
		$clean = array();
		
		if ( isset( $settings['layout'] ) ) {
			
			$clean['layout'] = sanitize_text_field( $settings['layout'] );
			
			$clean['background_image_src'] = sanitize_text_field( $settings['background_image_src'] );
			
			$clean['background_color'] = sanitize_text_field( $settings['background_color'] );
			
			$clean['text_color'] = sanitize_text_field( $settings['text_color'] );
			
			$clean['padding'] = sanitize_text_field( $settings['padding'] );
			
			$clean['align_center'] = sanitize_text_field( $settings['align_center'] );
			
			$clean['max_width'] = sanitize_text_field( $settings['max_width'] );
			
		} // end if
		
		$this->form_fields->sanitize_control_set( $clean, 'layout' , $settings );
		$this->form_fields->sanitize_control_set( $clean, 'background' , $settings );
		
		return $clean;
		
	} // end clean_settings
	
	
}