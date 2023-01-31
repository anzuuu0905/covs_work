<?php
$medias = load_data('media');
$profile = load_data('profile_media');
$banners = load_data('banner_media');
$profile_image_url = 'images/profilephoto_tailored.jpg';

$current_category = 0;
if (isset($_GET['category'])) {
  $current_category = $_GET['category'];
}

$page_title = "$site_name | MEDIA";
$page_description = '';
$page_keywords = '';
//$style_files[] = "styles/index.css";
//$script_files[] = "scripts/index.js";
include("elements/header.php");
?>

<div id="container">
<div id="content">
<div id="mainLow">

<div id="content-header" class="box">
  <h2><img src="<?php print_file('images/title_media.png'); ?>" alt="MEDIA" /></h2>
<?php if (count($media_category) > 1) { ?>
  <dl class="content-navigation clearfix">
    <dt><img src="images/label_category.png" alt="CATEGORY"></dt>
    <dd>
      <ul class="clearfix">
<?php if (!$current_category) { ?>
        <li><a class="hover current"><?php print_img_text('ALL', 'category', array('_o', '_c')); ?></a></li>
<?php } else { ?>
        <li><a href="<?php echo SITE_URL; ?>/media" class="hover"><?php print_img_text('ALL', 'category', array('_o', '_c')); ?></a></li>
<?php } ?>
<?php foreach ($media_categories as $media_category) { ?>
<?php if ($media_category['id'] == $current_category) { ?>
        <li><a class="hover current"><?php print_img_text($media_category['name'], 'category', array('_o', '_c')); ?></a></li>
<?php } else { ?>
        <li><a href="<?php echo SITE_URL; ?>/media?category=<?php print($media_category['id']); ?>" class="hover"><?php print_img_text($media_category['name'], 'category', array('_o', '_c')); ?></a></li>
<?php } ?>
<?php } ?>
      </ul>
    </dd>
  </dl>
<?php } ?>
</div>

<?php if (!empty($medias)) : ?>
<?php
foreach ($medias as $media) {
  if (($current_category && $current_category != $media['category']) || !$media['enabled']) continue;
  $category = array_get_by_key($media_categories, 'id', $media['category']);
?>
<div class="box schedule">
  <p class="date">
    <?php print(date('n月j日', $media['start_at'])); ?>
<?php if ($media['start_at'] != $media['end_at']) { ?>
    〜 <?php print(date('n月j日', $media['end_at'])); ?>
<?php } ?>
  </p>
  <p class="title"><?php print_text($media['name']); ?></p>
<?php if (count($media_category) > 1) { ?>
  <div class="category"><?php print_img_text($category['name'], 'category'); ?></div>
<?php } ?>
<?php if (preg_match('/^https?:\/\/[^\n]+$/', $media['content'])) { ?>
  <div class="more-button">
    <a href="<?php print($media['content']); ?>" target="_blank" class="hover"><img src="<?php print_file('images/button_more.png'); ?>" alt="MORE" /></a>
  </div>
<?php } else if (!empty($media['content'])) { ?>
  <div class="content">
    <p><?php print_text($media['content']); ?></p>
  </div>
  <div class="buttons">
    <a href="#" class="hover more"><img src="<?php print_file('images/button_more.png'); ?>" alt="MORE" /></a>
    <a href="#" class="hover close"><img src="<?php print_file('images/button_close.png'); ?>" alt="CLOSE" /></a>
  </div>
<?php } ?>
</div><!-- .media -->
<?php } ?>

<?php else : ?>
<div class="box">
  <p>準備中です。</p>
</div>
<?php endif; ?>

</div><!-- .main-with-side -->
<div id="subLow">

<?php include "elements/profile.php"; ?>

</div><!-- sub -->

</div><!-- #content -->
</div><!-- #container -->

<?php include "elements/banners.php"; ?>

<?php include "elements/footer.php"; ?>
