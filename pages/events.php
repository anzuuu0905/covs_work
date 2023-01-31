<?php
$events = load_data('events');
$profile = load_data('profile_event');
$banners = load_data('banner_event');

$current_category = 0;
if (isset($_GET['category'])) {
  $current_category = $_GET['category'];
}

$page_title = "$site_name | EVENTS";
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
  <h2><img src="<?php print_file('images/title_events.png'); ?>" alt="EVENTS" /></h2>
  <dl class="content-navigation clearfix">
    <dt><img src="images/label_category.png" alt="CATEGORY"></dt>
    <dd>

      <ul class="clearfix">
<?php if (!$current_category) { ?>
        <li><a class="hover current"><?php print_img_text('ALL', 'category', array('_o', '_c')); ?></a></li>
<?php } else { ?>
        <li><a href="<?php echo SITE_URL; ?>/events" class="hover"><?php print_img_text('ALL', 'category', array('_o', '_c')); ?></a></li>
<?php } ?>
<?php foreach ($event_categories as $event_category) { ?>
<!--
<?php echo print_r($image_file = get_text_image('$text', $style));?>
<?php print_img_text('abc','def','ghi');?>
<pre>event_category<br>
<?php echo print_r($event_category); ?>
</pre><br>
-->
<!--
<pre>current_category<br>
<?php echo print_r($current_category); ?>
</pre><br>
-->
<?php if ($event_category['id'] == $current_category) { ?>
        <li><a class="hover current"><?php print_img_text($event_category['name'], 'category', array('_o', '_c')); ?></a></li>
<?php } else { ?>
        <li><a href="<?php echo SITE_URL; ?>/events?category=<?php print($event_category['id']); ?>" class="hover"><?php print_img_text($event_category['name'], 'category', array('_o', '_c')); ?></a></li>
<?php } ?>
<?php } ?>
      </ul>
    </dd>
  </dl>
</div>

<?php if (!empty($events)) : ?>
<?php
foreach ($events as $event) {
  if (($current_category && $current_category != $event['category']) || !$event['enabled']) continue;
  $category = array_get_by_key($event_categories, 'id', $event['category']);
?>
<div class="box schedule">
  <p class="date">
    <?php print(date('n月j日', $event['start_at'])); ?>
<?php if ($event['start_at'] != $event['end_at']) { ?>
    〜 <?php print(date('n月j日', $event['end_at'])); ?>
<?php } ?>
  </p>
  <p class="title"><?php print_text($event['name']); ?></p>
  <div class="category"><?php print_img_text($category['name'], 'category'); ?></div>
<?php if (preg_match('/^https?:\/\/[^\n]+$/', $event['content'])) { ?>
  <div class="more-button">
    <a href="<?php print($event['content']); ?>" target="_blank" class="hover"><img src="<?php print_file('images/button_more.png'); ?>" alt="MORE" /></a>
  </div>
<?php } else if (!empty($event['content'])) { ?>
  <div class="content">
    <p><?php print_text($event['content']); ?></p>
  </div>
  <div class="buttons">
    <a href="#" class="hover more"><img src="<?php print_file('images/button_more.png'); ?>" alt="MORE" /></a>
    <a href="#" class="hover close"><img src="<?php print_file('images/button_close.png'); ?>" alt="CLOSE" /></a>
  </div>
<?php } ?>
</div><!-- .event -->
<?php } ?>

<?php else : ?>
<div class="event">
  <p>現在開催予定のイベントはありません。</p>
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
