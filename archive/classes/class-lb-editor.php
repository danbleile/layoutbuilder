<?php

class LB_Editor {
	
	protected $options;
	
	protected $items_factory;
	
	protected $form;
	
	public function __construct( $options , $items_factory , $form ){
		
		$this->options = $options;
		
		$this->items_factory = $items_factory;
		
		$this->form = $form;
		
	} // end __construct
	
	
	public function init(){
	} // end init
	
	
	public function the_editor_html( $post ){
		
		$items = $this->items_factory->get_children_recursive( $post->post_content , array( 'row' , 'pagebreak' ) , 'row' );
		
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
			
			$html .= $this->get_add_row_html();
		
		$html .= '</section>';
		
		return $html;
		
	} // end get_layout_editor_html
	
	
	public function get_form_editor_html( $items ){
		
		$forms = array();
		
		foreach( $items as $item ){
			
			//$forms = array_merge( $forms , $item->get_forms_array_recursive() );
			
		} // end foreach
		
		$html = '<section id="lb-form-editor">';
		
		$forms = $this->get_items_forms_recursive( $items );
		
		foreach( $forms as $form_array ){
			
			$html .= $this->get_form_html( $form_array );
			
		} // end foreach
		
		for( $i = 0; $i < 10; $i++ ){
			
			$item = $this->items_factory->get_item('text');
			
			$f_array = $item->get_item_form_array();
			
			$html .= $this->get_form_html( $f_array , 'inactive-editor' );
			
		} // end for
		
		$html .= '</section>';
		
		return $html;
		
	}
	
	/**
	 * Get the html for the form
	 *
	 * @param array $form_array Array for the form
	 * @retrun string HTML
	 */
	public function get_form_html( $form_array , $class = '' ){
		
		if ( ! empty( $form_array[ 'type'] ) ){
			
			$class .= ' tk-form-type-' . $form_array[ 'type'];
			
		};
			
		$html = $this->form->get_form_html( $form_array['id'] , $form_array['form'] , 'Edit Item' , 'do-edit-item-action close-modal-action' , 'Done' , $class );
			
		return $this->form->get_form_modal( $html );
		
	} // end get_form_html
	
	
	/**
	 * Get all item forms
	 * 
	 * @param array $items Array of Item objects
	 * @return array Forms array
	 */
	public function get_items_forms_recursive( $items ){
		
		$forms = array();
		
		foreach( $items as $item ){
			
			$form = $item->get_item_form_array();
			
			if ( $form ){
				
				$forms[] = $form;
				
			} // end if
			
			$child_forms = $this->get_items_forms_recursive( $item->get_children() );
			
			if ( $child_forms ){
				
				$forms = array_merge( $forms , $child_forms );
				
			} // end if
			
			
		} // end foreach
		
		return $forms;
		
	} // end get_items_forms_recursive
	
	
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
	
	
	/**
	 * Get the add row form html
	 *
	 * @return string HTML for the add row form
	 */
	protected function get_add_row_html(){
		
		$col = array('zero','one','two','three','four','five','six','seven','eight','nine','ten');
		
		$layouts = $this->items_factory->get_layouts();
		
		ob_start();
		
		include plugin_dir_path( dirname(__FILE__) ) . 'inc/editor-add-row.php';
		
		return ob_get_clean();
		
	} // end get_add_row_html
	
	
	public function add_editor_scripts(){
		
		wp_enqueue_style( 'layout_builder_admin_css', plugin_dir_url( dirname( __FILE__ ) ) . 'css/admin.css' , false , '0.0.1' );
		
		wp_enqueue_script( 'layout_builder_admin_js', plugin_dir_url( dirname( __FILE__ ) ) . 'js/admin.js' , array('jquery-ui-draggable','jquery-ui-droppable','jquery-ui-sortable') , '0.0.1' , true );
		
	}
	
	
}