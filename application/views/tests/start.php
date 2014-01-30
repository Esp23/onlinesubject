<div class="navbar">
	<?php $this->load->view('pages/navigator', array('pages' => $pages));?>
</div>
<div class="description">
	<h2><?php echo $test->name?></h2>
	<?php echo $test->description?>
	<p>
		<a href="<?php echo site_url('tests/start/'. $test->id)?>">Начать Тест</a>
	</p>
	<p>
		<a href="<?php echo site_url('tests/showReport/'. $test->id)?>">Посмотреть отчет</a>
	</p>
	<?php /*?><div class="links">
		<?php foreach ($tests as $key=>$item):?>
			<?php if($item->id == $test->id && $key != 0):?>
				<?php $prevId	=	$tests[$key-1]?>
				<a href="<?php echo site_url('tests/show/'.$tests[$key-1]->id)?>" class="floatLeft">Назад</a>
			<?php endif;?>
			<?php if($item->id == $test->id && $key != (count($tests) -1) ):?>
				<a href="<?php echo site_url('tests/show/'.$tests[$key+1]->id)?>" class="floatRight">Вперед</a>
			<?php endif;?>
		<?php endforeach;?>
	</div>
	<?php */?>
</div>
<div class="clear"></div>