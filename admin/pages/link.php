<?php

$page_title = "リンク | {$page_title}";
//$style_files[] = "styles/index.css";
//$page_keywords = '';
//$script_files[] = "scripts/index.js";

$link_groups = load_data('link');

include('elements/header.php');
?>

<div id="content">

<?php foreach ($link_categories as $link_category) : ?>

<?php
$items = $link_groups[$link_category['id']];
$url = "link-edit?category={$link_category['id']}";
?>

<h2><?php print_text($link_category['name']); ?></h2>

<p><a href="<?php print($url); ?>">新規項目を作成</a></p>

<table class="posts">
  <tr>
    <th style="width: 15%;">表示順</th>
    <th style="width: 20%;">肩書き</th>
    <th style="width: 20%;">名前</th>
    <th style="width: 20%;">URL</th>
    <th style="width: 10%;">表示状態</th>
    <th style="width: 5%;"></th>
  </tr>
<?php if (!empty($items)) : ?>
<?php foreach ($items as $i => $item) : ?>
  <tr>
    <td>
      <form action="<?php print($url); ?>" method="POST">
        <input type="hidden" name="mode" value="order" />
        <input type="hidden" name="id" value="<?php print($item['id']); ?>" />
        <select name="order" class="autosubmit">
<?php foreach ($items as $j => $tmp_item) : ?>
<?php if ($i == $j) : ?>
          <option selected value="<?php print($j); ?>"><?php print($j + 1); ?>番目</option>
<?php else : ?>
          <option value="<?php print($j); ?>"><?php print($j + 1); ?>番目に移動</option>
<?php endif; ?>
<?php endforeach; ?>
        </select>
      </form>
    </td>
    <td><?php print_text($item['title']); ?></td>
    <td><?php print_text($item['name']); ?></td>
    <td><?php print_text($item['url']); ?></td>
    <td><?php print_text($item['enabled'] ? '表示中' : '非表示'); ?></td>
    <td>
      <form action="<?php print($url); ?>&id=<?php print($item['id']); ?>" method="POST">
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
