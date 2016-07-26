<?php

class TKD_Item_Subtitle extends TKD_Item {
	
	protected $slug = 'subtitle';
	
	protected $title = 'Subtitle';
	
	protected $desc = 'Add Subtitle to content.';
	
	protected $default_settings = array(
		'csshook' => '',
		'title'   => '',
		'tag'     => 'h3',
	);
	
	protected $modal_size = 'small';
	
	
	//protected function get_editor_default_content(){
		
		//return '<h1 class="tkd-editor-default">Add Subtitle ...</h1>';
		
	//} // end get_editor_default_content
	
	
	protected function the_item( $settings , $content , $is_editor ){
		
		$class = array( 'tkd-subtitle' );
		
		if ( ! empty( $settings['class'] ) ) $class[] = $settings['class'];
		
		if ( $is_editor && empty( $settings['title'] ) ){
			
			$settings['title'] = 'Add Subtitle..';
			
		} // end if
		
		$html = '<' . $settings['tag'] . ' class="' . implode( $class ) . '">' . $settings['title'] . '</' . $settings['tag'] . '>';
		
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