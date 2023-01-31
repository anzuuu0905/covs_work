<?php

$page_title = "バナー | {$page_title}";
//$style_files[] = "styles/index.css";
//$page_keywords = '';
//$script_files[] = "scripts/index.js";


$pages = array(
  array(
    'name'  => 'イベント',
    'url'   => 'banner-edit?page=event',
    'items' => load_data('banner_event'),
  ),
  array(
    'name'  => '白',
    'url'   => 'banner-edit?page=shiro',
    'items' => load_data('banner_shiro'),
  ),
  array(
    'name'  => 'メディア',
    'url'   => 'banner-edit?page=media',
    'items' => load_data('banner_media'),
  ),
  array(
    'name'  => 'リンク',
    'url'   => 'banner-edit?page=link',
    'items' => load_data('banner_link'),
  ),
);

include('elements/header.php');
?>

<div id="content">

<?php foreach ($pages as $page) : ?>

<h2><?php print_text($page['name']); ?></h2>

<p><a href="<?php print($page['url']); ?>">新規項目を作成</a></p>

<table class="posts">
  <tr>
    <th style="width: 15%;">表示順</th>
    <th style="width: 15%;">リンク先名</th>
    <th style="width: 15%;">URL</th>
    <th style="width: 30%;">画像</th>
    <th style="width: 10%;">表示状態</th>
    <th style="width: 5%;"></th>
  </tr>
<?php if (!empty($page['items'])) : ?>
<?php foreach ($page['items'] as $i => $item) : ?>
  <tr>
    <td>
      <form action="<?php print_text($page['url']); ?>" method="POST">
        <input type="hidden" name="mode" value="order" />
        <input type="hidden" name="id" value="<?php print($item['id']); ?>" />
        <select name="order" class="autosubmit">
<?php foreach ($page['items'] as $j => $tmp_item) : ?>
<?php if ($i == $j) : ?>
          <option selected value="<?php print($j); ?>"><?php print($j + 1); ?>番目</option>
<?php else : ?>
          <option value="<?php print($j); ?>"><?php print($j + 1); ?>番目に移動</option>
<?php endif; ?>
<?php endforeach; ?>
        </select>
      </form>
    </td>
    <td><?php print_text($item['name']); ?></td>
    <td><?php print_text($item['url']); ?></td>
    <td><img src="<?php print_text('../' . $item['path']); ?>" alt="<?php print_text($item['name']); ?>" /></td>
    <td><?php print_text($item['enabled'] ? '表示中' : '非表示'); ?></td>
    <td>
      <form action="<?php print_text($page['url']); ?>&id=<?php print($item['id']); ?>" method="POST">
        <input type="hidden" name="id" value="<?php print($item['id']); ?>" />
        <input type="submit" value="編集">
      </form>
    </td>
  </tr>
<?php endforeach; ?>
<?php endif; ?>
</table>

<?php endforeach; ?>

</div><!-- #content -->

<?php include "elements/footer.php"; ?>
