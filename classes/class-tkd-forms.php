<?php

class TKD_Forms {
	
	protected $prefix = '_tkd_builder';
	
	protected $content_prefix = '_tkd_content_';
	
	
	public function get_prefix(){ return $this->prefix; }
	
	public function get_content_prefix(){ return $this->content_prefix; }
	
	
	public function get_text_field( $name , $value = '' , $args = array() ){
		
		$defaults = array(
			'class'      => '',
			'id'         => '',
			'label'      => false,
			'wrap_field' => true,
			'placeholder' => '',
		);
		
		$this->check_defaults( $args , $defaults );
		
		$attrs = array( 
			'input',
			'type="text"',
			'name="' . $name . '"',
			'value="' . $value . '"',
			'class="tkd-field-input ' . $args['class'] . '"',
			'id="' . $args['class'] . '"',
			'placeholder="' . $args['placeholder'] . '"',
		);
		
		$html = '<' . implode( ' ' , $attrs ) . ' />';
		
		$field = $this->get_field_wrap( $html , $args );
		
		return $field;
		
	} // end get_text_field
	
	
	public function get_select_field( $name , $options , $current_value = '' , $args = array() ){
		
		$defaults = array(
			'class'      => '',
			'id'         => '',
			'label'      => false,
			'wrap_field' => true,
		);
		
		$this->check_defaults( $args , $defaults );
		
		$select = '<select name="' . $name . '" >';
		
		foreach( $options as $option => $value ){
			
			$select .= '<option value="' . $value . ' " ' . selected( $value , $current_value , false ) . '>' . $option . '</option>'; 
			
		} // end foreach
		
		$select .= '</select>';
		
		$field = $this->get_field_wrap( $select , $args );
		
		return $field;
		
	} // end get_text_field
	
	
	public function get_hidden_field( $name , $value, $args = array() ){
		
		$defaults = array(
			'class' => '',
			'id'    => '',
		);
		
		$this->check_defaults( $args , $defaults );
		
		return '<input id="' . $args['id'] . '" class="' . $args['class'] . '" type="hidden" name="' . $name . '" value="' . $value . '" />';
		
	} // end get_hidden_field
	
	
	public function get_hidden_fields( $fields ){
		
		$html = '';
		
		foreach( $fields as $key => $value ){
			
			$html .= '<input type="hidden" name="' . $key . '" value="' . $value . '" />';
			
		} // end field
		
		return $html;
		
	} // end get_hidden_field
	
	
	public function get_textarea( $name , $value , $args = array() ){
		
		$defaults = array(
			'class'      => '',
			'id'         => '',
			'label'      => false,
			'wrap_field' => true,
		);
		
		$this->check_defaults( $args , $defaults );
		
		$html = '<textarea name="' . $name . '">' . $value . '</textarea>';
		
		return $html;
		
	} // end get_textarea
	
	
	public function get_modal( $content , $args = array() ){
		
		$defaults = array(
			'title'        => 'Edit Item',
			'action'       => 'tkd-edited-item',
			'class'        => '',
			'button_label' => 'Done',
			'allow_cancel' => true,
			'footer_html'  => '',
			'size'         => 'full',
		);
		
		$this->check_defaults( $args , $defaults );
		
		ob_start();
		
		include plugin_dir_path( dirname( __FILE__ ) ) . 'inc/tkd-modal.php';
		
		return ob_get_clean();
		
	} // end get_modal
	
	
	public function get_tab_form( $id , $nav , $sections , $args = array() ){
		
		$defaults = array(
			'hidden_fields' => array(),
		);
		
		$this->check_defaults( $args , $defaults );
		
		$hidden_fields = $this->get_hidden_fields( $args['hidden_fields'] );
		
		ob_start();
		
		include plugin_dir_path( dirname( __FILE__ ) ) . 'inc/tkd-tab-form.php';
		
		return ob_get_clean();
		
	} // end get_subform
	
	
	public function check_defaults ( &$args , $defaults ){
		
		foreach( $defaults as $key => $value ){
			
			if ( ! isset( $args[ $key ] ) ){
				
				$args[ $key ] = $value;
				
			} // end if
			
		} // end foreach
		
	} // end check_defaults
	
	
	public function get_field_wrap( $field , $args ){
		
		if ( ! isset( $args['field_wrap'] ) || ! empty( $args['field_wrap'] ) ){
		
			$defaults = array(
				'label'        => false,
				'class'        => '',
			);
			
			$this->check_defaults( $args , $defaults );
			
			$class = array( 'tkd-field' );
			
			if ( $args['class'] ) $class[] = $args['class'];
			
			$html = '<div class="' . implode( ' ' , $class ) . '">';
			
			if ( $args['label'] ) {
				
				$html .= '<label>' . $args['label'] . '</label>';
				
			} // end if
			
			$html .= $field . '</div>';
			
			$field = $html;
		
		} // end if
		
		return $field;
		
	} // end 
	
}