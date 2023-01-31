<?php

$page_title = "メディア | {$page_title}";
//$style_files[] = "styles/index.css";
//$page_keywords = '';
//$script_files[] = "scripts/index.js";


$medias = load_data('media');

include('elements/header.php');
?>

<div id="content">

<p><a href="media-edit">新規投稿を作成</a></p>

<table class="posts">
  <tr>
    <th style="width: 40%;">タイトル</th>
    <th style="width: 15%;">カテゴリ</th>
    <th style="width: 10%;">開始日</th>
    <th style="width: 10%;">終了日</th>
    <th style="width: 10%;">表示状態</th>
    <th style="width: 5%;"></th>
  </tr>
<?php if (!empty($medias)) : ?>
<?php foreach ($medias as $media) : ?>
<?php $category = array_get_by_key($media_categories, 'id', $media['category']); ?>
  <tr>
    <td><?php print_text($media['name']); ?></td>
    <td><?php print_text($category['name']); ?></td>
    <td><?php print(date('Y/m/d', $media['start_at'])); ?></td>
    <td><?php print(date('Y/m/d', $media['end_at'])); ?></td>
<?php if ($media['enabled']) { ?>
    <td>表示中</td>
<?php } else { ?>
    <td>非表示</td>
<?php } ?>
    <td>
      <form action="media-edit" method="POST">
        <input type="hidden" name="id" value="<?php print($media['id']); ?>" />
        <input type="submit" value="編集">
      </form>
    </td>
  </tr>
<?php endforeach; ?>
<?php endif; ?>
</table>

</div><!-- #content -->

<?php include "elements/footer.php"; ?>
