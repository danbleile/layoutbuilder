<?php

class TKD_Item_Row extends TKD_Item {
	
	protected $slug = 'row';
	
	protected $title = 'Row';
	
	protected $allowed_childen = array('column');
	
	protected $default_children = 'column';
	
	
	protected function the_editor( $settings , $content ){
		
		$class = array( 'tkd-builder-item' , 'tkd-' . $this->get_slug() , $this->get_settings('layout') );
		
		$id = $this->get_id();
		
		$child_ids = implode( ',' , $this->get_child_ids() );
		
		$input_name = $this->get_input_name();
		
		ob_start();
		
		include plugin_dir_path( dirname( __FILE__ ) ) . 'inc/tkd-item-row.php';
		
		return ob_get_clean();
		
	} // end the_editor
	
	
}