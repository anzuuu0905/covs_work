<?php

$page_title = "イベント | {$page_title}";
//$style_files[] = "styles/index.css";
//$page_keywords = '';
//$script_files[] = "scripts/index.js";


$events = load_data('events');

include('elements/header.php');
?>

<div id="content">

<p><a href="event-edit">新規イベントを作成</a></p>

<table class="posts">
  <tr>
    <th style="width: 40%;">イベント名</th>
    <th style="width: 15%;">カテゴリ</th>
    <th style="width: 10%;">開始日</th>
    <th style="width: 10%;">終了日</th>
    <th style="width: 10%;">表示状態</th>
    <th style="width: 5%;"></th>
  </tr>
<?php if (!empty($events)) : ?>
<?php foreach ($events as $event) : ?>
<?php $category = array_get_by_key($event_categories, 'id', $event['category']); ?>
  <tr>
    <td><?php print_text($event['name']); ?></td>
    <td><?php print_text($category['name']); ?></td>
    <td><?php print(date('Y/m/d', $event['start_at'])); ?></td>
    <td><?php print(date('Y/m/d', $event['end_at'])); ?></td>
<?php if ($event['enabled']) { ?>
    <td>表示中</td>
<?php } else { ?>
    <td>非表示</td>
<?php } ?>
    <td>
      <form action="event-edit" method="POST">
        <input type="hidden" name="id" value="<?php print($event['id']); ?>" />
        <input type="submit" value="編集">
      </form>
    </td>
  </tr>
<?php endforeach; ?>
<?php endif; ?>
</table>

</div><!-- #content -->

<?php include "elements/footer.php"; ?>
