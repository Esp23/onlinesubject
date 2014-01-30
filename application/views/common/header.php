<?php
$userInfo	=	UserHelper::loggedIn(); 
?>
<html>
	<head>
		 <title><?php echo SeoHelper::getTitle()?></title>
	</head>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/main.css">
	<script type="text/javascript" src="<?php echo base_url()?>js/jquery.js"></script>
	<script type="text/javascript" >
	function slide(el) {
		$(el).closest('div').find('.hide').slideToggle();
	}
	</script>
	<div id="content">
		<div class="header_content">
			<div class="header">
				<h1>
					<a class="logo" href="<?php echo site_url()?>">
						<img alt="OnlineSubjects" src="<?php echo base_url()?>images/logo.png" />
					</a>
				</h1>
				<?php if($userInfo->id > 0):?>
					<div class="account">
						Привет, <a style="padding: 0px;" href="<?php echo site_url('users/account')?>"><?php echo trim($userInfo->firstName . ' ' . $userInfo->lastName)?></a> <a href="<?php echo site_url('users/logout')?>">Выйти</a> 
					</div>
				<?php else:?>
					<div class="account">
						<a href="<?php echo site_url('users/login')?>">Войти</a>
						<a href="<?php echo site_url('users/signup')?>">Регистрация</a>
					</div>	
				<?php endif;?>
			</div>
		</div>
		<div class="header_line">&nbsp;</div>
		<div class="content" style="<?php echo (!empty($pageFlag)) ? "background: #F1F1F1;" : '' ?>" >
			<div class="inside" style="<?php echo (!empty($home)) ? "min-height: 630px;" : '' ?>" >