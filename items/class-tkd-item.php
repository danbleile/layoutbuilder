<?php
abstract class TKD_Item {
	
	protected $forms;
	
	protected $id;
	
	protected $slug;
	
	protected $title;
	
	protected $settings;
	
	protected $content;
	
	protected $is_editor;
	
	protected $allowed_childen = array();
	
	protected $default_children = false;
	
	protected $children = array();
	
	public function __construct( $settings = array() , $content = '' , $is_editor = true  ){
		
		$this->set_id();
		
		$this->set_settings( $settings );
		
		$this->set_content( $content );
		
		$this->is_editor = $is_editor;
		
		$this->forms = new TKD_Forms();
		
	} // end __construct
	
	
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
	
	
	public function get_id(){
		
		return $this->id;
		
	} // end get_id
	
	
	public function get_slug(){
		
		return $this->slug;
		
	} // end get_slug
	
	
	public function get_title(){
		
		return $this->title;
		
	} // end get_slug
	
	public function get_content(){
		
		return $this->content;
		
	} // end get_content
	
	
	public function get_settings( $key = false ){
		
		$settings = $this->settings;
		
		if ( $key ){
			
			if ( array_key_exists( $key , $settings ) ){
				
				return $settings[ $key ];
				
			} else {
				
				return '';
				
			} // end if
			
		} else {
		
			return $settings;
		
		} // end if
		
	} // end get_settings
	
	
	public function get_allowed_children(){
		
		return $this->allowed_childen;
		
	}
	
	
	public function get_default_children(){
		
		return $this->default_children;
		
	}
	
	
	public function get_children(){
		
		return $this->children;
		
	}
	
	
	public function get_editor_content(){
		
		return $this->get_content();
		
	}
	
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
	
	
	public function get_form_html(){
		
		$html = '';
		
		if ( method_exists( $this , 'the_form' ) ){
			
			$form = $this->the_form( $this->get_settings() , $this->get_content() );
			
			$html .= $form;
			
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
	
	
	
}