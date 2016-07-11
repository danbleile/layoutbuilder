<li class="tkd-add-layout-item tkd-layout-item-<?php echo $slug;?> tkd-ajax-item tkd-add-layout-item-<?php echo $class;?>" data-ajaxtype="add-row">
	<ul>
    	<li class="tkd-add-layout-item-icon">
        	<?php for( $i = 1; $i < $columns; $i++ ):?>
            <span class="tkd-add-layout-split tkd-split-<?php echo $i;?>"></span>
            <?php endfor;?>
        </li>
        <li class="tkd-add-layout-item-text">
        	<?php echo $label;?>
        </li>
    </ul>
    <input type="hidden" name="tkd_slug" value="<?php echo $slug;?>" />
    <input type="hidden" name="tkd_action" value="<?php echo $action;?>" />
    <?php foreach( $settings as $key => $value ):?>
    <input type="hidden" name="tkd_setting[<?php echo $key;?>]" value="<?php echo $value;?>" />
   	<?php endforeach;?>
</li> 