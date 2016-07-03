<?php

class TKD_Post_Editor {
	
	protected $item_factory;
	
	public function __construct( $item_factory ){
		
		$this->item_factory = $item_factory;
		
	} // end __construct
	
	
	public function init(){
		
		add_action( 'edit_form_after_title' , array( $this , 'the_editor' ), 99 );
		
		add_action( 'admin_enqueue_scripts', array( $this , 'add_admin_scripts' ), 11, 1 );
		
	} // end init
	
	
	public function the_editor( $post ){
		
		echo '<div id="tkd_editor">';
		
		$items = $this->item_factory->get_items_from_content( $post->post_content , array( 'row' ) , 'row' );
		
		echo $this->the_layout_editor( $post , $items );
		
		echo '</div>';
		
	} // end the_editor
	
	
	public function the_layout_editor( $post , $items){
		
		$items_html = $this->get_editor_items_html( $items );
		
		$layouts = $this->item_factory->get_layouts();
		
		$layouts_html = '';
		
		foreach( $layouts as $class => $info ){
			
			$layouts_html .= $this->get_add_layout_item( 'row' , $info['label'] , $class , $info['columns'] , array( 'layout' => $class ) );
			
		} // end foreach
		
		ob_start();
		
		include plugin_dir_path( dirname( __FILE__ ) ) . 'inc/tkd-layout-editor.php';
		
		return ob_get_clean();
		
	} // end the_layout_editor
	
	
	public function get_add_layout_item( $slug , $label, $class , $columns = 0, $settings = array(), $action = 'tkd_get_part'){
		
		ob_start();
		
		include plugin_dir_path( dirname( __FILE__ ) ) . 'inc/tkd-add-layout-item.php';
			
		return ob_get_clean();
		
	} // end get_add_row_item
	
	
	public function get_editor_items_html( $items ){
		
		$html = '';
		
		foreach( $items as $item ){
			
			if ( $children = $item->get_children() ){
				
				$inner_content = $this->get_editor_items_html( $children );
				
			} else {
				
				$inner_content = $item->get_editor_content();
				
			} // end if
			
			$html .= $item->get_editor_html( $inner_content );
			
		} // end foreach
		
		return $html;
		
	} // end get_editor_items_html
	
	
	/**
	  * Add admin scripts
	  */
	 public function add_admin_scripts( $hook ){
		 
		 if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
					 
			/*wp_enqueue_script(  
				'wovax_mm_selector_js', 
				plugin_dir_url(  __FILE__  ) .'js/admin-script.js' , 
				array('jquery-ui-draggable','jquery-ui-droppable','jquery-ui-sortable') , 
				WOVAX_Music_Manager::$version , true );*/
				
			wp_enqueue_style( 
				'tkd_editor_admin_style' , 
				plugin_dir_url( dirname( __FILE__ ) ) . 'css/admin-style.css', 
				array() , 
				TKD_Layout_Builder::$version 
				);
			
			wp_enqueue_script( 
				'tkd_editor_admin_js', 
				plugin_dir_url( dirname( __FILE__ ) ) . 'js/editor.js', 
				array('jquery-ui-draggable','jquery-ui-droppable','jquery-ui-sortable'), 
				TKD_Layout_Builder::$version, 
				true 
				);
			
		} // end if
		 
	 } // end add_admin_scripts
	
} // end TKD_Post_Editor