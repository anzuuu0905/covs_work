<?php

$page_title = "プロフィール | {$page_title}";
//$style_files[] = "styles/index.css";
//$page_keywords = '';
//$script_files[] = "scripts/index.js";


$pages = array(
  array(
    'name'  => 'イベント',
    'url'   => 'profile-edit?page=event',
    'data' => load_data('profile_event'),
  ),
  array(
    'name'  => '白',
    'url'   => 'profile-edit?page=shiro',
    'data' => load_data('profile_shiro'),
  ),
  array(
    'name'  => 'メディア',
    'url'   => 'profile-edit?page=media',
    'data' => load_data('profile_media'),
  ),
);

include('elements/header.php');
?>

<div id="content">

<table class="posts">
  <tr>
    <th style="width: 15%;">ページ</th>
    <th style="width: 65%;">内容</th>
    <th style="width: 5%;"></th>
  </tr>
<?php foreach ($pages as $page) : ?>
  <tr>
    <td><?php print_text($page['name']); ?></td>
    <td><?php print_text($page['data']['content']); ?></td>
    <td>
      <form action="<?php print_text($page['url']); ?>&id=<?php print($item['id']); ?>" method="POST">
        <input type="hidden" name="id" value="<?php print($item['id']); ?>" />
        <input type="submit" value="編集">
      </form>
    </td>
  </tr>
<?php endforeach; ?>
</table>

</div><!-- #content -->

<?php include "elements/footer.php"; ?>
