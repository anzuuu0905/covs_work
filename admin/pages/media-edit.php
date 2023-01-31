<?php

//$style_files[] = "styles/index.css";
//$page_keywords = '';
//$script_files[] = "scripts/index.js";

$medias = load_data('media');

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
    $new_media = true;
    $max_id = 0;
    foreach ($medias as $i => $media) {
      if ($max_id < $media['id']) {
        $max_id = $media['id'];
      }
      if (isset($_POST['id']) && $media['id'] == $_POST['id']) {
        $property['id'] = $media['id'];
        $medias[$i] = $property;
        $new_media = false;
        break;
      }
    }
    if ($new_media) {
      $property['id'] = $max_id + 1;
      $medias[] = $property;
    }
    sort_by_key($medias, 'start_at');
    save_data('media', $medias);

    header("Location: media");
    exit;
    break;

  case 'delete':
    foreach ($medias as $i => $media) {
      if ($media['id'] == $_POST['id']) {
        array_splice($medias, $i, 1);
        save_data('media', $medias);
        break;
      }
    }
    header("Location: media");
    exit;
    break;

  default:
    break;
}

if ($_POST['id']) {
  $page_title = '投稿の編集 | ' . $page_title;
  $media_exists = false;
  foreach ($medias as $i => $the_media) {
    if ($the_media['id'] == $_POST['id']) {
      $media = $the_media;
      break;
    }
  }
  if (!$media) {
    header("Location: media");
    exit;
  }

} else {
  $page_title = '新規投稿 | ' . $page_title;
  $media = array(
    'name'     => '',
    'category' => $media_categories[0]['id'],
    'content'  => '',
    'start_at' => time(),
    'end_at'   => time(),
    'enabled'  => 1,
  );
}

include("elements/header.php");
?>

<div id="content">

<p><a href="<?php echo SITE_URL; ?>/media">→保存しないで一覧に戻る</a></p>

<form action="media-edit" method="POST">
  <dl>
    <dt>タイトル</dt>
    <dd><input type="text" name="name" value="<?php print_attr($media['name']); ?>" style="width:40em" /></dd>
    <dt>カテゴリ</dt>
    <dd>
      <select name="category">
<?php foreach ($media_categories as $category) : ?>
        <option value="<?php echo $category['id']; ?>"<?php if ($category['id'] == $media['category']) print(' selected'); ?>><?php print_text($category['name']); ?></option>
<?php endforeach; ?>
      </select>
    </dd>
    <dt>内容（詳細のテキスト、またはリンク先のURL）</dt>
    <dd><textarea name="content" style="width:40em; height: 8em;"><?php print_attr($media['content']); ?></textarea></dd>
    <dt>開始日（例：20120401）</dt>
    <dd><input type="text" name="start_at" value="<?php print_attr(date('Ymd', $media['start_at'])); ?>" style="width:40em" /></dd>
    <dt>終了日（例：20120410）</dt>
    <dd><input type="text" name="end_at" value="<?php print_attr(date('Ymd', $media['end_at'])); ?>" style="width:40em" /></dd>
    <dt>表示状態（チェックを外すとサイトに表示されなくなります。）</dt>
    <dd>
      <input type="checkbox" name="enabled" value="1"<?php if ($media['enabled']) {print(' checked');} ?>> 表示
    </dd>
  </dl>
<?php if ($media['id']) : ?>
  <input type="hidden" name="id" value="<?php print($media['id']); ?>" />
<?php endif; ?>
  <input type="hidden" name="mode" value="edit" />
  <p><input type="submit" value="保存して一覧に戻る"></p>
</form>

<?php if ($_POST['id']) : ?>
<form action="media-edit" method="POST" id="delete">
  <input type="hidden" name="mode" value="delete" />
  <input type="hidden" name="id" value="<?php print($media['id']); ?>" />
  <p><input type="submit" value="この投稿を削除する"></p>
</form>
<?php endif; ?>

</div><!-- #content -->

<?php include "elements/footer.php"; ?>
