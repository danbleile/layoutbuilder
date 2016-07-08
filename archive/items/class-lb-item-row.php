<?php

class LB_Item_Row extends LB_Item {
	
	protected $slug = 'row';
	
	protected $name = 'Row';
	
	protected $allow_children = array('column');
	
	protected $default_child = 'column';
	
	protected $fields = array(
		'layout' => 'single',
	);
	
	
	public function get_editor_html( $editor_content ){
		
		$class = array(
			$this->get_setting( 'layout' ),
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
	
	
	public function the_form( $settings , $content ){
		
		$html = $this->get_field_hidden( $this->get_input_name('layout') , $settings['layout'] );
		
		return $html;
		
	} // end $content
	
	
	/**
	 * Check children before adding to item 
	 *
	 * @param array $children Current Children
	 * @param LB_Items_Factory $item_factory Instance of LB_Items_Factory
	 * @return array Children of item
	 */
	public function check_children( $children , $item_factory ){
		
		$row_layouts = $item_factory->get_layouts();
		
		$layout = $this->get_setting( 'layout' );
		
		if ( ! empty( $row_layouts[ $layout ] ) ){
			
			$chil_cols = count( $children );
			
			$lay_cols = $row_layouts[ $layout ][0];
			
			$cols = ( $lay_cols - $chil_cols );
			
			if ( 0 < $cols ){
				
				for ( $c = 0; $c < $cols; $c++ ){
					
					$column = $item_factory->get_item( 'column' , array() , '' , false , true );
					
					$children[] = $column;
					
				} // end for
				
			} else if ( $cols > $chil_cols ){
				
				$children = array_slice( $children , 0 , $lay_cols );
				
			}// end if
			
		} // end if
		
		foreach( $children as $index => $child ){
			
			$children[ $index ]->set_setting( 'index' , ( $index + 1 ) );
			
		} // end foreach
		
		return $children;
		
	} // end check_children
	
	
}