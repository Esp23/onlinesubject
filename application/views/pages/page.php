<div class="navbar">
	<?php $this->load->view('pages/navigator', array('pages' => $pages));?>
</div>
<div class="description">
	<?php echo $page->content?>
	<div class="links">
		<?php foreach ($pages as $key=>$item):?>
			<?php if($item->id == $page->id && $key != 0):?>
				<?php $prevId	=	$pages[$key-1]?>
				<a href="<?php echo site_url('pages/show/'.$pages[$key-1]->id)?>" class="floatLeft">Назад</a>
			<?php endif;?>
			<?php if($item->id == $page->id && $key != (count($pages) -1) ):?>
				<a href="<?php echo site_url('pages/show/'.$pages[$key+1]->id)?>" class="floatRight">Вперед</a>
			<?php endif;?>
		<?php endforeach;?>
	</div>
</div>
<div class="clear"></div>
