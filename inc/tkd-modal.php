<div class="tkd-modal">
	<div class="tkd-modal-frame">
    	<header><?php echo $args['title'];?><a class="tkd-action-close-modal" href="#"></a></header>
        <div class="tkd-modal-content">
        	<?php echo $content;?>
        </div>
        <footer>
        	<a class="tkd-action-close-modal <?php echo $args['action'];?>" href="#"><?php echo $args['button_label'];?></a>
            <?php echo $args['extra_action'];?>
        </footer>
    </div>
</div>