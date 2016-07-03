<?php

class TKD_Item_Text extends TKD_Item {
	
	protected $slug = 'text';
	
	protected $title = 'Text/HTML';
	
	protected function get_editor_default_content(){
		
		return '<div class="tkd-editor-default">Click to add text ...</div>';
		
	} // end get_editor_default_content
	
}