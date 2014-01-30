<h4>Темы</h4>
<?php foreach ($themes as $item):?>
	<?php $page	=	PageItem::factory()->getByThemeId($item->id);?>
	<a href="<?php echo site_url('pages/'. $page[0]->alias)?>"><?php echo $item->name?></a><br/>
<?php endforeach;?>