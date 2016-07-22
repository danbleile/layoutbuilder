<?php

class TKD_Item_Column extends TKD_Item {
	
	protected $slug = 'column';
	
	protected $title = 'Column';
	
	protected $allowed_childen = 'content';
	
	protected $default_children = 'text';
	
	protected function the_item( $settings , $content ){

		
		$class = array( 'tkd-column' , 'tkd-column-' . $this->get_index_text( $this->get_index() ) );
		
		ob_start();
		
		include plugin_dir_path( dirname( __FILE__ ) ) . 'inc/inc-tkd-item-column.php';
		
		$html = ob_get_clean();
		
		return $html;
		
	} // end the_item
	
	
	
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