<?php
$shiro_categories = load_data('shiro');
$profile = load_data('profile_shiro');
$banners = load_data('banner_shiro');

if ($_GET['category']) {
  $shiro = array_get_by_key($shiro_categories, 'id', $_GET['category']);
}
if (!isset($shiro) || !$shiro['enabled']) {
  foreach ($shiro_categories as $shiro_category){
    if ($shiro_category['enabled']) {
      $shiro = $shiro_category;
      break;
    }
  }
}
if (!isset($shiro) || !$shiro['enabled']) {
  // TODO 表示物がない場合の処理
}

$page_title = "$site_name | 白";
$page_description = '';
$page_keywords = 'Hakuba,local,gourmet,hamburger,sweets,ice,cream,Nagano,dinner,lunch,sake,tasting,culture,tour,drum,taiko,tea,ceremony,Japanese,food,meal,evening,performance,alcohol,world,luxury,hotel,awards,2012,shirouma-so,ryokan,hotel,accomodation,白馬,ご当地グルメ,ご当地バーガー,ご当地スイーツ,白旨バーガー,白旨ライスバーガー,白バーガー,白馬バーガー,しろうまバーガー,しろうまサンド,白馬サンド,白旨,雪玉あいす,アイスクリーム,しろうま荘,ワールド,ラグジュリー,ラグジュアリー,ホテル,アワード,アワーズ,ノミネート,長野,カルチャー,イブニング,ツアー,利き酒,日本酒,テイスティング,地酒,和太鼓,文化体験,ディナー,外国人,人気,アトラクション,郷土料理';
//$style_files[] = "styles/index.css";
//$script_files[] = "scripts/index.js";
include("elements/header.php");
?>

<div id="container">
<div id="content">
<div id="mainLow">

<div id="content-header" class="box">
  <h2><img src="<?php print_file('images/title_shiro.png'); ?>" alt="白" /></h2>
  <dl class="content-navigation clearfix">
    <dt><img src="images/label_category.png" alt="CATEGORY"></dt>
    <dd>
      <ul class="clearfix">
<?php
foreach ($shiro_categories as $shiro_category) :
  if (!$shiro_category['enabled']) continue;
?>
<?php if ($shiro_category['id'] == $shiro['id']) { ?>
        <li><a class="hover current"><?php print_img_text($shiro_category['name'], 'category', array('_o', '_c')); ?></a></li>
<?php } else { ?>
        <li><a href="<?php echo SITE_URL; ?>/shiro?category=<?php print($shiro_category['id']); ?>" class="hover"><?php print_img_text($shiro_category['name'], 'category', array('_o', '_c')); ?></a></li>
<?php } ?>
<?php endforeach; ?>
      </ul>
    </dd>
  </dl>
</div>

<div class="shiro box">
  <h3><?php print_img_text($shiro['name'], 'h3'); ?></h3>
  <p><?php print($shiro['content']); ?></p>
<?php if (!empty($shiro['images'])) { ?>
  <ul class="images clearfix">
<?php foreach ($shiro['images'] as $image) { ?>
    <li><a href="<?php print(SITE_URL . '/' . $image['path']); ?>" target="_blank"><img src="<?php print_file($image['path']); ?>" alt=""></a></li>
<?php } ?>
  </ul>
  <div class="large-image"><img src="<?php print_file($shiro['images'][0]['path']); ?>" alt=""></div>
<?php } ?>
</div><!-- .shiro -->

</div><!-- .main-with-side -->
<div id="subLow">

<?php include "elements/profile.php"; ?>

</div><!-- sub -->

</div><!-- #content -->
</div><!-- #container -->

<?php include "elements/banners.php"; ?>

<?php include "elements/footer.php"; ?>
