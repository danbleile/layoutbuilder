<?php
abstract class TKD_Item {
	
	protected $forms;
	
	protected $id;
	
	protected $slug;
	
	protected $title;
	
	protected $desc = '';
	
	protected $settings;
	
	protected $default_settings = array();
	
	protected $content;
	
	protected $index = 0;
	
	protected $is_editor;
	
	protected $allowed_childen = array();
	
	protected $default_children = false;
	
	protected $children = array();
	
	protected $modal_size = 'medium';
	
	/* ----------------------------------------------*/
	
	public function get_id(){ return $this->id; } // end get_id
	
	public function get_slug(){ return $this->slug; } // end get_slug
	
	public function get_title(){ return $this->title; } // end get_slug
	
	public function get_desc(){ return $this->desc; } // end get_slug
	
	public function get_content(){ return $this->content; } // end get_content
	
	public function get_settings(){ return $this->settings; } // end get_settings
	
	public function get_default_settings(){ return $this->default_settings; } // end get_settings
	
	public function get_index(){ return $this->index; } // end get_settings
	public function set_index( $index ) { $this->index = $index; }
	
	public function get_allowed_children(){ return $this->allowed_childen; }
	
	public function get_default_children(){ return $this->default_children; }
	
	public function get_children(){ return $this->children; }
	
	public function get_modal_size(){ return $this->modal_size; }
	
	public function get_editor_content(){ return $this->get_content(); }
	
	/* ----------------------------------------------*/
	
	public function __construct( $forms , $is_editor = false  ){
		
		$this->forms = $forms;
		
		$this->is_editor = $is_editor;
		
	} // end __construct
	
	
	/* ----------------------------------------------*/
	
	public function set_item( $settings = array() , $content = '' , $clean_item = false, $apply_defaults = true ){
		
		$this->set_id();
		
		$settings = $this->get_the_item_settings( $settings , $clean_item );
		
		$this->set_settings( $settings );
		
		$this->set_content( $content );
		
	} // end set_item
	
	
	public function set_settings( $settings ){
		
		$this->settings = $settings;
		
	} // end set_settings
	
	
	public function set_content( $content ){
		
		$this->content = $content;
		
	} // end set_content
	
	
	public function set_children( $children ){
		
		$this->children = $children;
		
	} // end set_children
	
	
	public function set_id( $id = false ){
		
		if ( $id ){
			
			$this->id = $id;
			
		} else {
			
			$this->id = uniqid( $this->get_slug() . '_' );
			
		} // end if
		
	} // end set_id
	
	
	/* ----------------------------------------------*/
	
	public function get_setting( $key ){
		
		$settings = $this->get_settings();
	
		if ( array_key_exists( $key , $settings ) ){
			
			return $settings[ $key ];
			
		} else {
			
			return '';
			
		} // end if
		
	} // end get_settings
	
	
	public function get_item_html(){
		
		$html = '';
		
		if ( method_exists( $this , 'the_item' ) ){
			
			$html .= $this->the_item( $this->get_settings() , $this->get_content() );
			
		} // end if
		
		return $html;
		
	} // end get_item_html
	
	
	public function get_editor_html( $inner_content ){
		
		if ( method_exists( $this , 'the_editor' ) ){
			
			$html = $this->the_editor( $this->get_settings(), $inner_content );
			
		} else {
			
			$content = apply_filters( 'tkd_the_content' , $this->get_content() );
			
			if ( ! $content  && method_exists( $this , 'get_editor_default_content' ) ){
				
				$content = $this->get_editor_default_content();
				
			} // end if
			
			$title = $this->get_title();
			
			$class = array( 'tkd-builder-item' , 'tkd-' . $this->get_slug() , 'tkd-builder-content-item' );
			
			$id = $this->get_id();
			
			ob_start();
			
			include plugin_dir_path( dirname( __FILE__ ) ) . 'inc/tkd-content-item.php';
			
			$html = ob_get_clean();
			
		} // end if
		
		return $html;
		
	} // end get_editor_html
	
	
	public function get_form_html( $as_modal = true ){
		
		$html = '';
		
		if ( method_exists( $this , 'the_form' ) ){
			
			$form = $this->the_form( $this->get_settings() , $this->get_content() );
			
			if ( ! is_array( $form ) ){
				
				$form = array( 'Basic' => $form );
				
			} // end if
			
			$hidden_fields = array(
				'tkd_item_id'   => $this->get_id(),
				'tkd_item_slug' => $this->get_slug(),
			);
			
			$html .= $this->forms->get_tab_form( 'tkd-form-' . $this->get_id() , array_keys( $form ) , array_values( $form ) , array( 'hidden_fields' => $hidden_fields ) );

			
		} // end if
		
		if ( $as_modal ){
			
			$html = $this->forms->get_modal( $html , $args = array( 'size' => $this->get_modal_size() , 'action' => 'tkd-edited-update-item-action' ) );
			
		} // end if
		
		return $html;
		
	} // end get_form_html
	
	
	public function get_input_name( $key = false , $is_setting = true ){
		
		$inpt = $this->forms->get_prefix();
		
		$inpt .= '[' . $this->get_id() . ']';
		
		if ( $key ){
			
			if ( $is_setting ){
				
				$inpt .= '[settings]';
				
			} // end if
			
			$inpt .= '[' . $key . ']';
			
		} // end if
		
		return $inpt;
		
	} // end get_input_name
	
	
	public function get_child_ids(){
		
		$child_ids = array();
		
		$children = $this->get_children();
		
		foreach( $children as $child ){
			
			$child_ids[] = $child->get_id();
			
		} // end foreach
		
		return $child_ids;
		
	} // end get_child_ids
	
	
	public function get_index_text( $index , $offset = true ){
		
		$values = array('zero','one','two','three','four','five','six','seven','eight','nine','ten','eleven','twelve');
		
		if ( $offset ) {
			
			$index++;
			
		} // end if
		
		return $values[ $index ];
		
	} // end get_index_text
	
	

/***************
-----------------------------------------
***************/

	public function get_the_item( $is_editor = false ){
		
		$html = '';
		
		if ( method_exists( $this , 'the_item' ) ){
			
			$html .= $this->the_item( $this->get_settings() , $this->get_content() , $is_editor );
			
		} // end if
		
		return $html;
		
	} // end 
	
	
	public function get_the_item_shortcode( ){
		
		$delim = '"';
		
		$content = '';
		
		$settings_array = array();
		
		$settings = $this->get_settings();
		
		$children = $this->get_children();
		
		if ( ! empty( $children ) ){
			
			foreach( $children as $child ){
				
				$content .= $child->get_the_item_shortcode();
				
			} // end foreach
			
		} else {
			
			$content = $this->get_content();
			
		} // end if
		
		if ( ! empty( $settings ) ){
			
			foreach( $settings as $key => $value ){
				
				if ( is_array( $value ) ){
					
					$delim = '\'';
					
					$settings[ $key ] = json_encode( $value , JSON_HEX_APOS ); 
					
				} // end if
				
			} // end foreach
			
			foreach( $settings as $key => $value ){
				
				$settings_array[] = $key . '=' . $delim . $value . $delim;
				
			} // end foreach
			
		} // end if
		
		$shortcode = '[' . $this->get_slug();
		
		if ( ! empty( $settings_array ) ){
			
			$shortcode .= ' ' .  implode( ' ' , $settings_array );
			
		} // end if
		
		if ( ! $content ){
			
			$shortcode .= ']';
			
		} else {
			
			$shortcode .= ']' . $content . '[/' . $this->get_slug() . ']';
			
		}// end if
		
		return $shortcode;
		
	} // end get_item_shortcode
	
	
	public function get_the_clean_settings( $settings ){
		
		$clean = array();
		
		if ( method_exists( $this , 'clean_settings' ) ){
			
			$clean = $this->clean_settings( $settings );
			
		} // end if
		
		return $clean;
		
	} // end get_the_clean_settings
	
	
	public function get_the_item_settings( $settings = array() , $clean = false ){
		
		if ( $clean ) {
			
			$settings = $this->get_the_clean_settings( $settings );
			
		} // end if
		
		$s = array();
		
		$default_settings = $this->get_default_settings();
		
		foreach( $default_settings as $key => $value ){
			
			if ( ! isset( $settings[ $key ] ) ){
				
				$s[ $key ] = $value;
				
			} else {
				
				$s[ $key ] = $settings[ $key ];
				
			} // end if
			
		} // end foreach
		
		return $s;
		
	} // end get_the_item_settings
	
	
	
}