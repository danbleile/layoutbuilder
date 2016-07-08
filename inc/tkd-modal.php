<div class="tkd-modal">
	<div class="tkd-modal-frame tkd-modal-<?php echo $args['size'];?>">
    	<header><?php echo $args['title'];?><a class="tkd-close-modal-action" href="#"></a></header>
        <div class="tkd-modal-content"> 
        	<?php echo $content;?>
        </div>
        <footer>
        	<a class="tkd-close-modal-action <?php echo $args['action'];?> tkd-button tkd-large" href="#"><?php echo $args['button_label'];?></a>
            <?php echo $args['extra_action'];?>
        </footer>
    </div>
</div>