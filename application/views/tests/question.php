<div class="question">
	<h3>Вопрос №<?php echo $questionNumber?> из <?php echo $questionsCount?></h3>
	<p><?php echo $question->text?></p>
	<form action="<?php echo site_url('tests/saveAnswer') ?>" method="post">
	<?php if($question->type == 1):?>
		<p>Выберите один из вариантов ответа:</p>
		<?php foreach ($answers as $item):?>
			<p><input type="radio" name="answer" value="<?php echo $item->id ?>" <?php echo $userAnswer->answer == $item->id ? 'checked="checked"' : ''?> /><?php echo insertImage($item->answer) ?></p>
		<?php endforeach;?>
	<?php else: ?>
		<p>Ответ:</p>
		<input type="text" name="answer" value="<?php echo $userAnswer->answer ?>" /><br />
	<?php endif;?>
	<br />
	<br />
	<?php $prev	= $question->getPrevious()?>
	<?php if($prev):?>
		<a href="<?php echo $prev->id?>">Назад</a>
	<?php endif?>
	<input type="hidden" name="questionId" value="<?php echo $question->id?>" />
	<input type="hidden" name="user_testId" value="<?php echo $userTest->id?>" />
	<input type="submit" value="Дальше">
	</form>
</div>