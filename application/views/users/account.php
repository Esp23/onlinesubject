<?php
$userFields	=	array();
$userFields[]	=	array('label' => 'Логин', 'name' => 'login', 'type' => 'text'); 
$userFields[]	=	array('label' => 'Имя', 'name' => 'firstName', 'type' => 'text'); 
$userFields[]	=	array('label' => 'Фамилия', 'name' => 'lastName', 'type' => 'text'); 
$userFields[]	=	array('label' => 'Город', 'name' => 'city', 'type' => 'text'); 
?>
<div class="login">
	<h5><a href="<?php echo site_url('users/editprofile')?>">Редактировать</a></h5>
	<?php foreach ($userFields as $item):?>
		<div class="rowItem">
			<label><?php echo $item['label']?>:</label>
			<span><?php echo $user->$item['name']?></span>
		</div>
		<div class="clear"></div>
	<?php endforeach;?>
</div>