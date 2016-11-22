<?php

class TKD_Item_Subtitle extends TKD_Item {
	
	protected $slug = 'tkdsubtitle';
	
	protected $title = 'Subtitle';
	
	protected $desc = 'Add Subtitle to content.';
	
	protected $is_dynamic_editor = true;
	
	protected $default_settings = array(
		'csshook' 					=> '',
		'title'   					=> '',
		'tag'     					=> 'h3',
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
		'text_transform'			=> '',
	);
	
	protected $modal_size = 'small';
	
	
	//protected function get_editor_default_content(){
		
		//return '<h1 class="tkd-editor-default">Add Subtitle ...</h1>';
		
	//} // end get_editor_default_content
	
	
	protected function the_item( $settings , $content , $is_editor ){
		
		$class = apply_filters( 'tkd_builder_item_class' , $this->get_item_classes( $settings , array( 'tkd-subtitle' ) ), $this , $settings );
		$style = apply_filters( 'tkd_builder_item_style' , $this->get_item_style( $settings ), $this , $settings );
		
		if ( ! empty( $settings['class'] ) ) $class[] = $settings['class'];
		
		if ( $is_editor && empty( $settings['title'] ) ){
			
			$settings['title'] = 'Add Subtitle..';
			
		} // end if
		
		$tag = ( ! empty( $settings['tag'] ) ) ? $settings['tag'] : '';
		
		$html = '<' . $tag . ' class="' . implode( ' ' , $class ) . '"  style="' . implode( ';' , $style ) . '">' . $settings['title'] . '</' . $tag . '>';
		
		return $html;
		
	} // end the_item
	
	
	protected function the_form( $settings , $content ){
		
		$options = array( 
			'H1' => 'h1',
			'H2' => 'h2',
			'H3' => 'h3',
			'H4' => 'h4',
			'H5' => 'h5',
			'Bold' => 'strong',
			'none' => 'span',
			);
		
		$form = $this->forms->get_text_field( $this->get_input_name('title') , $settings['title'] , array('placeholder' => 'Subtitle Text') ); 
		
		$form .= $this->forms->get_select_field( $this->get_input_name('tag') , $options , $settings['tag'] , array('label' => 'Subtitle Size:' , 'class' => 'inline-label' ) );
		
		$form .= $this->form_fields->get_field( 
			'checkbox', 
			$this->get_input_name( 'text_transform' ), 
			$args = array( 
				'value' => 'uppercase',
				'label' => 'Make Uppercase',
				'current_value' =>  $settings['text_transform'],
			) 
		);
		
		$form = array( 
			'Basic' 			=> $form, 
			'Layout & Spacing' 	=> $this->form_fields->get_control_set( 'layout' , $settings, $this->get_input_name() ), 
			'Text' 				=> $this->form_fields->get_control_set( 'text' , $settings, $this->get_input_name() ), 
		);
		
		
		return $form;
		
	} // end the_form
	
	
	protected function clean_settings( $settings ){
		
		$clean = array();
		
		$fields = array(
			'title' 	=> 'text',
			'tag' 		=> 'text',
			'text_transform' => 'text',
		);
		
		
		foreach( $fields as $key => $type ){
			
			if ( ! empty( $settings[ $key ] ) ){
				
				$clean[ $key ] = $this->form_fields->sanitize( $settings[ $key ] , $type );
				
			} // end if
			
		} // end foreach
		
		
		$this->form_fields->sanitize_control_set( $clean, 'text' , $settings );
		$this->form_fields->sanitize_control_set( $clean, 'layout' , $settings );
		
		return $clean;
		
	} // end clean_settings
	
	
}