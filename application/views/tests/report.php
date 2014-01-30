<div class="navbar">
	<?php $this->load->view('pages/navigator', array('pages' => $pages));?>
</div>
<div class="description">
	<h2><?php echo $test->name?>. Отчет</h2>
	<?php echo $test->description?>
	<?php $sumMark = 0?>
	<table border="1px solid" style="width:100%;">
		<thead>
			<th>ФИО Студента</th>
			<th>Время прохождения</th>
			<th>Оценка</th>
		</thead>
		<tbody align="center" style="border: 1px solid;">
			<?php foreach ($userTests as $item):?>
				<?php $user 	= 	UserItem::factory($item->userId)?>
				<?php $mark		=	$item->calculateResult();?>
				<?php $sumMark	+=	$mark;?>
				<tr>
					<td><?php echo $user->lastName .' '. $user->firstName?></td>
					<td><?php echo date('i:s', strtotime($item->completed_date) - strtotime($item->started_date))?></td>
					<td><?php echo $mark?></td>
				</tr>
			<?php endforeach;?>
		</tbody>
	</table>
	<?php if($sumMark != 0):?>
		<div class="floatRight"><strong style="color: green;">Средний бал - <?php echo $sumMark/count($userTests)?></strong><div>
	<?php endif;?>
</div>
<div class="clear"></div>