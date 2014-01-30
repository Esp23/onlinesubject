<?php
$fields	=	array(); 
$fields[]	=	array('label' => 'Вопрос', 'name' => 'text', 'type' => 'textarea'); 
?>
<form action="<?php echo site_url('tests/editquestion/'.$question->id)?>" method="post">
	<?php foreach ($fields as $item):?>
		<div class="rowItem">
			<label><?php echo $item['label']?>:</label>
			<?php if($item['type'] != 'textarea'):?>
				<input type="<?php echo $item['type']?>" name="<?php echo $item['name']?>" value="<?php echo $question->$item['name']?>">
			<?php else: ?>
				<textarea rows="30" cols="70" name="<?php echo $item['name']?>"><?php echo $question->$item['name']?></textarea>
			<?php endif;?>
		</div>
		<div class="clear"></div>
	<?php endforeach;?>
	<div class="rowItem">
		<label>Правильный ответ:</label>
		<?php if($question->type == 1):?>
			<select name="answer">
				<option value="" >Нет</option>
				<?php foreach ($answers as $answer):?>
					<option value="<?php echo $answer->id?>" <?php echo ($question->answer == $answer->id) ? 'selected="selected"' : ''?> ><?php echo $answer->answer?></option>
				<?php endforeach;?>
			</select>
		<?php else :?>
			<input type="text" name="answer" value="<?php echo $question->answer?>">
		<?php endif;?>
	</div>
	<div class="clear"></div>
	<div class="rowItem">
			<label>Тип вопроса:</label>
		<select name="type">
			<option value="1" <?php echo ($question->type == 1) ? 'selected="selected"' : ''?> >С ответами</option>
			<option value="2" <?php echo ($question->type == 2) ? 'selected="selected"' : ''?> >Свободный вопрос</option>
		</select>
	</div>
	<div class="clear"></div>
	<input type="hidden" name="testId"  value="<?php echo $question->testId?>"/>
	<input type="submit" value="Обновить">
</form>
<a href="<?php echo site_url('tests/edit/'. $question->testId)?>">К списку вопросов</a><br />
----------------------<br/>
<?php if($question->type == 1):?>
	<a href="<?php echo site_url('tests/createanswer/'. $question->id)?>">Создать новый ответ</a><br />
	----------------------<br />
	<?php foreach ($answers as $item):?>
		<a href="<?php echo site_url('tests/editanswer/'. $item->id)?>"><?php echo $item->answer?></a><br />
	<?php endforeach;?>
<?php endif;?>