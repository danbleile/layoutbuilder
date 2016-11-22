<fieldset id="<?php echo $id;?>" class="tkd-tab-form tkd-form">
	<nav>
    	<?php $active = 'active'; foreach( $nav as $label ):?><a href="#" class="<?php echo $active;?>"><?php echo $label;?></a><?php $active = ''; endforeach;?>
    </nav>
    <div class="tkd-form-sections">
    	<?php $active = 'active'; foreach( $sections as $section):?><div class="tkd-form-section <?php echo $active;?>"><?php echo $section;?></div><?php $active = ''; endforeach;?>
    </div>
    <footer>
    	<?php echo $hidden_fields;?>
    </footer>
</fieldset>