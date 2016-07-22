<?php

class TKD_Item_Column extends TKD_Item {
	
	protected $slug = 'column';
	
	protected $title = 'Column';
	
	protected $allowed_childen = 'column-items';
	
	protected $default_children = 'text';
	
	
	protected function the_editor( $settings , $content ){
		
		$class = array( 
			'tkd-builder-item', 
			'tkd-' . $this->get_slug() ,
			'column-' . $this->get_index_text( $this->get_index() ),
			);
		
		$id = $this->get_id();
		
		$child_ids = implode( ',' , $this->get_child_ids() );
		
		$input_name = $this->get_input_name();
		
		ob_start();
		
		include plugin_dir_path( dirname( __FILE__ ) ) . 'inc/tkd-item-column.php';
		
		return ob_get_clean();
		
	} // end the_editor
	
}