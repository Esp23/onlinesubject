<style>
	.description img {
		//display: block;
	}
</style>
<div class="navbar">
	<?php $this->load->view('pages/navigator', array('pages' => $pages));?>
</div>
<div class="description">
	<h2><?php echo $test->name?></h2>
	<p>Правильных ответов -  <?php echo $result?> из <?php echo count($questions)?> возможных.</p>
	<div><strong style="cursor: pointer; text-decoration: underline;" onclick="javascript: slide(this)">Просмотр Ответов</strong>
	<div class="hide" style="display: none;">
		<?php foreach ($questions as $key => $question):?>
		<?php $question->text	=	insertImage($question->text);?>
			<?php $answers	=	$question->getAnswers();?>
			<?php $userAnswer	=	UserAnswerItem::factory();?>
			<?php $userAnswer->user_testId	=	$userTest->id;?>
			<?php $userAnswer->questionId		=	$question->id;?>
			<?php $userAnswer		=	$userAnswer->getByTestAndQuestion();?>
			<div class="question">
				<h3>Вопрос №<?php echo $key+1?> из <?php echo count($questions)?></h3>
				<p><?php echo $question->text?></p>
				<?php if($question->type == 1):?>
					<p>Выберите один из вариантов ответа:</p>
					<?php foreach ($answers as $item):?>
						<p><input type="radio" name="answer[<?php echo $question->id?>]" value="<?php echo $item->id ?>" <?php echo $userAnswer->answer == $item->id ? 'checked="checked"' : ''?> /><?php echo insertImage($item->answer) ?></p>
					<?php endforeach;?>
				<?php else: ?>
					<p>Ответ:</p>
					<input type="text" name="answer" value="<?php echo $userAnswer->answer ?>" /><br />
				<?php endif;?>
				<h5>Правильный ответ: <?php echo $question->type == 2 ? $question->answer : insertImage(AnswerItem::factory($question->answer)->answer)?> </h5>
			</div>
		<?php endforeach;?>
	</div>
	</div>
</div>
<div class="clear"></div>