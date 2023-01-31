<?php

//$style_files[] = "styles/index.css";
//$page_keywords = '';
//$script_files[] = "scripts/index.js";

$items = load_data('shiro');

switch ($_POST['mode']) {
  case 'edit':
    $property = array(
      'id'       => null,
      'name'     => $_POST['name'],
      'content'  => $_POST['content'],
      'enabled'  => $_POST['enabled'],
      'images'   => array(),
    );
    $new_item = true;
    $max_id = 0;
    foreach ($items as $i => $item) {
      if ($max_id < $item['id']) {
        $max_id = $item['id'];
      }
      if (isset($_POST['id']) && $item['id'] == $_POST['id']) {
        $property['id'] = $item['id'];
        $property['images'] = $item['images'];
        $items[$i] = $property;
        $new_item = false;
        break;
      }
    }
    if ($new_item) {
      $property['id'] = $max_id + 1;
      $items[] = $property;
    }
    save_data('shiro', $items);

    header("Location: shiro");
    exit;
    break;

  case 'delete':
    foreach ($items as $i => $item) {
      if ($item['id'] == $_POST['id']) {
        array_splice($items, $i, 1);
        save_data('shiro', $items);
        break;
      }
    }
    header("Location: shiro");
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
          save_data('shiro', $items);
        }
      }
    }
    header("Location: shiro");
    exit;
    break;

  default:
    break;
}

if (isset($_GET['id'])) {
  $page_title = '項目の編集 | ' . $page_title;
  $item_exists = false;
  foreach ($items as $i => $tmp_item) {
    if ($tmp_item['id'] == $_GET['id']) {
      $item = $tmp_item;
      break;
    }
  }
  if (!isset($item)) {
    header("Location: shiro");
    exit;
  }

} else {
  $page_title = '新規項目 | ' . $page_title;
  $item = array(
    'id'       => null,
    'name'     => '',
    'content'  => '',
    'enabled'  => 1,
    'images'   => array(),
  );
}

include("elements/header.php");
?>

<div id="content">

<p><a href="<?php echo SITE_URL; ?>/shiro">→保存しないで一覧に戻る</a></p>

<form action="shiro-edit" method="POST">
  <dl>
    <dt>項目名</dt>
    <dd><input type="text" name="name" value="<?php print_attr($item['name']); ?>" style="width:40em" /></dd>
    <dt>説明 (HTML)</dt>
    <dd><textarea name="content" style="width:40em; height: 8em;"><?php print_attr($item['content']); ?></textarea></dd>
    <dt>表示状態（チェックを外すとサイトに表示されなくなります。）</dt>
    <dd>
      <input type="checkbox" name="enabled" value="1"<?php if ($item['enabled']) {print(' checked');} ?>> 表示
    </dd>
  </dl>
<?php if ($item['id']) : ?>
  <input type="hidden" name="id" value="<?php print($item['id']); ?>" />
<?php endif; ?>
  <input type="hidden" name="mode" value="edit" />
  <p><input type="submit" value="保存して一覧に戻る"></p>
</form>

<?php if ($item['id']) : ?>
<form action="shiro-edit" method="POST" id="delete">
  <input type="hidden" name="mode" value="delete" />
  <input type="hidden" name="id" value="<?php print($item['id']); ?>" />
  <p><input type="submit" value="この項目を削除する"></p>
</form>
<?php endif; ?>

<?php if ($item['id']) : ?>
<form action="shiro-image" method="POST" ENCTYPE="MULTIPART/FORM-DATA">
  <input type="hidden" name="mode" value="add" />
  <input type="hidden" name="id" value="<?php print($item['id']); ?>" />
  <p>画像を追加：<input type="file" name="image" class="autosubmit" /></p>
</form>

<table class="posts">
  <tr>
    <th style="width: 15%;">表示順</th>
    <th style="width: 60%;">画像</th>
    <th style="width: 5%;"></th>
  </tr>
<?php foreach ($item['images'] as $i => $image) : ?>
  <tr>
    <td>
      <form action="shiro-image" method="POST">
        <input type="hidden" name="mode" value="order" />
        <input type="hidden" name="id" value="<?php print($item['id']); ?>" />
        <input type="hidden" name="image_id" value="<?php print($image['id']); ?>" />
        <select name="order" class="autosubmit">
<?php foreach ($item['images'] as $j => $tmp_image) : ?>
<?php if ($i == $j) : ?>
          <option selected value="<?php print($j); ?>"><?php print($j + 1); ?>番目</option>
<?php else : ?>
          <option value="<?php print($j); ?>"><?php print($j + 1); ?>番目に移動</option>
<?php endif; ?>
<?php endforeach; ?>
        </select>
      </form>
    </td>
    <td><img src="<?php print_file('../' . $image['path']); ?>" alt="" /></td>
    <td>
      <form action="shiro-image" method="POST">
        <input type="hidden" name="mode" value="delete" />
        <input type="hidden" name="id" value="<?php print($item['id']); ?>" />
        <input type="hidden" name="image_id" value="<?php print($image['id']); ?>" />
        <input type="submit" value="削除" class="delete" />
      </form>
    </td>
  </tr>
<?php endforeach; ?>
</table>
<?php else : ?>
<p>項目を保存するまで画像は追加できません。</p>
<?php endif; ?>

</div><!-- #content -->

<?php include "elements/footer.php"; ?>
