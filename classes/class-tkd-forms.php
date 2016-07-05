<?php

class TKD_Forms {
	
	protected $prefix = '_tkd_builder';
	
	protected $content_prefix = '_tkd_content_';
	
	
	public function get_prefix(){
		
		return $this->prefix;
		
	}
	
	public function get_content_prefix(){
		
		return $this->content_prefix;
		
	}
	
	
	public function get_text_field( $name , $value = '' , $args = array() ){
		
		$defaults = array(
			'class'      => '',
			'id'         => '',
			'label'      => false,
			'wrap_field' => true,
		);
		
		$this->check_defaults( $args , $defaults );
		
		$attrs = array( 
			'input',
			'type="text"',
			'name="' . $name . '"',
			'value="' . $value . '"',
			'class="tkd-field-input ' . $args['class'] . '"',
			'id="' . $args['class'] . '"',
		);
		
		return '<' . implode( ' ' , $attrs ) . ' />';
		
	} // end get_text_field
	
	
	public function get_hidden_field( $name , $value, $args = array() ){
		
		$defaults = array(
			'class' => '',
			'id'    => '',
		);
		
		$this->check_defaults( $args , $defaults );
		
		return '<input id="' . $args['id'] . '" class="' . $args['class'] . '" type="hidden" name="' . $name . '" value="' . $value . '" />';
		
	} // end get_hidden_field
	
	
	public function check_defaults ( &$args , $defaults ){
		
		foreach( $defaults as $key => $value ){
			
			if ( ! isset( $args[ $key ] ) ){
				
				$args[ $key ] = $value;
				
			} // end if
			
		} // end foreach
		
	} // end check_defaults
	
}