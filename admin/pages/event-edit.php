<?php

//$style_files[] = "styles/index.css";
//$page_keywords = '';
//$script_files[] = "scripts/index.js";

$events = load_data('events');

switch ($_POST['mode']) {
  case 'edit':
    $property = array(
      'name'     => $_POST['name'],
      'category' => $_POST['category'],
      'content'  => $_POST['content'],
      'start_at' => strtotime($_POST['start_at']),
      'end_at'   => strtotime($_POST['end_at']),
      'enabled'  => $_POST['enabled'],
    );
    $new_event = true;
    $max_id = 0;
    foreach ($events as $i => $event) {
      if ($max_id < $event['id']) {
        $max_id = $event['id'];
      }
      if (isset($_POST['id']) && $event['id'] == $_POST['id']) {
        $property['id'] = $event['id'];
        $events[$i] = $property;
        $new_event = false;
        break;
      }
    }
    if ($new_event) {
      $property['id'] = $max_id + 1;
      $events[] = $property;
    }
    sort_by_key($events, 'start_at');
    save_data('events', $events);

    header("Location: event");
    exit;
    break;

  case 'delete':
    foreach ($events as $i => $event) {
      if ($event['id'] == $_POST['id']) {
        array_splice($events, $i, 1);
        save_data('events', $events);
        break;
      }
    }
    header("Location: event");
    exit;
    break;

  default:
    break;
}

if ($_POST['id']) {
  $page_title = 'イベントの編集 | ' . $page_title;
  $event_exists = false;
  foreach ($events as $i => $the_event) {
    if ($the_event['id'] == $_POST['id']) {
      $event = $the_event;
      break;
    }
  }
  if (!$event) {
    header("Location: event");
    exit;
  }

} else {
  $page_title = '新規イベント | ' . $page_title;
  $event = array(
    'name'     => '',
    'category' => $event_categories[0]['id'],
    'content'  => '',
    'start_at' => time(),
    'end_at'   => time(),
    'enabled'  => 1,
  );
}

include("elements/header.php");
?>

<div id="content">

<p><a href="<?php echo SITE_URL; ?>/event">→保存しないで一覧に戻る</a></p>

<form action="event-edit" method="POST">
  <dl>
    <dt>イベント名</dt>
    <dd><input type="text" name="name" value="<?php print_attr($event['name']); ?>" style="width:40em" /></dd>
    <dt>カテゴリ</dt>
    <dd>
      <select name="category">
<?php foreach ($event_categories as $category) : ?>
        <option value="<?php echo $category['id']; ?>"<?php if ($category['id'] == $event['category']) print(' selected'); ?>><?php print_text($category['name']); ?></option>
<?php endforeach; ?>
      </select>
    </dd>
    <dt>内容（詳細のテキスト、またはリンク先のURL）</dt>
    <dd><textarea name="content" style="width:40em; height: 8em;"><?php print_attr($event['content']); ?></textarea></dd>
    <dt>開始日（例：20120401）</dt>
    <dd><input type="text" name="start_at" value="<?php print_attr(date('Ymd', $event['start_at'])); ?>" style="width:40em" /></dd>
    <dt>終了日（例：20120410）</dt>
    <dd><input type="text" name="end_at" value="<?php print_attr(date('Ymd', $event['end_at'])); ?>" style="width:40em" /></dd>
    <dt>表示状態（チェックを外すとサイトに表示されなくなります。）</dt>
    <dd>
      <input type="checkbox" name="enabled" value="1"<?php if ($event['enabled']) {print(' checked');} ?>> 表示
    </dd>
  </dl>
<?php if ($event['id']) : ?>
  <input type="hidden" name="id" value="<?php print($event['id']); ?>" />
<?php endif; ?>
  <input type="hidden" name="mode" value="edit" />
  <p><input type="submit" value="保存して一覧に戻る"></p>
</form>

<?php if ($_POST['id']) : ?>
<form action="event-edit" method="POST" id="delete">
  <input type="hidden" name="mode" value="delete" />
  <input type="hidden" name="id" value="<?php print($event['id']); ?>" />
  <p><input type="submit" value="このイベントを削除する"></p>
</form>
<?php endif; ?>

</div><!-- #content -->

<?php include "elements/footer.php"; ?>
