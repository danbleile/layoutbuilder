<?php

class LB_Editor {
	
	protected $options;
	
	protected $items_factory;
	
	protected $shortcode_factory;
	
	public function __construct( $options , $items_factory , $shortcode_factory ){
		
		$this->options = $options;
		
		$this->items_factory = $items_factory;
		
		$this->shortcode_factory = $shortcode_factory;
		
	} // end __construct
	
	
	public function the_editor_html( $post ){
		
		$items = $this->items_factory->get_content_items_recursive( $post->post_content , array( 'row' , 'pagebreak' ) , 'row' );
		
		$html = '<div id="layout-builder">';
		
			$html .= $this->get_layout_editor_html( $items ); 
			
			$html .= $this->get_form_editor_html( $items ); 
		
		$html .= '</div>';
		
		echo $html;
		
	}
	
	
	public function get_layout_editor_html( $items ){
		
		$html = '<section id="lb-layout-editor">';
		
			$html .= '<div class="child-items">';
		
				foreach( $items as $item ){
					
					$html .= $item->get_editor_html_recursive();
					
				} // end foreach
			
			$html .= '</div>';
			
			$ids = $this->get_layout_editor_items( $items );
			
			$html .= '<input class="lb-child-items" type="text" name="_layout_builder[layout]" value="' . implode(',' , $ids )  . '" />';
		
		$html .= '</section>';
		
		return $html;
		
	} // end get_layout_editor_html
	
	
	public function get_form_editor_html( $items ){
		
		$forms = array();
		
		foreach( $items as $item ){
			
			$forms = array_merge( $forms , $item->get_forms_array_recursive() );
			
		} // end foreach
		
		$html = '<section id="lb-form-editor">';
		
		foreach( $forms as $form_id => $form_html ){
			
			$html .= $this->get_wrap_modal_html( $form_html , 'Edit Item' , 'action-item-edited');
			
		} // end foreach
		
		$html .= '</section>';
		
		return $html;
		
	}
	
	
	protected function get_layout_editor_items( $items ){
		
		$ids = array();
		
		foreach( $items as $item ){
			
			$ids[] = $item->get_id();
			
		} // end foreach
		
		return $ids;
		
	} // end get_layout_editor_items
	
	
	protected function get_wrap_modal_html( $form_html , $title = '' , $action = '' ){
		
		$modal = '<div class="layout-builder-modal-wrap">';
		
			$modal .= '<div class="layout-builder-form layout-builder-modal">';
			
				$modal .= '<header><div class="form-title">' . $title . '</div><a href="#" class="action-close-modal">Close</a></header>';
				
					$modal .= '<div class="layout-builder-modal-content">';
				
						$modal .= $form_html;
					
					$modal .= '</div>';
				
				$modal .= '<footer></footer>';
			
			$modal .= '</div>';
		
		$modal .= '</div>';
		
		return $modal;
		
	} // end get_wrap_modal_html
	
	
	public function add_editor_scripts(){
		
		wp_enqueue_style( 'layout_builder_admin_css', plugin_dir_url( dirname( __FILE__ ) ) . 'css/admin.css' , false , '0.0.1' );
		
		wp_enqueue_script( 'layout_builder_admin_js', plugin_dir_url( dirname( __FILE__ ) ) . 'js/admin.js' , array('jquery-ui-draggable','jquery-ui-droppable','jquery-ui-sortable') , '0.0.1' , true );
		
	}
	
	
}