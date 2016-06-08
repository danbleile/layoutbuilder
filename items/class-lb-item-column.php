<?php

class LB_Item_Column extends LB_Item {
	
	protected $slug = 'column';
	
	protected $name = 'Column';
	
	protected $allow_children = array('content-items');
	
	protected $default_child = 'text';
	
	
	public function get_editor_html( $editor_content ){
		
		$class = array(
			'column',
			'layout-item',
			'structure-item',
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