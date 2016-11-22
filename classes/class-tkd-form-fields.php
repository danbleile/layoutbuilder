<?php

class TKD_Form_Fields {
	
	
	public function get_field( $type , $name , $args = array() ){
		
		$default_args = array(
			'label' 			=> '',
			'id' 				=> uniqid( 'tkd-input-' ),
			'class' 			=> '',
			'options' 			=> array(), // value => label
			'value' 			=> '', // array in some cases
			'current_value'		=> '', // select, checkbox, & radio inputs
			'placeholder'		=> '',
			'default_value' 	=> '',
			'do_wrap'			=> true,
		);
		
		$this->check_defaults( $args , $default_args );
		
		
		switch( $type ){
			
			case 'image_upload':
				$field = $this->get_field_upload_image( $name , $args );
				break;
			case 'text':
				$field = $this->get_field_text( $name , $args );
				break;
			case 'hidden':
				$args['do_wrap'] = false;
				$field = $this->get_field_hidden( $name , $args );
				break;
			case 'button':
				$field = $this->get_field_button( $args );
				$args['class'] = '';
				$args['label'] = '';
				break;
			case 'checkbox':
				$field = $this->get_field_checkbox( $name , $args );
				break;
			case 'select':
				$field = $this->get_field_select( $name , $args );
				break;
			default: 
				$field = '';
				break;
		} // end switch
		
		if ( $args['label'] && $field ){
			
			$field = $this->add_label( $field , $args['label'] , $args );
			
		} // end if
		
		if ( $args['do_wrap'] && $field ){
			
			$field = $this->wrap_fields( $field , $args );
			
		} // end if
		
		return $field;
		
	} // end get_field
	
	
	public function get_control( $type , $settings, $name_prefix = ''  ){
		
		$control = '';
		
		switch( $type ){
			
			case 'background_color':
				$control .= $this->get_control_background_color( $settings, $name_prefix );
				break;
			case 'background_image_src':
				$control .= $this->get_control_background_image_src( $settings, $name_prefix );
				break;
			case 'background_bleed':
				$control .= $this->get_control_background_bleed( $settings, $name_prefix );
				break;
			case 'text_color':
				$control .= $this->get_control_text_color( $settings, $name_prefix );
				break;
			case 'font_size':
				$control .= $this->get_control_font_size( $settings, $name_prefix );
				break;
			case 'font_weight':
				$control .= $this->get_control_font_weight( $settings, $name_prefix );
				break;
			case 'letter_spacing':
				$control .= $this->get_control_letter_spacing( $settings, $name_prefix );
				break;
			case 'font_family':
				$control .= $this->get_control_font_family( $settings, $name_prefix );
				break;
			case 'text_align':
				$control .= $this->get_control_text_align( $settings, $name_prefix );
				break;
			case 'line_height':
				$control .= $this->get_control_line_height( $settings, $name_prefix );
				break;
			case 'padding':
				$control .= $this->get_control_padding( $settings, $name_prefix );
				break;
			case 'max_width':
				$control .= $this->get_control_max_width( $settings, $name_prefix );
				break;
			case 'bleed-item':
				break;

			
		} // end switch
		
		return $control;
		
	} // end get_control
	
	
	public function get_control_max_width( $settings, $name_prefix = ''  ){
		
		$value = ( ! empty( $settings['max_width'] ) ) ? $settings['max_width'] : '';
		
		$field = $this->get_field( 
			'text',
			$name_prefix . '[max_width]', 
			array( 
				'label' => 'Max Width',
				'value' => $value
			) 
		);
		
		return $field;
		
	} // end 
	
	
	
	public function get_control_background_bleed( $settings, $name_prefix = '' ){
		
		$value_left = ( ! empty( $settings['background_bleed_right'] ) ) ? $settings['background_bleed_right'] : '';
		
		$value_right = ( ! empty( $settings['background_bleed_left'] ) ) ? $settings['background_bleed_left'] : '';
		
		$field = $this->get_field( 
			'checkbox', 
			$name_prefix . '[background_bleed_right]', 
			$args = array( 
				'value' => 1,
				'label' => 'Background Bleed Right',
				'current_value' =>  $settings['background_bleed_right'],
			) 
		);
		
		$field .= $this->get_field( 
			'checkbox', 
			$name_prefix . '[background_bleed_left]', 
			$args = array( 
				'value' => 1,
				'label' => 'Background Bleed Left',
				'current_value' =>  $settings['background_bleed_left'],
			) 
		);
		
		return $field;
		
	} // end 
	
	public function get_control_bleed_item( $settings, $name_prefix = ''  ){
	} // end 
	
	public function get_control_padding( $settings, $name_prefix = ''  ){
		
		$fields = '';
		
		$padding = array(
			'padding_top' 		=> 'Padding Top',
			'padding_right' 	=> 'Padding Right',
			'padding_bottom' 	=> 'Padding Bottom',
			'padding_left' 		=> 'Padding Left',
		);
		
		foreach( $padding as $key => $label ){
			
			$value = ( ! empty( $settings[ $key ] ) ) ? $settings[ $key ] : '';
			
			$fields .= $this->get_field( 
				'text',
				$name_prefix . '[' . $key . ']', 
				array( 
					'label' => $label,
					'value' => $value
				) 
			);
				
			
		} // end foreach		
		
		return $fields;
		
	} // end 
	
	public function get_control_line_height( $settings, $name_prefix = ''  ){
		
		$value = ( ! empty( $settings['line_height'] ) ) ? $settings['line_height'] : '';
		
		$field = $this->get_field( 
			'text',
			$name_prefix . '[line_height]', 
			array( 
				'label' => 'Line Height',
				'value' => $value
			) 
		);
		
		return $field;
		
	} // end 
	
	public function get_control_font_family( $settings, $name_prefix = ''  ){
		
		$value = ( ! empty( $settings['font_family'] ) ) ? $settings['font_family'] : '';
		
		$field = $this->get_field( 
			'text',
			$name_prefix . '[font_family]', 
			array( 
				'label' => 'Font Family',
				'value' => $value
			) 
		);
		
		return $field;
		
	} // end 
	
	public function get_control_letter_spacing( $settings, $name_prefix = ''  ){
		
		$value = ( ! empty( $settings['letter_spacing'] ) ) ? $settings['letter_spacing'] : '';
		
		$field = $this->get_field( 
			'text',
			$name_prefix . '[letter_spacing]', 
			array( 
				'label' => 'Letter Spacing',
				'value' => $value
			) 
		);
		
		return $field;
		
	} // end 
	
	public function get_control_font_weight( $settings, $name_prefix = ''  ){
		
		$value = ( ! empty( $settings['font_weight'] ) ) ? $settings['font_weight'] : '';
		
		$field = $this->get_field( 
			'text',
			$name_prefix . '[font_weight]', 
			array( 
				'label' => 'Font Weight',
				'value' => $value
			) 
		);
		
		return $field;
		
	} // end 
	
	public function get_control_font_size( $settings, $name_prefix = ''  ){
		
		$size = ( ! empty( $settings['font_size'] ) ) ? $settings['font_size'] : '';
		
		$field = $this->get_field( 
			'text',
			$name_prefix . '[font_size]', 
			array( 
				'label' => 'Font Size',
				'value' => $size
			) 
		);
		
		return $field;
		
	} // end
	 
	
	public function get_control_text_color( $settings, $name_prefix = ''  ){
		
		$value = ( ! empty( $settings['text_color'] ) ) ? $settings['text_color'] : '';
		
		$field = $this->get_field( 
			'text',
			$name_prefix . '[text_color]', 
			array( 
				'label' => 'Text Color',
				'value' => $value
			) 
		);
		
		return $field;
		
	} // end 
	
	
	public function get_control_text_align ( $settings, $name_prefix = ''  ){
		
		$value = ( ! empty( $settings['text_align'] ) ) ? $settings['text_align'] : '';
		
		$field = $this->get_field( 
			'text',
			$name_prefix . '[text_align]', 
			array( 
				'label' => 'Text Align',
				'value' => $value
			) 
		);
		
		return $field;
		
	} // end 
	
	public function get_control_background_color( $settings, $name_prefix = ''  ){
		
		$value = ( ! empty( $settings['background_color'] ) ) ? $settings['background_color'] : '';
		
		$field = $this->get_field( 
			'text',
			$name_prefix . '[background_color]', 
			array( 
				'label' => 'Background Color',
				'value' => $value
			) 
		);
		
		return $field;
		
	} // end 
	
	public function get_control_background_image_src( $settings, $name_prefix = ''  ){
		
		$value = ( ! empty( $settings['background_image_src'] ) ) ? $settings['background_image_src'] : '';
		
		$field = $this->get_field( 
			'text',
			$name_prefix . '[background_image_src]', 
			array( 
				'label' => 'Background Image URL',
				'value' => $value
			) 
		);
		
		return $field;
		
	} // end 
	
	
	public function get_control_set( $set , $settings , $name_prefix = '', $exclude = array() ){
		
		$fields = '';
		
		switch( $set ){
			case 'text':
				$fields .= $this->get_control_set_text( $settings, $name_prefix, $exclude );
				break;
			case 'background':
				$fields .= $this->get_control_set_background( $settings, $name_prefix, $exclude );
				break;
			case 'layout':
				$fields .= $this->get_control_set_layout( $settings, $name_prefix, $exclude );
				break;
		} // end switch
		
		return $fields;
		
	} // end get_control_set
	
	
	public function get_control_set_layout( $settings, $name_prefix = '', $exclude = array() ) {
		
		$set = '';
	
		$set .= $this->get_control( 'padding' , $settings, $name_prefix );
		$set .= $this->get_control( 'max_width' , $settings, $name_prefix );
		
		return $set;
		
	} // end get_control_set_text
	
	
	public function get_control_set_background( $settings, $name_prefix = '', $exclude = array() ) {
		
		$set = '';
	
		$set .= $this->get_control( 'background_color' , $settings, $name_prefix );
		$set .= $this->get_control( 'background_image_src' , $settings, $name_prefix );
		$set .= $this->get_control( 'background_bleed' , $settings, $name_prefix );
		
		return $set;
		
	} // end get_control_set_text
	
	
	public function get_control_set_text( $settings, $name_prefix = '' , $exclude = array() ) {
		
		$set = '';
	
		$set .= $this->get_control( 'text_color' , $settings, $name_prefix );
		$set .= $this->get_control( 'text_align' , $settings, $name_prefix );
		$set .= $this->get_control( 'font_size' , $settings, $name_prefix );
		$set .= $this->get_control( 'font_weight' , $settings, $name_prefix );
		$set .= $this->get_control( 'letter_spacing' , $settings, $name_prefix );
		$set .= $this->get_control( 'line_height' , $settings, $name_prefix );
		$set .= $this->get_control( 'font_family' , $settings, $name_prefix );
		
		return $set;
		
	} // end get_control_set_text
	
	
	public function sanitize_control_set( &$clean, $type , $settings ){
		
		$clean_set = array();
		
		switch( $type ){
			case 'text':
				$clean_set = $this->sanitize_control_set_text( $settings );
				break;
			case 'layout':
				$clean_set = $this->sanitize_control_set_layout( $settings );
				break;
			case 'background':
				$clean_set = $this->sanitize_control_set_background( $settings );
				break;
		} // end switch
		
		if ( ! empty( $clean_set ) ){
			
			$clean = array_merge( $clean , $clean_set );
			
		} // end if
		
	} // end sanitize_control_set
	
	
	public function sanitize_control_set_text( $settings ){
		
		$clean = array();
		
		$fields = array(
			'text_color' 		=> 'text',
			'text_align' 		=> 'text',
			'font_size' 		=> 'text',
			'font_weight' 		=> 'text',
			'letter_spacing' 	=> 'text',
			'line_height' 		=> 'text',
			'font_family' 		=> 'text',
		);
		
		foreach( $fields as $key => $type ){
			
			if ( ! empty( $settings[ $key ] ) ){
				
				$clean[ $key ] = $this->sanitize( $settings[ $key ] , $type );
				
			} // end if
			
		} // end foreach
		
		return $clean;
		
	} // end sanitize_control_set_text
	
	
	public function sanitize_control_set_layout( $settings ){
		
		$clean = array();
		
		$fields = array(
			'padding_top' 		=> 'text',
			'padding_right' 	=> 'text',
			'padding_bottom' 	=> 'text',
			'padding_left' 		=> 'text',
			'max_width' 		=> 'text',
		);
		
		foreach( $fields as $key => $type ){
			
			if ( ! empty( $settings[ $key ] ) ){
				
				$clean[ $key ] = $this->sanitize( $settings[ $key ] , $type );
				
			} // end if
			
		} // end foreach
		
		return $clean;
		
	} // end sanitize_control_set_text
	
	
	public function sanitize_control_set_background( $settings ){
		
		$clean = array();
		
		$fields = array(
			'background_color' 			=> 'text',
			'background_image_src' 		=> 'text',
			'background_bleed_right' 	=> 'text',
			'background_bleed_left' 	=> 'text',
		);
		
		foreach( $fields as $key => $type ){
			
			if ( ! empty( $settings[ $key ] ) ){
				
				$clean[ $key ] = $this->sanitize( $settings[ $key ] , $type );
				
			} // end if
			
		} // end foreach
		
		return $clean;
		
	} // end sanitize_control_set_text
	
	
	public function sanitize( $value , $type ){
		
		$clean_value = '';
		
		switch( $type ){
			
			case 'text':
				$clean_value = sanitize_text_field( $value );
				break;
			case 'specialcars':
				$clean_value = sanitize_text_field( $value );
				break;
		} // end switch
		
		return $clean_value;
		
	} // end sanitize
	
	
	
	public function get_field_select( $name , $args = array() ){
		
		$field = '<select name="' . $name . '">';
		
		if ( ! empty( $args['options'] ) ){
			
			foreach( $args['options'] as $value => $label ){
				
				$field .= '<option value="' . $value . '" ' . selected( $value , $args['value'] , false ) . '>' . $label . '</option>';
				
			} // end foreach
			
		} // end if
		
		$field .= '</select>';
		
		return $field;
		
	} // end get_field_select
	
	
	public function get_field_checkbox( $name , $args = array() ){
		
		$field = '';
			
		$field .= '<input type="checkbox" id="' . $args['id'] . '" name="' . $name . '" value="' . $args['value'] . '" ' . checked( $args['value'] , $args['current_value'] , false ) . ' />';
		
		return $field;
		
	} // end get_field_text
	
	
	public function get_field_text( $name , $args = array() ){
		
		$field = '<input type="text" name="' . $name. '" value="' . $args['value'] . '" placeholder="' . $args['placeholder'] . '" />';
		
		return $field;
		
	} // end get_field_text
	
	
	public function get_field_hidden( $name , $args = array() ){
		
		$field = '<input type="hidden" name="' . $name. '" value="' . $args['value'] . '" class="' . $args['class'] . '" />';
		
		return $field;
		
	} // end get_field_text
	
	
	public function get_field_button( $args ){
		
		$field = '<a class="wovax-form-button ' . $args['class'] . '" href="#">' . $args['label'] . '</a>';
		
		return $field;
		
	} // end get_field_button
	
	
	public function get_field_upload_image( $name , $args ){
		
		$default_values = array(
			$name . '_src' 	=> get_stylesheet_directory_uri() .'/images/placeholder.png',
			$name . '_id' 	=> '',
			$name . '_title' 	=> '',
		);
		
		$values = $args['value'];
		
		$this->check_defaults( $values , $default_values );
		
		$image_id_field 	= $this->get_field( 'hidden', $name . '_id' , array( 'value' => $values[ $name . '_id' ], 'class' => 'tkd-image-upload-id') );
        $image_src_field 	= $this->get_field( 'hidden' , $name . '_src' , array( 'value' => $values[ $name . '_src' ] , 'class' => 'tkd-image-upload-src') );
        $image_title_field 	= $this->get_field( 'hidden' , $name . '_title' , array( 'value' => $values[ $name . '_title' ] ,  'class' => 'tkd-image-upload-title') );
		$image_button		= $this->get_field( 'button', '' , array( 'label' => 'Select Image' , 'class' => 'tkd-image-upload-do') );
		
		ob_start();
		
		include( locate_template( 'includes/include-field-upload-image.php' ) );
		
		$field = ob_get_clean();
		
		return $field;
		
	} // end get_field_upload_image
	
	
	
	public function wrap_fields( $field , $args ){
		
		$field = '<div class="tkd-field ' . $args['class'] . '">' . $field . '</div>';
		
		return $field;
		
	} // end wrap_fields
	
	
	public function add_label( $field , $label , $args = array() ){
		
		$id = ( ! empty( $args['id'] ) )? $args['id'] : '';
		
		$field = '<label for="' . $id . '">' . $label . '</label>' . $field;
		
		return $field;
		
	} // end add_label
	
	
	private function check_defaults( &$args , $defaults ){
		
		if ( ! is_array( $args ) ){
			
			$args = array();
				
		} // end if
		
		foreach( $defaults as $key => $value ){
			
			if ( ! array_key_exists( $key , $args ) ) {
				
				$args[ $key ] = $value;
				
			} // end if
			
		} // end foreach
		
	} // end check_defaults
	
	
}