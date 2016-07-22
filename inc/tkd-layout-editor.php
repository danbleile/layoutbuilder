<div id="tkd-layout-editor">
	<header></header>
    <div class="items-set tkd-layout-items">
	<?php echo $items_html;?>
    </div>
    <?php echo $this->forms->get_hidden_field( $input_name , implode( ',' , $child_ids ) , array( 'class' => 'tkd-child-items-input' ) );?>
    <footer id="tkd-add-row">
    	<header><div class="tkd-title">Add Row</div></header>
    	<ul class="tkd-add-row-wrapper">
        <?php echo $layouts_html;?>
    	</ul>	
    </footer>
    <textarea id="tkd_editor_css"><?php echo $css;?></textarea>
</div>