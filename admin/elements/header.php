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
<?php foreach ($style_files as $style_file) : ?>
<link rel="stylesheet" href="<?php print_file($style_file); ?>" type="text/css" charset="utf-8">
<?php endforeach; ?>
<?php foreach ($script_files as $script_file) : ?>
<script type="text/javascript" src="<?php print_file($script_file); ?>" charset="utf-8"></script>
<?php endforeach; ?>
</head>

<body>
<div id="container">
<div id="header">
  <h1><a href="<?php echo SITE_URL; ?>/"><a href="<?php echo SITE_URL; ?>/">White Projects 管理画面</a></h1>

  <ul id="menu">
    <li><a href="<?php echo SITE_URL; ?>/event">イベント</a></li>
    <li><a href="<?php echo SITE_URL; ?>/shiro">白</a></li>
    <li><a href="<?php echo SITE_URL; ?>/media">メディア</a></li>
    <li><a href="<?php echo SITE_URL; ?>/banner">バナー</a></li>
    <li><a href="<?php echo SITE_URL; ?>/profile">プロフィール</a></li>
    <li><a href="<?php echo SITE_URL; ?>/link">リンク</a></li>
  </ul><!-- #menu -->
</div><!-- #header -->


