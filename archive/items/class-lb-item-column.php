<?php

class LB_Item_Column extends LB_Item {
	
	protected $slug = 'column';
	
	protected $name = 'Column';
	
	protected $allow_children = array('content-items');
	
	protected $default_child = 'text';
	
	protected $fields = array(
		'index' => '1',
	);
	
	
	public function get_editor_html( $editor_content ){
		
		$col = array('zero','one','two','three','four','five','six','seven','eight','nine','ten');
		
		$class = array(
			'column',
			'layout-item',
			'structure-item',
			$col[ $this->get_setting( 'index' ) ]
		);
		
		$html = '<div id="' . $this->get_id() . '" class="' . implode( ' ' , $class ) . '">';
			
			$html .= '<div class="child-items">';
		
				$html .= $editor_content; 
			
			$html .= '</div>';
			
			$html .= '<input class="lb-child-items" type="text" name="_layout_builder[' . $this->get_id() . '][items]" value="' . implode(',' , $this->get_child_ids() )  . '" />';
		
		$html .= '</div>';
		
		return $html;
		
	} // end get_editor_html
	
	
	
	
}