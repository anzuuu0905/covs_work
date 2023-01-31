<?php
$link_groups = load_data('link');
$banners = load_data('banner_link');

$page_title = "$site_name | LINK";
$page_description = '';
$page_keywords = 'ノルディック複合,コンバインド,Nordic,combined,olympic,athletes,渡部暁斗,Akito,Watabe,渡部善斗,スリースタイルスキー,モーグル,上村愛子,西伸幸,スキークロス,福島のり子,Kina,Kalani,Kina&Kalani';
//$style_files[] = "styles/index.css";
//$script_files[] = "scripts/index.js";
include("elements/header.php");
?>

<div id="container">
<div id="content">
<div class="mainone">
<div id="content-header" class="box">
  <h2><img src="<?php print_file('images/title_link.png'); ?>" alt="LINK" /></h2>
</div>

<?php foreach ($link_categories as $link_category) : ?>
<div>
  <h3 class="box"><?php print_img_text($link_category['name'], 'h3_link'); ?></h3>
  <ul class="links clearfix">
<?php
foreach ($link_groups[$link_category['id']] as $link) {
  if (!$link['enabled']) continue;
?>
    <li class="box">
      <p class="title"><?php print_text($link['title']); ?></p>
      <p class="name"><a href="<?php print($link['url']); ?>" target="_blank"><?php print_text($link['name']); ?></a></p>
      <div class="button">
        <a href="<?php print($link['url']); ?>" target="_blank" class="hover"><img src="<?php print_file('images/button_jump.png'); ?>" alt="JUMP" /></a>
      </div>
    </li>
<?php } ?>
  </ul>
</div>
<?php endforeach; ?>
</div>
</div><!-- #content -->
</div><!-- #container -->

<?php include "elements/banners.php"; ?>

<?php include "elements/footer.php"; ?>
