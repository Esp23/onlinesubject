<?php
$fields	=	array(); 
$fields[]	=	array('label' => 'Имя', 'name' => 'name', 'type' => 'text'); 
$fields[]	=	array('label' => 'Ссылка', 'name' => 'alias', 'type' => 'text'); 
$fields[]	=	array('label' => 'Контент', 'name' => 'content', 'type' => 'textarea'); 
?>
<form action="<?php echo site_url('pages/edit/'. $page->id)?>" method="post">
	<?php foreach ($fields as $item):?>
		<div class="rowItem">
			<label><?php echo $item['label']?>:</label>
			<?php if($item['type'] != 'textarea'):?>
				<input type="<?php echo $item['type']?>" name="<?php echo $item['name']?>" value="<?php echo $page->$item['name']?>">
			<?php else: ?>
				<textarea rows="30" cols="70" name="<?php echo $item['name']?>"><?php echo $page->$item['name']?></textarea>
			<?php endif;?>
		</div>
		<div class="clear"></div>
	<?php endforeach;?>
	<input type="submit" value="Обновить">
</form>