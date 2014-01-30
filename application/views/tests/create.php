<?php
$fields	=	array(); 
$fields[]	=	array('label' => 'Имя', 'name' => 'name', 'type' => 'text'); 
$fields[]	=	array('label' => 'Описание', 'name' => 'description', 'type' => 'textarea'); 
?>
<form action="<?php echo site_url('tests/create')?>" method="post">
	<?php foreach ($fields as $item):?>
		<div class="rowItem">
			<label><?php echo $item['label']?>:</label>
			<?php if($item['type'] != 'textarea'):?>
				<input type="<?php echo $item['type']?>" name="<?php echo $item['name']?>" value="">
			<?php else: ?>
				<textarea rows="30" cols="70" name="<?php echo $item['name']?>"></textarea>
			<?php endif;?>
		</div>
		<div class="clear"></div>
	<?php endforeach;?>
	<input type="submit" value="Создать">
</form>