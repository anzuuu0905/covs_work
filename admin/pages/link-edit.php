<?php

//$style_files[] = "styles/index.css";
//$page_keywords = '';
//$script_files[] = "scripts/index.js";

$callback_url = 'link';

if (empty($_GET['category'])) {
  header("Location: {$callback_url}");
  exit;
  break;
}
$data_name = 'link';
$link_groups = load_data($data_name);
$category = $_GET['category'];

switch ($_POST['mode']) {
  case 'edit':
    $property = array(
      'id'      => null,
      'title'   => $_POST['title'],
      'name'    => $_POST['name'],
      'url'     => $_POST['url'],
      'enabled' => $_POST['enabled'],
    );
    $new_item = true;
    $max_id = 0;
    foreach ($link_groups[$category] as $i => $item) {
      if ($max_id < $item['id']) {
        $max_id = $item['id'];
      }
      if (isset($_POST['id']) && $item['id'] == $_POST['id']) {
        $property['id'] = $item['id'];
        $link_groups[$category][$i] = $property;
        $new_item = false;
        break;
      }
    }
    if ($new_item) {
      $property['id'] = $max_id + 1;
      $link_groups[$category][] = $property;
    }
    save_data($data_name, $link_groups);

    header("Location: {$callback_url}");
    exit;
    break;

  case 'delete':
    foreach ($link_groups[$category] as $i => $item) {
      if ($item['id'] == $_POST['id']) {
        array_splice($link_groups[$category], $i, 1);
        save_data($data_name, $link_groups);
        break;
      }
    }
    header("Location: {$callback_url}");
    exit;
    break;

  case 'order':
    if (isset($_POST['id']) && isset($_POST['order'])) {
      foreach ($link_groups[$category] as $i => $tmp_item) {
        if ($tmp_item['id'] == $_POST['id']) {
          $original_key = $i;
        }
      }
      if (isset($original_key)) {
        if (array_move($link_groups[$category], $original_key, $_POST['order'])) {
          save_data($data_name, $link_groups);
        }
      }
    }
    header("Location: {$callback_url}");
    exit;
    break;

  default:
    break;
}

if (isset($_GET['id'])) {
  $page_title = 'リンクの編集 | ' . $page_title;
  $item_exists = false;
  foreach ($link_groups[$category] as $i => $tmp_item) {
    if ($tmp_item['id'] == $_GET['id']) {
      $item = $tmp_item;
      break;
    }
  }
  if (!isset($item)) {
    header("Location: {$callback_url}");
    exit;
  }

} else {
  $page_title = '新規リンク | ' . $page_title;
  $item = array(
    'id'       => null,
    'title'     => '',
    'name'     => '',
    'url'      => '',
    'enabled'  => 1,
  );
}

include("elements/header.php");
?>

<div id="content">

<p><a href="<?php print(SITE_URL . '/' . $callback_url); ?>">→保存しないで一覧に戻る</a></p>

<form action="" method="POST">
  <dl>
    <dt>肩書き</dt>
    <dd><input type="text" name="title" value="<?php print_attr($item['title']); ?>" style="width:40em" /></dd>
    <dt>名前</dt>
    <dd><input type="text" name="name" value="<?php print_attr($item['name']); ?>" style="width:40em" /></dd>
    <dt>URL</dt>
    <dd><input type="text" name="url" value="<?php print_attr($item['url']); ?>" style="width:40em" /></dd>
    <dt>表示状態（チェックを外すとサイトに表示されなくなります。）</dt>
    <dd><input type="checkbox" name="enabled" value="1"<?php if ($item['enabled']) print(' checked'); ?>> 表示</dd>
  </dl>
<?php if ($item['id']) : ?>
  <input type="hidden" name="id" value="<?php print($item['id']); ?>" />
<?php endif; ?>
  <input type="hidden" name="mode" value="edit" />
  <p><input type="submit" value="保存して一覧に戻る"></p>
</form>

<?php if ($item['id']) : ?>
<form action="" method="POST" id="delete">
  <input type="hidden" name="mode" value="delete" />
  <input type="hidden" name="id" value="<?php print($item['id']); ?>" />
  <p><input type="submit" value="この項目を削除する"></p>
</form>
<?php endif; ?>

</div><!-- #content -->

<?php include "elements/footer.php"; ?>
