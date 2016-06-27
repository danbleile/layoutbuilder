<div id="tk-builder-add-row">
	<header>
    	<span>Add Row</span>
    </header>
    <div class="tk-builder-row-options">
    	<?php foreach( $layouts as $slug => $columns ):?>
    	<fieldset class="tk-layout-<?php echo $slug;?>">
        	<div class="tk-builder-add-row-inner">
                <div class="tk-builder-add-row-columns">
                <?php for( $i = 1; $i < $columns[0]; $i++ ):?>
                    <span class="<?php echo $col[ $i ];?>"></span>
                <?php endfor;?>
                </div>
                <div class="tk-title"><?php echo $columns[1];?></div>
            </div>
            <input type="hidden" name="slug" value="row" />
            <input type="hidden" name="settings[layout]" value="<?php echo $slug;?>" />
        </fieldset>
        <?php endforeach;?>
    </div>
</div>