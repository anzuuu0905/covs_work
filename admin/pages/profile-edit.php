<?php

//$style_files[] = "styles/index.css";
//$page_keywords = '';
//$script_files[] = "scripts/index.js";


$callback_url = 'profile';

switch ($_GET['page']) {
  case 'event':
    $data_name = 'profile_event';
    break;
  case 'shiro':
    $data_name = 'profile_shiro';
    break;
  case 'media':
    $data_name = 'profile_media';
    break;
  default:
    header("Location: {$callback_url}");
    exit;
    break;
}

$data = load_data($data_name);

switch ($_POST['mode']) {
  case 'edit':
    $item = array(
      'content' => $_POST['content'],
    );
    save_data($data_name, $item);

    header("Location: {$callback_url}");
    exit;
    break;

  default:
    break;
}

$page_title = 'プロフィールの編集 | ' . $page_title;
$item = load_data($data_name);
if (!$item) {
  $item = array(
    'content' => '',
  );
}

include("elements/header.php");
?>

<div id="content">

<p><a href="<?php print(SITE_URL . '/' . $callback_url); ?>">→保存しないで一覧に戻る</a></p>

<form action="" method="POST">
  <dl>
    <dt>内容</dt>
    <dd><textarea name="content" style="width:40em;height:10em;"><?php print($item['content']); ?></textarea></dd>
  </dl>
  <input type="hidden" name="mode" value="edit" />
  <p><input type="submit" value="保存して一覧に戻る"></p>
</form>

</div><!-- #content -->

<?php include "elements/footer.php"; ?>
