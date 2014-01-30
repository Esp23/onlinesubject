<?php
$fields	=	array(); 
$fields[]	=	array('label' => 'Имя', 'name' => 'name', 'type' => 'text'); 
$fields[]	=	array('label' => 'Описание', 'name' => 'description', 'type' => 'textarea'); 
?>
<form action="<?php echo site_url('tests/edit/'. $test->id)?>" method="post">
	<?php foreach ($fields as $item):?>
		<div class="rowItem">
			<label><?php echo $item['label']?>:</label>
			<?php if($item['type'] != 'textarea'):?>
				<input type="<?php echo $item['type']?>" name="<?php echo $item['name']?>" value="<?php echo $test->$item['name']?>">
			<?php else: ?>
				<textarea rows="30" cols="70" name="<?php echo $item['name']?>"><?php echo $test->$item['name']?></textarea>
			<?php endif;?>
		</div>
		<div class="clear"></div>
	<?php endforeach;?>
	<input type="submit" value="Обновить">
</form>
<a href="<?php echo site_url('tests/createquestion/'. $test->id)?>">Создать новый вопрос</a><br />
----------------------<br />
<?php foreach ($questions as $key=>$item):?>
	<?php echo $key+1?>) <a href="<?php echo site_url('tests/editquestion/'. $item->id)?>"><?php echo $item->text?></a><br />
<?php endforeach;?>