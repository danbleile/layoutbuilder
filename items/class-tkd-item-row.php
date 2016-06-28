<?php

class TKD_Item_Row extends TKD_Item {
	
	protected $slug = 'row';
	
	protected $allowed_childen = array('column');
	
	protected $default_children = 'column';
	
	
	protected function the_editor( $settings , $content ){
		
		$class = array( 'tkd-builder-item' );
		
		ob_start();
		
		include plugin_dir_path( dirname( __FILE__ ) ) . 'inc/tkd-item-row.php';
		
		return ob_get_clean();
		
	} // end the_editor
	
	
}