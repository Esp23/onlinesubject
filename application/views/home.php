<div class="home">
	<?php foreach ($themes as $theme):?>
	<p>
		<a href="<?php echo site_url('pages/show/'.$pages[$theme->id][0]->id)?>">
			<?php echo $theme->name?>
		</a>
	</p>
	<?php endforeach;?>
</div>
