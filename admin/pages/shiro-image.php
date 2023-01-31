<?php
$items = load_data('shiro');

switch ($_POST['mode']) {
  case 'add':
    if (!isset($_POST['id']) || !isset($_FILES['image'])) {
      break;
    }
    foreach ($items as $i => $item) {
      if ($item['id'] == $_POST['id']) {
        $max_id = 0;
        foreach ($item['images'] as $image) {
          if ($max_id < $image['id']) {
            $max_id = $image['id'];
          }
        }
        $new_id = $max_id + 1;
        $file_name = "images/shiro_{$item['id']}_{$new_id}.jpg";
        if (save_image($_FILES['image']['tmp_name'], "../{$file_name}", $shiro_image_max_width, false, 'image/jpeg')) {
          $items[$i]['images'][] = array(
            'id'   => $new_id,
            'path' => $file_name,
          );
          save_data('shiro', $items);
        }
        break;
      }
    }
    break;

  case 'delete':
    if (!isset($_POST['id']) || !isset($_POST['image_id']) || isset($_POST['order'])) {
      break;
    }
    foreach ($items as $i => $item) {
      if ($item['id'] != $_POST['id']) continue;
      foreach ($item['images'] as $j => $image) {
        if ($image['id'] != $_POST['image_id']) continue;
        unlink("../{$image['path']}");
        array_splice($items[$i]['images'], $j, 1);
        save_data('shiro', $items);
        break;
      }
      break;
    }
    break;

  case 'order':
    if (!isset($_POST['id']) || !isset($_POST['image_id']) || !isset($_POST['order'])) {
      break;
    }
    foreach ($items as $i => $tmp_item) {
      if ($tmp_item['id'] != $_POST['id']) continue;
      foreach ($tmp_item['images'] as $j => $image) {
        if ($image['id'] != $_POST['image_id']) continue;
        $target_id = $i;
        $original_key = $j;
        break;
      }
      break;
    }
    if (isset($target_id) && isset($original_key)) {
      if (array_move($items[$target_id]['images'], $original_key, $_POST['order'])) {
        save_data('shiro', $items);
      }
    }
    break;

  default:
    break;
}

header("Location: shiro-edit?id={$_POST['id']}");
exit;
?>
