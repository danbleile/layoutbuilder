<?php

require_once dirname(__FILE__). '/class-lb-form.php';

abstract class LB_Item extends LB_Form {
	
	protected $prefix = '_layout_builder';
	
	protected $content_prefix = '_content_';
	
	protected $slug;
	
	protected $id;
	
	protected $name;
	
	protected $settings = array();
	
	protected $content = '';
	
	protected $allow_children = array();
	
	protected $children = array();
	
	protected $default_child = false;
	
	protected $fields = array();
	
	public function get_prefix(){
		
		return $this->prefix;
		
	}
	
	public function get_content_prefix(){
		
		return $this->content_prefix;
		
	}
	
	public function get_slug(){
		
		return $this->slug;
		
	}
	
	public function get_name(){
		
		return $this->name;
		
	}
	
	public function get_id(){
		
		return $this->id;
		
	}
	
	public function get_children(){
		
		return $this->children;
		
	}
	
	
	public function get_allow_children(){
		
		return $this->allow_children;
		
	}
	
	public function get_default_child(){
		
		return $this->default_child;
		
	}
	
	
	public function get_settings( $setting = false ){
		
		$settings = $this->settings;
		
		if ( $setting ){
			
			if ( array_key_exists( $setting , $settings ) ){
				
				return $settings[ $setting ];
				
			} else {
				
				return '';
				
			} // end if
			
		} else {
			
			return $settings;
			
		} // end if
		
	}
	
	
	public function get_content(){
		
		return $this->content;
		
	}
	
	public function get_fields(){
		
		return $this->fields;
		
	}
	
	public function set_id( $id ){
		
		$this->id = $id;
		
	}
	
	
	public function set_children( $children ){
		
		$this->children = $children;
		
	}
	
	
	public function set_item( $settings, $content, $id = false , $clean = false ){
		
		$this->settings = $this->get_default_settings( $settings );
		
		$this->content = $content;
		
		if ( $id ){
			
			$this->id = $id;
			
		} else {
			
			$this->id = uniqid( $this->get_slug() . '_' );
			
		}
		
	} // end set_item
	
	public function get_editor_html_recursive(){
		
		$html = '';
		
		$editor_content = $this->get_editor_content();
		
		if ( method_exists( $this , 'get_editor_html' ) ) {
			
			$html .= $this->get_editor_html( $editor_content );
			
		} else {
			
			$html .= $this->get_editor_content_item_html( $this->get_content() );
			
		}// end if
		
		return $html;
		
	} // end get_editor_html
	
	/*public function get_item_form_html(){
		
		$html = '';
		
		if ( method_exists( $this , 'the_form' ) ){
			
			$form = $this->the_form( $this->get_settings() , $this->get_content() );
			
			if ( ! is_array( $form ) ) {
				
				$form = array( 'Basic' => $form );
				
			} // end if
			
			$html .= $this->get_form_html( $this->get_id() , $form , 'Edit Item' , 'do-edit-item-action' , 'Done' );
			
			
		} // end if
		
		return $html;
		
	}*/
	
	public function get_item_form_array(){
		
		if ( method_exists( $this , 'the_form' ) ){
			
			$form = $this->the_form( $this->get_settings() , $this->get_content() );
			
			if ( ! is_array( $form ) ) {
				
				$form = array( 'Basic' => $form );
				
			} // end if
			
			$form_array = array(
				'id'      => 'form-' . $this->get_id(),
				'item_id' => $this->get_id(),
				'size'    => 'full',
				'form'    => $form,
				'type'    => $this->get_slug(),
			);
			
			return $form_array;
			
		} else {
			
			return array();
			
		} // end if
		
		
	} // end get_item_form_array
	
	
	public function get_editor_content(){
		
		$editor_content = '';
		
		if ( $this->get_allow_children() ){
			
			if ( $children = $this->get_children() ){
				
				foreach( $children as $child ){
					
					$editor_content .= $child->get_editor_html_recursive();
					
				} // end foreach
				
			} // end if
			
		} else {
			
			$editor_content = $this->get_content();
			
		} // end if
		
		return $editor_content;
		
	}
	
	
	public function get_default_settings( $settings ){
		
		if ( ! is_array( $settings ) ){
			
			$settings = array();
			
		} // end if
		
		foreach( $this->get_fields() as $key => $default ){
			
			if ( ! array_key_exists( $key , $settings ) ){
				
				$settings[ $key ] = $default;
				
			} // end if
			
		} // end foreach
		
		return $settings;
		
	} // end set_default_settings
	
	
	public function get_child_ids(){
		
		$ids = array();
		
		foreach( $this->get_children() as $child ){
			
			$ids[] = $child->get_id();
			
		} // end foreach
		
		return $ids;
		
	} // end get_child_ids
	
	
	public function get_editor_content_item_html( $editor_content ){
		
		$html = '<div id="' . $this->get_id() . '" class="layout-item content-item text">';
		
			$html .= '<header>';
			
				$html .= '<div class="item-title">' . $this->get_name() . '</div>';
			
				$html .= '<a href="#" class="action-remove-item">Remove</a>';
				
			$html .= '</header>';
			
			$html .= '<div class="item-content">';
			
				$html .= '<iframe class="content-iframe" src="about:blank" frameborder="0" scrolling="no"></iframe>';
				
				$html .= '<textarea class="content-textarea">' . apply_filters( 'tk_the_content' , $editor_content ) . '</textarea>';
				
				$html .= '<input type="hidden" name="_content_' . $this->get_id() . '" value="' . $editor_content . '" />';
				
				$html .= '<a href="#" class="action-edit-item"></a>';
			
			$html .= '</div>';
		
		$html .= '</div>';
		
		return $html;
		
	}
	
	
	/*public function get_forms_array_recursive(){
		
		$forms = array();
		
		$form_html = $this->get_item_form_html();
		
		if ( $form_html ) {
			
			$forms[ $this->get_id() ] = $form_html;
			
		} // end if
		
		if ( $children = $this->get_children() ){
			
			foreach( $children as $child ){
				
				$forms = array_merge( $forms , $child->get_forms_array_recursive() );
				
			} // end foreach
			
		} // end if
		
		return $forms;
		
	} // end get_forms_array_recursive*/
	
	
	/**
	 * Check children before adding to item 
	 *
	 * @param array $children Current Children
	 * @param LB_Items_Factory $item_factory Instance of LB_Items_Factory
	 * @return array Children of item
	 */
	public function check_children( $children , $item_factory ){
		
		return $children;
		
	} // end check_children
	
	/**
	 * Set settings value
	 *
	 * @param string $key Settings key
	 * @param mixed $value $settings value
	 */
	 public function set_setting( $key , $value ){
		 
		 $this->settings[ $key ] = $value;
		 
	 } // end set_setting
	 
	 /***
	  * Get input name for use in the form
	  *
	  * @param string $key Name key to use
	  * @param bool $is_setting If is a settings field
	  */
	 public function get_input_name( $key , $is_setting = true ){
		 
		 $input = $this->get_prefix() . '[' . $this->get_id() . ']';
		 
		 if ( $is_setting ){
			 
			 $input .= '[settings]';
			 
		 } // end if
		 
		 $input .= '[' . $key . ']';
		 
		 return $input;
		 
	 } // end get_input_name
	 
	
}