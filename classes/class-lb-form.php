<?php
class LB_Form {
	
	//@var string path to the include folder
	protected $inc_path;
	
	
	public function __construct(){
		
		$this->inc_path = plugin_dir_path( dirname(__FILE__) ) . 'inc/';
		
	} // end __construct
	
	
	public function get_text_field(){
	}
	
	
	/**
	 * Get form from array
	 *
	 * @param $form_array
	 * @return string HTML for the form
	 */
	public function get_form_html( $form_id , $form_array , $title = '', $action = false , $btn_label = 'Done' , $class = '' ){
		
		ob_start();
		
		include $this->inc_path . 'form.php';
		
		$html = ob_get_clean();
		
		return $html;
		
	} // end get_form_html
	
	/**
	 * Get hidden field html
	 *
	 * @param string $name Name of the field
	 * @param string $value Value of the field
	 * @return string HTML for the field
	 */
	public function get_field_hidden( $name , $value ){
		
		return '<input type="hidden" value="' . $value . '" name="' .  $name . '" />';
		
	} // end get_input_hidden
	
	
	/**
	 * Wrap Form for modal view
	 *
	 * @param string $form Form HTML
	 * @return string Modal Form HTML
	 */
	public function get_form_modal( $form ){
		
		ob_start();
		
		include $this->inc_path . 'form-modal.php';
		
		$html = ob_get_clean();
		
		return $html;
		
	} // end get_form_modal
	
}