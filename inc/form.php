<fieldset id="form-<?php echo $form_id;?>" class="tk-builder-form">
	<header>
    	<?php echo $title;?>
    </header>
	<nav>
    	<?php foreach( $form_array as $label => $form ):?>
        	<a href="#"><?php echo $label;?></a>
        <?php endforeach;?>
    </nav>
    <div class="tk-builder-form-sections">
    	<?php foreach( $form_array as $label => $form ):?>
        	<fieldset><div><?php echo $form;?></div></fieldset>
        <?php endforeach;?>
    </div>
    <footer>
		<?php if ( $action && $label ):?>
        	<a href="#" class="tk-builder-form-button large close-modal-action <?php echo $action;?>" ><?php echo $btn_label;?></a>
        <?php endif;?>
    </footer>
</fieldset>