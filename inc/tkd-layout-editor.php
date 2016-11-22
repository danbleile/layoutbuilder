<div id="tkd-layout-editor">
	<header>
    	<nav>
        	<!--<input type="radio" name="_tkd_layout_editor" value="1" />
            <input type="radio" name="_tkd_layout_editor" value="0" />-->
        </nav>
    </header>
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
    <textarea style="display: none;" id="tkd_editor_css"><?php echo $css;?></textarea>
</div>
<style>
	#wp-content-wrap { display: none;}
</style>