<?php
$fields	=	array(); 
$fields[]	=	array('label' => 'Текст', 'name' => 'answer', 'type' => 'text'); 
?>
<form action="<?php echo site_url('tests/editanswer/'.$answer->id)?>" method="post">
	<?php foreach ($fields as $item):?>
		<div class="rowItem">
			<label><?php echo $item['label']?>:</label>
			<?php if($item['type'] != 'textarea'):?>
				<input type="<?php echo $item['type']?>" name="<?php echo $item['name']?>" value="<?php echo $answer->$item['name']?>">
			<?php else: ?>
				<textarea rows="30" cols="70" name="<?php echo $item['name']?>"></textarea>
			<?php endif;?>
		</div>
		<div class="clear"></div>
	<?php endforeach;?>
	<input type="submit" value="Обновить">
</form>
<a href="<?php echo site_url('tests/editquestion/'. $answer->questionId)?>">К списку ответов</a><br />
----------------------<br/>