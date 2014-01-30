<?php
$userFields	=	array(); 
$userFields[]	=	array('label' => 'Имя', 'name' => 'firstName', 'type' => 'text', 'value' => ''); 
$userFields[]	=	array('label' => 'Фамилия', 'name' => 'lastName', 'type' => 'text', 'value' => ''); 
$userFields[]	=	array('label' => 'Город', 'name' => 'city', 'type' => 'text', 'value' => ''); 
$userFields[]	=	array('label' => 'Изменить пароль', 'name' => 'changePassword', 'type' => 'checkbox', 'value' => 'on'); 
$userFields[]	=	array('label' => 'Пароль', 'name' => 'password', 'type' => 'password', 'value' => ''); 
$userFields[]	=	array('label' => 'Подтвердить пароль', 'name' => 'confirmPassword', 'type' => 'password', 'value' => ''); 
?>
<div class="login">
	<form action="<?php echo site_url('users/editprofile')?>" method="post">
		<?php foreach ($userFields as $item):?>
			<div class="rowItem">
				<label><?php echo $item['label']?>:</label>
				<input type="<?php echo $item['type']?>" name="<?php echo $item['name']?>" value="<?php echo (!empty($user->$item['name'])) ? $user->$item['name'] : $item['value'] ?>">
				<?php if(!empty($errors[$item['name']])):?>
					<span class="error"><?php echo $errors[$item['name']] ?></span>
				<?php endif?>
			</div>
			<div class="clear"></div>
		<?php endforeach;?>
		<input type="submit" value="Обновить">
	</form>
</div>