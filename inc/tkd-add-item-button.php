<li class="tkd-add-item-select">
	<div class="tkd-add-item-icon <?php echo $item->get_slug();?>-item-icon"></div>
	<ul>
    	<li class="tkd-title"><?php echo $item->get_title();?></li>
        <li class="tkd-desc"><?php echo $item->get_desc();?></li>
    </ul>
    <input type="hidden" name="tkd_slug" value="<?php echo $item->get_slug();?>">
    <input type="hidden" name="tkd_action" value="tkd_get_part">
</li>