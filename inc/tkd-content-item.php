<div id="<?php echo $id; ?>" class="<?php echo implode( ' ' , $class );?>">
	<header><?php echo $title;?><a href="#" class="tkd-remove-item-action"></a></header>
    <div class="items-content">
    	<iframe src="about:blank" frameborder="0" class="tkd-the-content-frame" scrolling="no"></iframe>
        <a href="#" class="tkd-edit-item-action"></a>
    </div>
    <footer><textarea class="tkd-the-content"><?php echo $content;?></textarea></footer>
</div>