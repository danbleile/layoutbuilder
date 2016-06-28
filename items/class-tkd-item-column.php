<?php

class TKD_Item_Column extends TKD_Item {
	
	protected $slug = 'column';
	
	protected $allowed_childen = 'column-items';
	
	protected $default_children = 'text';
	
	
	protected function the_editor( $settings , $content ){
		
		$class = array( 'tkd-builder-item' );
		
		ob_start();
		
		include plugin_dir_path( dirname( __FILE__ ) ) . 'inc/tkd-item-column.php';
		
		return ob_get_clean();
		
	} // end the_editor
	
}