<?php
$userFields	=	array(); 
$userFields[]	=	array('label' => 'Логин', 'name' => 'login', 'type' => 'text'); 
$userFields[]	=	array('label' => 'Пароль', 'name' => 'password', 'type' => 'password'); 
?>
<div class="login">
	<form action="<?php echo site_url('users/login')?>" method="post">
		<?php foreach ($userFields as $item):?>
			<div class="rowItem">
				<label><?php echo $item['label']?>:</label>
				<input type="<?php echo $item['type']?>" name="<?php echo $item['name']?>" value="<?php echo $user->$item['name']?>">
				<?php if(!empty($errors[$item['name']])):?>
					<span class="error"><?php echo $errors[$item['name']] ?></span>
				<?php endif?>
			</div>
			<div class="clear"></div>
		<?php endforeach;?>
		<input type="submit" value="Войти">
	</form>
</div>