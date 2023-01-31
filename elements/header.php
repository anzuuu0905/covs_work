<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta name="keywords" content="<?php print_text($page_keywords); ?>">
<meta name="description" content="<?php print_text($page_description); ?>">
<title><?php print_text($page_title); ?></title>
<link rel="index" href="<?php echo SITE_URL; ?>/">

<link rel="shortcut icon" href="<?php echo SITE_URL; ?>/images/favicon.ico">
<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">


<?php foreach ($style_files as $style_file) : ?>
<link rel="stylesheet" href="<?php print_file($style_file); ?>" type="text/css" charset="utf-8">
<?php endforeach; ?>
<?php foreach ($script_files as $script_file) : ?>
<script type="text/javascript" src="<?php print_file($script_file); ?>" charset="utf-8"></script>
<?php endforeach; ?>
</head>

<body class="<?php print(implode(' ', explode('/', substr(CURRENT_PAGE, 1)))); ?>">

<div id="containerWrap">
	<header>
  <h1>
    <a href="<?php echo SITE_URL; ?>/"><img src="<?php print_file('images/logo.png'); ?>" alt="Creating A World-Class Mountain Destination" /></a>
  </h1>
  <nav id="gnavi">
		<ul>
			<li><a href="<?php echo SITE_URL; ?>/">TOP</a></li>
			<li><a href="<?php echo SITE_URL; ?>/events">EVENTS</a></li>
			<li><a href="<?php echo SITE_URL; ?>/shiro"><img src="<?php print_file('images/shiro.svg'); ?>" alt="白" /></a></li>
			<li><a href="http://ameblo.jp/mctossy" target="_blank">BLOG</a></li>
			<li><a href="<?php echo SITE_URL; ?>/media">MEDIA</a></li>
			<li><a href="<?php echo SITE_URL; ?>/documents/interview.pdf" target="_blank">INTERVIEW</a></li>
			<li><a href="<?php echo SITE_URL; ?>/link" class="hover<?php if (CURRENT_PAGE == '/link') {?> current<?php } ?>">LINK</a></li>
			<li><a href="https://www.instagram.com/toshiromaruyama/" target="_blank"><img src="<?php print_file('images/insta.svg'); ?>" alt="insta" /></a></li>
		</ul>
  </nav>
</header><!-- #header -->


