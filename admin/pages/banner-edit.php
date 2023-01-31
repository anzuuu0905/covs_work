<?php

//$style_files[] = "styles/index.css";
//$page_keywords = '';
//$script_files[] = "scripts/index.js";


$callback_url = 'banner';

switch ($_GET['page']) {
  case 'event':
    $data_name = 'banner_event';
    break;
  case 'shiro':
    $data_name = 'banner_shiro';
    break;
  case 'media':
    $data_name = 'banner_media';
    break;
  case 'link':
    $data_name = 'banner_link';
    break;
  default:
    header("Location: {$callback_url}");
    exit;
    break;
}

$items = load_data($data_name);

switch ($_POST['mode']) {
  case 'edit':
    $property = array(
      'id'      => null,
      'name'    => $_POST['name'],
      'url'     => $_POST['url'],
      'path'    => '',
      'enabled' => $_POST['enabled'],
    );
    $new_item = true;
    $max_id = 0;
    foreach ($items as $i => $item) {
      if ($max_id < $item['id']) {
        $max_id = $item['id'];
      }
      if (isset($_POST['id']) && $item['id'] == $_POST['id']) {
        $property['id'] = $item['id'];
        $file_name = "images/{$data_name}_{$item['id']}.png";
        if (isset($_FILES['image']) && save_image($_FILES['image']['tmp_name'], "../{$file_name}", false, $banner_max_height, 'image/png')) {
          $property['path'] = $file_name;
        } else {
          $property['path'] = $item['path'];
        }
        $items[$i] = $property;
        $new_item = false;
        break;
      }
    }
    if ($new_item) {
      $property['id'] = $max_id + 1;
      $file_name = "images/{$data_name}_{$property['id']}.png";
      if (isset($_FILES['image']) && save_image($_FILES['image']['tmp_name'], "../{$file_name}", false, $banner_max_height, 'image/png')) {
        $property['path'] = $file_name;
      }
      $items[] = $property;
    }
    save_data($data_name, $items);

    header("Location: {$callback_url}");
    exit;
    break;

  case 'delete':
    foreach ($items as $i => $item) {
      if ($item['id'] == $_POST['id']) {
        array_splice($items, $i, 1);
        save_data($data_name, $items);
        break;
      }
    }
    header("Location: {$callback_url}");
    exit;
    break;

  case 'order':
    if (isset($_POST['id']) && isset($_POST['order'])) {
      foreach ($items as $i => $tmp_item) {
        if ($tmp_item['id'] == $_POST['id']) {
          $original_key = $i;
        }
      }
      if (isset($original_key)) {
        if (array_move($items, $original_key, $_POST['order'])) {
          save_data($data_name, $items);
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
  $page_title = 'バナーの編集 | ' . $page_title;
  $item_exists = false;
  foreach ($items as $i => $tmp_item) {
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
  $page_title = '新規バナー | ' . $page_title;
  $item = array(
    'id'       => null,
    'name'     => '',
    'url'      => '',
    'path'     => '',
    'enabled'  => 1,
  );
}

include("elements/header.php");
?>

<div id="content">

<p><a href="<?php print(SITE_URL . '/' . $callback_url); ?>">→保存しないで一覧に戻る</a></p>

<form action="" method="POST" ENCTYPE="MULTIPART/FORM-DATA">
  <dl>
    <dt>リンク先名</dt>
    <dd><input type="text" name="name" value="<?php print_attr($item['name']); ?>" style="width:40em" /></dd>
    <dt>URL</dt>
    <dd><input type="text" name="url" value="<?php print_attr($item['url']); ?>" style="width:40em" /></dd>
    <dt>画像</dt>
    <dd>
<?php if ($item['path']) : ?>
      <img src="<?php print_file('../' . $item['path']); ?>" alt="<?php print_attr($item['name']); ?>" /><br />
<?php endif; ?>
      <input type="file" name="image" />
    </dd>
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
