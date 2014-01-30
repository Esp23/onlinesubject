<?php
$fields	=	array(); 
$fields[]	=	array('label' => 'Вопрос', 'name' => 'text', 'type' => 'textarea'); 
$fields[]	=	array('label' => 'Правильный ответ', 'name' => 'answer', 'type' => 'text'); 
?>
<form action="<?php echo site_url('tests/createquestion')?>" method="post">
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
	<div class="rowItem">
			<label>Тип вопроса:</label>
		<select name="typeId">
			<option value="1">С ответами</option>
			<option value="2">Свободный вопрос</option>
		</select>
	</div>
	<div class="clear"></div>
	<input type="hidden" name="testId"  value="<?php echo $test->id?>"/>
	<input type="submit" value="Создать">
</form>