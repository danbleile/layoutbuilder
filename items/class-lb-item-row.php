<?php

class LB_Item_Row extends LB_Item {
	
	protected $slug = 'row';
	
	protected $name = 'Row';
	
	protected $allow_children = array('column');
	
	protected $default_child = 'column';
	
	protected $fields = array(
		'format' => array( 'single' , 'text' ),
	);
	
	
	public function get_editor_html( $editor_content ){
		
		$class = array(
			$this->get_settings( 'format' ),
			'row',
			'layout-item',
			'structure-item',
		);
		
		$html = '<div id="' . $this->get_id() . '" class="' . implode( ' ' , $class ) . '">';
			
			$html .= '<header>';
			
				$html .= '<a href="#" class="action-edit-item">Edit</a>';
				
				$html .= '<div class="item-title"></div>';
			
				$html .= '<a href="#" class="action-remove-item">Remove</a>';
			
			$html .= '</header>';
				
			$html .= '<div class="child-items">';
			
				$html .= $editor_content; 
		
			$html .= '</div>';
			
			$html .= '<input class="lb-child-items" type="text" name="_layout_builder[' . $this->get_id() . '][items]" value="' . implode(',' , $this->get_child_ids() )  . '" />';
		
		$html .= '</div>';
		
		return $html;
		
	} // end get_editor_html
	
	
}