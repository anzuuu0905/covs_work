<?php

$page_title = "白 | {$page_title}";
//$style_files[] = "styles/index.css";
//$page_keywords = '';
//$script_files[] = "scripts/index.js";


$items = load_data('shiro');

include('elements/header.php');
?>

<div id="content">

<p><a href="shiro-edit">新規項目を作成</a></p>

<table class="posts">
  <tr>
    <th style="width: 15%;">表示順</th>
    <th style="width: 60%;">項目名</th>
    <th style="width: 10%;">表示状態</th>
    <th style="width: 5%;"></th>
  </tr>
<?php if (!empty($items)) : ?>
<?php foreach ($items as $i => $item) : ?>
  <tr>
    <td>
      <form action="shiro-edit" method="POST">
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
    <td><?php print_text($item['name']); ?></td>
<?php if ($item['enabled']) { ?>
    <td>表示中</td>
<?php } else { ?>
    <td>非表示</td>
<?php } ?>
    <td>
      <form action="shiro-edit?id=<?php print($item['id']); ?>" method="POST">
        <input type="hidden" name="id" value="<?php print($item['id']); ?>" />
        <input type="submit" value="編集">
      </form>
    </td>
  </tr>
<?php endforeach; ?>
<?php endif; ?>
</table>

</div><!-- #content -->

<?php include "elements/footer.php"; ?>
