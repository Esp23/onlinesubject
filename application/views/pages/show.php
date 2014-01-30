<p><?php echo $theme->description?></p>
<h4>Pages</h4>
<?php foreach ($pages as $item):?>
	<a href="<?php echo site_url('pages/'.$item->alias)?>"><?php echo $item->name?></a><br/>
<?php endforeach;?>