<?php

class TKD_Item_Video extends TKD_Item {
	
	protected $slug = 'tkdvideo';
	
	protected $title = 'Video';
	
	protected $desc = 'Add Video Embed.';
	
	protected $default_settings = array(
		'csshook' 		=> '',
		'video_src'   	=> '',
		'cover_image'	=> '',
	);
	
	protected $modal_size = 'small';
	
	
	//protected function get_editor_default_content(){
		
		//return '<h1 class="tkd-editor-default">Add Subtitle ...</h1>';
		
	//} // end get_editor_default_content
	
	
	protected function the_item( $settings , $content , $is_editor ){
		
		$html = '';
		
		if ( $settings['video_src'] ){
			
			$html .= '<div class="tkd-video-wrapper ration-16-9">';
		
			$vid_id = uniqid ( 'video_' );
			$embed = wp_oembed_get( $settings['video_src'] );
			
			$html = $embed;
			
			$html .= '</div>';
			
		
		} // end if
		
		/*$class = apply_filters( 'tkd_builder_item_class' , $this->get_item_classes( $settings , array( 'tkd-subtitle' ) ), $this , $settings );;
		
		if ( ! empty( $settings['class'] ) ) $class[] = $settings['class'];
		
		if ( $is_editor && empty( $settings['title'] ) ){
			
			$settings['title'] = 'Add Subtitle..';
			
		} // end if
		
		$html = '<' . $settings['tag'] . ' class="' . implode( ' ' , $class ) . '">' . $settings['title'] . '</' . $settings['tag'] . '>';*/
		
		
		return $html;
		
	} // end the_item
	
	
	protected function the_form( $settings , $content ){
		
		/*$options = array( 
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
			$this->get_input_name( 'align_center' ), 
			$args = array( 
				'value' => 1,
				'label' => 'Align Center',
				'current_value' =>  $settings['align_center'],
			) 
		);*/
		
		$html = $this->form_fields->get_field( 
			'text', 
			$this->get_input_name( 'video_src' ), 
			$args = array( 
				'value' => $settings['video_src'],
				'label' => 'Video Link', 
			) 
		);
		
		$html .= $this->form_fields->get_field( 
			'text', 
			$this->get_input_name( 'cover_image' ), 
			$args = array( 
				'value' => $settings['cover_image'],
				'label' => 'Cover Image', 
			) 
		);
		
		return $html;
		
	} // end the_form
	
	
	protected function clean_settings( $settings ){
		
		$clean = array();
		
			$clean['cover_image'] = sanitize_text_field( $settings['cover_image'] );
			
			$clean['video_src'] = sanitize_text_field( $settings['video_src'] );
		
		return $clean;
		
		/*$clean = array();
		
		if ( isset( $settings['title'] ) ) {
			
			$clean['title'] = sanitize_text_field( $settings['title'] );
			
		} // end if
		
		if ( isset( $settings['tag'] ) ) {
			
			$clean['tag'] = sanitize_text_field( $settings['tag'] );
			
		} // end if
		
		if ( isset( $settings['align_center'] ) ) {
			
			$clean['align_center'] = sanitize_text_field( $settings['align_center'] );
			
		} // end if
		
		return $clean;*/
		
	} // end clean_settings
	
	
}