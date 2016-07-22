<?php

class TKD_Post_Editor {
	
	protected $item_factory;
	
	protected $forms;
	
	public function __construct( $item_factory , $forms ){
		
		$this->item_factory = $item_factory;
		
		$this->forms = $forms;
		
	} // end __construct
	
	
	public function init(){
		
		add_action( 'edit_form_after_title' , array( $this , 'the_editor' ), 99 );
		
		add_action( 'admin_enqueue_scripts', array( $this , 'add_admin_scripts' ), 11, 1 );
		
	} // end init
	
	
	public function the_editor( $post ){
		
		echo '<div id="tkd_editor">';
		
		$items = $this->item_factory->get_items_from_content( $post->post_content , array( 'row' ) , 'row' );
		
		echo $this->the_layout_editor( $post , $items );
		
		echo $this->the_settings_editor( $post , $items );
		
		echo '</div>';
		
	} // end the_editor
	
	
	public function the_layout_editor( $post , $items){
		
		$input_name = $this->forms->get_prefix() . '[layout][items]';
		
		$child_ids = array();
		
		foreach( $items as $item ){
			
			$child_ids[] = $item->get_id();
			
		} // end foreach
		
		$items_html = $this->get_editor_items_html( $items );
		
		$layouts = $this->item_factory->get_layouts();
		
		$layouts_html = '';
		
		foreach( $layouts as $class => $info ){
			
			$layouts_html .= $this->get_add_layout_item( 'row' , $info['label'] , $class , $info['columns'] , array( 'layout' => $class ) );
			
		} // end foreach
		
		ob_start();
		
		include plugin_dir_path( dirname( __FILE__ ) ) . 'css/editor-item.css';
		
		$css = ob_get_clean();
		
		$css .= file_get_contents( 'http://layoutbuilder.tektondev.com/?tkd-get-editor-css=true' );
		
		ob_start();
		
		include plugin_dir_path( dirname( __FILE__ ) ) . 'inc/tkd-layout-editor.php';
		
		return ob_get_clean();
		
	} // end the_layout_editor
	
	
	public function the_settings_editor( $post , $items ){
		
		$fomrs = '';
		
		$forms_html = $this->get_items_forms( $items , false );
		
		$forms_html .= $this->get_empty_text_forms();
		
		ob_start();
		
		include plugin_dir_path( dirname( __FILE__ ) ) . 'inc/tkd-settings-editor.php';
			
		return ob_get_clean();
		
		
	} // end the_settings_editor
	
	
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
	
	
	public function get_items_forms( $items , $as_array = true ){
		
		$fa = array();
		
		foreach( $items as $item ){
			
			if ( $children = $item->get_children() ){
				
				$cha = $this->get_items_forms( $children );
				
				$fa = array_merge( $fa , $cha );
				
			} // end if
			
			$fa[ $item->get_id() ] = array(
				'type' => $item->get_slug(),
				'html' => $item->get_form_html(),
			);
			
		} // end foreach
		
		if ( $as_array ){
			
			return $fa;
			
		} else {
			
			$form_html = '';
			
			foreach( $fa as $id => $form ){
				
				$form_html .= $form['html'];
				
			} // end foreach
			
			return $form_html;
			
		}// end if
		
	} // end get_forms_array
	
	public function get_empty_text_forms(){
		
		$forms = '';
		
		for( $i = 0; $i < 10 ; $i++ ){
			
			$item = $this->item_factory->get_item( 'text' );
			
			$item_form = $item->get_form_html( false );
			
			$forms .= $this->forms->get_modal( $item_form , $args = array( 'size' => $item->get_modal_size() , 'class' => 'empty-editor' , 'action' => 'tkd-edited-update-item-action' ) );
			
		} // end for
		
		return $forms;
		
	} //end get_empty_wp_editors
	
	
	public function get_add_item_form(){
		
		
	} // end function get_add_item_form
	
	
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