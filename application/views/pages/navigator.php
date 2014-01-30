<ol>
	<?php foreach ($pages as $item):?>
		<li <?php echo !empty($item->parent) ? 'value="'.$item->parent .'"' : ''?>>
			<?php if(!empty($page)):?>
				<a href="<?php echo site_url('pages/show/'. $item->id)?>" <?php echo ($page->id == $item->id) ? 'class="active"' : ''?>><?php echo $item->name?></a>
			<?php else:?>
				<a href="<?php echo site_url('pages/show/'. $item->id)?>" ><?php echo $item->name?></a>
			<?php endif?>
		</li>
	<?php endforeach;?>
	<?php foreach ($tests as $item):?>
		<li>
		<?php if(!empty($test)):?>
				<a href="<?php echo site_url('tests/show/'. $item->id)?>" <?php echo ($test->id == $item->id) ? 'class="active"' : ''?>><?php echo $item->name?></a>
			<?php else:?>
				<a href="<?php echo site_url('tests/show/'. $item->id)?>" ><?php echo $item->name?></a>
			<?php endif?>
		</li>
	<?php endforeach;?>
</ol>