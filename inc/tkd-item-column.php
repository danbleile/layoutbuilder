<div id="<?php echo $id; ?>" class="<?php echo implode( ' ' , $class );?>">
	<header></header>
    <div class="items-set">
    	<?php echo $content;?>
    </div>
    <?php echo $this->forms->get_hidden_field( $input_name . '[items]' , $child_ids , array( 'class' => 'tkd-child-items-input' ) );?>
    <footer><a href="#" class="tkd-add-item-action tkd-button tkd-small">Add Item</a></footer>
</div>