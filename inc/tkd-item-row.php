<div id="<?php echo $id; ?>" class="<?php echo implode( ' ' , $class );?>">
	<header><a href="#" class="tkd-edit-settings-action"></a><a href="#" class="tkd-remove-item-action"></a></header>
    <div class="items-set">
    	<?php echo $content;?>
    </div>
    <?php echo $this->forms->get_hidden_field( $input_name . '[items]' , $child_ids , array( 'class' => 'tkd-child-items-input' ) );?>
    <footer></footer>
</div>