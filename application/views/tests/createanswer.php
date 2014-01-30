<?php
$fields	=	array(); 
$fields[]	=	array('label' => 'Текст', 'name' => 'answer', 'type' => 'text'); 
?>
<form action="<?php echo site_url('tests/createanswer')?>" method="post">
	<?php foreach ($fields as $item):?>
		<div class="rowItem">
			<label><?php echo $item['label']?>:</label>
			<?php if($item['type'] != 'textarea'):?>
				<input type="<?php echo $item['type']?>" name="<?php echo $item['name']?>" value="" onchange="javascript: returbn false;$(this).val('[::'+$(this).val()+'.png::]')">
			<?php else: ?>
				<textarea rows="30" cols="70" name="<?php echo $item['name']?>"></textarea>
			<?php endif;?>
		</div>
		<div class="clear"></div>
	<?php endforeach;?>
	<input type="hidden" name="questionId"  value="<?php echo $question->id?>"/>
	<input type="submit" value="Создать">
</form>
<a href="<?php echo site_url('tests/editquestion/'. $question->id)?>">К списку ответов</a><br />
----------------------<br/>