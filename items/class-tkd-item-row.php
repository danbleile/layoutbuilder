<?php

class TKD_Item_Row extends TKD_Item {
	
	protected $slug = 'row';
	
	protected $title = 'Row';
	
	protected $allowed_childen = array('column');
	
	protected $default_children = 'column';
	
	protected $default_settings = array(
		'layout' => 'single',
	);
	
	
	protected function the_item( $settings , $content ){
		
		if ( empty( $settings['layout'] ) ) $settings['layout'] = 'single';
		
		$class = array( 'tkd-row' , 'tkd-layout-' . $settings['layout'] );
		
		ob_start();
		
		include plugin_dir_path( dirname( __FILE__ ) ) . 'inc/inc-tkd-item-row.php';
		
		$html = ob_get_clean();
		
		return $html;
		
	} // end the_item
	
	
	protected function the_editor( $settings , $content ){
		
		if ( empty( $settings['layout'] ) ) $settings['layout'] = 'single';
		
		$class = array( 'tkd-builder-item' , 'tkd-' . $this->get_slug() , $this->get_setting('layout') );
		
		$id = $this->get_id();
		
		$child_ids = implode( ',' , $this->get_child_ids() );
		
		$input_name = $this->get_input_name();
		
		ob_start();
		
		include plugin_dir_path( dirname( __FILE__ ) ) . 'inc/tkd-item-row.php';
		
		return ob_get_clean();
		
	} // end the_editor
	
	
	protected function the_form( $settings , $content ){
		
		$html = $this->forms->get_text_field( $this->get_input_name( 'layout' ) , $settings['layout'] );
		
		return $html;
		
	} // end the_form
	
	protected function clean_settings( $settings ){
		
		$clean = array();
		
		if ( isset( $settings['layout'] ) ) {
			
			$clean['layout'] = sanitize_text_field( $settings['layout'] );
			
		} // end if
		
		return $clean;
		
	} // end clean_settings
	
	
}