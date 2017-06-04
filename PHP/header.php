 <!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<title><?php wp_title(' &mdash; ',true,'right'); ?><?php bloginfo('name'); ?></title>
		<link rel="shortcut icon" href="<?=get_template_directory_uri();?>/images/favicon.ico">
		<link rel="stylesheet" media="all" href="<?php bloginfo('stylesheet_url'); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php wp_head(); ?>
		<script>jwplayer.key="9zcBvlPiKxGVjiDu/nYJyx1zDAEsTACwvLcuKA=="</script>
	</head>
<body>
<?php ob_start(function($b){return preg_replace(['/\>[^\S ]+/s','/[^\S ]+\</s','/(\s)+/s'],['>','<','\\1'],$b);}); ?>
	<header class='header'>
		<div class='row'>
			<div class='col-md-3'>
				<a href='/'><img src="<?=get_template_directory_uri();?>/images/logo.jpg" alt="<?php bloginfo('name'); ?>" class="logo"></a>
			</div>
			<div class='col-md-9'>
				<div class='topMenu'>
						<?php wp_nav_menu(array(
							'theme_location'  => 'top-menu',
							'container' => 'menu',
							'container_class' => ''
						)); ?>
					<form method="get" action="/">
						<label for='search' style="display: none; visibility: hidden;">Search:</label>
						<input id='search' type='text' name='s' placeholder='What are you looking for?' />
						<input type='submit' value='Search'/>
					</form>
					<div class='clear'></div>
				</div>
				<div class='banner'>
					<?php include 'parts/top-banners.php'; ?>
				</div>
			</div>
		</div>
		<menu class='menu'>
			<?php wp_nav_menu(array(
			'theme_location'  => 'main-menu',
			'container' => 'menu',
			'container_class' => ''
			)); ?>
		</menu>
		<button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
	</header>
		<div class='content'>
