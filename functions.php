<?php

/**
 * 外部ファイル用のURL（変更日時をmd5したクエリを付与した絶対パス）を出力
 * @param string $url サイトトップからの相対パス
 */
function print_file($url) {
	print(SITE_URL . '/' . $url . "?" . md5(date("YmdHis", filemtime($url))));
}

/**
 * 文字列をXHTML用に変換して出力
 * @param $text 出力する文字列
 */
function print_text($text) {
	$text = stripslashes($text);
	$text = htmlspecialchars($text, ENT_QUOTES);
	$text = str_replace("\n", '<br />', $text);
	print($text);
}


/**
 * 文字列をHTMLタグの属性値用に変換して出力
 * @param $text 出力する文字列
 */
function print_attr($text) {
	$text = stripslashes($text);
	$text = htmlspecialchars($text, ENT_QUOTES);
	print($text);
}


/**
 * ファイル名に使えない文字をアンダーバーに変換
 * @param string $name
 * @return string
 */
function escape_file_name($name) {
  $invalid_chars = array('/');  // 変換対象
  $replace_char = '_';
  return str_replace($invalid_chars, $replace_char, $name);
}


/**
 * テキスト画像のファイルを生成
 * @param string $text 画像を生成するテキスト
 * @param string $style スタイル名
 * @param string $suffix スタイル名の接尾語（スタイル名と接尾語つきのスタイル名両方を読み込む）
 * @return string ファイルのパス
 */
function get_text_image($text, $style = false, $suffix = '') {
  /* スタイルを設定 */
  $style_file = TEXT_STYLE_DIRECTORY . TEXT_STYLE_DEFAULT . '.php';
  include($style_file);
  if ($style && file_exists(TEXT_STYLE_DIRECTORY . $style . $suffix . '.php')) {
    include(TEXT_STYLE_DIRECTORY . $style . '.php');
    $style_file = TEXT_STYLE_DIRECTORY . $style . $suffix . '.php';
    include($style_file);
  } else {
    $style = TEXT_STYLE_DEFAULT;
  }
  // フォントサイズの指定をピクセル単位に変換(GDのフォントの単位が不明なので適当)
  $font_size = $font_size * 0.74;

  /* ファイルが作成済でないなら、画像ファイルを生成して保存 */
  $file_name = $style . '_' . escape_file_name($text) . $suffix . '.' . $file_type;
  if (!file_exists(TEXT_IMAGE_DIRECTORY . $file_name)
      || (filemtime(TEXT_IMAGE_DIRECTORY . $file_name) < filemtime($style_file))
      || (filemtime(TEXT_IMAGE_DIRECTORY . $file_name) < filemtime(TEXT_STYLE_DIRECTORY . $style . '.php'))
  ) {
    //日本語フォントは高さが高い（？）ため、上余白を大きめにとる
    $margin[0] = $margin[0] + round($font_size * 0.25);
    
    //フォントのアンチエイリアス処理が微妙なため、3倍に描画したあとで1/3に縮小する
    $resample_ratio = 3;
    $font_size = $font_size * $resample_ratio;
    $margin[0] = $margin[0] * $resample_ratio;
    $margin[1] = $margin[1] * $resample_ratio;
    $margin[2] = $margin[2] * $resample_ratio;
    $margin[3] = $margin[3] * $resample_ratio;

    //画像のサイズを設定
    $text_width = -round($font_size * $letter_spacing);
    for ($i = 0; $i < mb_strlen($text); $i++) {
      $char[$i] = mb_substr($text, $i, 1);
      if ($char[$i] == ' ') {
        $text_width += round($font_size * TEXT_SPACE_WIDTH);
      } else {
        $result = imagettfbbox($font_size, 0, TEXT_FONT_DIRECTORY . $font_file, $char[$i]);
        $char_width[$i] = $result[2] - $result[6];
        $text_width += $char_width[$i] + round($font_size * $letter_spacing);
      }
    }
    $text_height = round($font_size * 1.4);
    $image_width = $text_width + $margin[1] + $margin[3];
    $image_height = $text_height + $margin[0] + $margin[2];

    //画像を生成
    $img = imagecreatetruecolor($image_width, $image_height);
    $text_color = imagecolorallocate($img, $color[0], $color[1], $color[2]);
    $bg_color = imagecolorallocate($img, $background_color[0], $background_color[1], $background_color[2]);
    imagefilledrectangle($img, 0, 0, $image_width, $image_height, $bg_color);
    $position_left = $margin[3];
    for ($i = 0; $i < count($char); $i++) {
      if ($char[$i] == ' ') {
        $position_left += round($font_size * 0.5);
      } else {
        imagettftext($img, $font_size, 0, $position_left , $margin[0] + $font_size, $text_color, TEXT_FONT_DIRECTORY . $font_file, $char[$i]);
        $position_left += $char_width[$i] + round($font_size * $letter_spacing);
      }
    }
    
    //縮小
    $large_img = $img;
    $img = imagecreatetruecolor(round($image_width / $resample_ratio), round($image_height / $resample_ratio));
    imagecopyresampled($img, $large_img, 0, 0, 0, 0, round($image_width / $resample_ratio), round($image_height / $resample_ratio), $image_width, $image_height);
    imagedestroy($large_img);
    
    //ファイルとして保存
    if ($file_type == 'png') {
      imagepng($img, TEXT_IMAGE_DIRECTORY . $file_name);
    } else if ($file_type == 'jpeg') {
      imagejpeg($img, TEXT_IMAGE_DIRECTORY . $file_name);
    } else if ($file_type == 'gif') {
      imagegif($img, TEXT_IMAGE_DIRECTORY . $file_name);
    }
    imagedestroy($img);
  }
  
  return (TEXT_IMAGE_DIRECTORY . $file_name);
}


/**
 * テキスト画像のimg要素を出力
 * @param string $text テキスト
 * @param string $style スタイル名
 * @param array $suffix_array スタイル名の接尾語の配列
 */
function print_img_text($text, $style = false, $suffix_array = array()) {
  /* imgタグを出力 */
  $image_file = get_text_image($text, $style);
	print('<img src="' . SITE_URL . '/' . substr($image_file, 0, strrpos($image_file, '/') + 1) . rawurlencode(substr($image_file, strrpos($image_file, '/') + 1)) . '?' . md5(date('YmdHis', filemtime($image_file))) . '" alt="' . $text . '" />');
  
  if (!empty($suffix_array)) {
    foreach ($suffix_array as $suffix) {
      get_text_image($text, $style, $suffix);
    }
  }
}

/**
 * ファイル名またはパスから拡張子を取得
 * @param string $file_name
 * @return string
 */
function get_extension($file_name){
  $reversed_file_name = strrev($file_name);
  $reversed_extension = substr($reversed_file_path, 0, strpos($reversed_file_name, '.'));
  return strrev($reversed_extension);
}


/**
 * データを取得
 * @param string $category データ名
 * @return mixed データが存在しなかったらfalse
 */
function load_data($name) {
  $file_path = DATA_DIRECTORY . $name;
  if (!file_exists($file_path)) {
    return false;
  }
  $serialized_value = file_get_contents($file_path);
  return unserialize($serialized_value);
}

/**
 * データを保存
 * @param string $category データ名
 * @return mixed データが存在しなかったらfalse
 */
function save_data($name, $data) {
  $file_path = DATA_DIRECTORY . $name;
  $serialized_value = serialize($data);
  file_put_contents($file_path, $serialized_value);
}


/**
 * 連想配列を要素として持つ配列を連想配列のキーを指定してソート
 * @param array $array
 * @param string $key
 * @return bool
 */
function sort_by_key(&$array, $key) {
  return usort($array, function($item1, $item2) use ($key) {
    if ($item1[$key] == $item2[$key]) {
      return 0;
    }
    return ($item1[$key] < $item2[$key]) ? -1 : 1;
  });
}

/**
 * 連想配列を要素として持つ配列を連想配列のキーと値を指定して要素を取得
 * @param array $array
 * @param string $key
 * @param mixed $value
 * @return array|false 存在しない場合はfalse
 */
function array_get_by_key($array, $key, $value) {
  foreach ($array as $item) {
    if ($item[$key] == $value) {
      return $item;
    }
  }
  return false;
}

/**
 * 配列の要素の順番を移動する
 *
 * 元のキーは維持しない
 * @param array $array 対象の配列
 * @param mixed $original_index 元のキー
 * @param int $new_index 移動先の位置
 * @return bool
 */
function array_move(&$array, $original_index, $new_index) {
  if (!isset($array[$original_index])) {
    return false;
  }
  $new_array = array();
  $target_item = $array[$original_index];
  if ($new_index == 0) {
    $new_array[] = $target_item;
  }
  foreach ($array as $i => $item) {
    if ($i == $original_index) continue;
    $new_array[] = $item;
    if (count($new_array) == $new_index) {
      $new_array[] = $target_item;
    }
  }
  if (count($new_array) != count($array)) {
    return false;
  }
  $array = $new_array;
  return true;
}


/**
 * 画像を別名で保存
 * @param string $original_file 元の画像ファイルのパス
 * @param string $new_file 拡張子を除いた保存先のパス
 * @param int|false $max_width 画像の幅の上限（指定しないならfalse）
 * @param int|false $max_height 画像の高さの上限（指定しないならfalse）
 * @param string $mime 保存する画像形式のMIME（'image/jpeg'|'image/png'|'image/gif'|'image/bmp'）
 * @return bool
 */
function save_image($original_file, $new_file, $max_width = false, $max_height = false, $mime = 'image/png') {
  $image_info = getimagesize($original_file);
  $original_width = $image_info[0];
  $original_height = $image_info[1];
  $out_width = $original_width;
  $out_height = $original_height;
  if ($max_width && $out_width > $max_width) {
    $out_height = round($out_height / $out_width * $max_width);
    $out_width = $max_width;
  }
  if ($max_height && $out_height > $max_height) {
    $out_width = round($out_width / $out_height * $max_height);
    $out_height = $max_height;
  }
  switch ($image_info['mime']) {
    case 'image/jpeg':
      $image = imagecreatefromjpeg($original_file);
      break;
    case 'image/png':
      $image = imagecreatefrompng($original_file);
      break;
    case 'image/gif':
      $image = imagecreatefromgif($original_file);
      break;
    case 'image/bmp':
      $image = imagecreatefromwbmp($original_file);
      break;
    default:
      return false;
      break;
  }
  $out_image = ImageCreateTrueColor($out_width, $out_height);
  $base_color = imagecolorallocate($out_image, 255, 255, 255);
  imagefilledrectangle($out_image, 0, 0, $out_width, $out_height, $base_color);
  ImageCopyResampled($out_image, $image, 0, 0, 0, 0, $out_width, $out_height, $original_width, $original_height);
  switch ($mime) {
    case 'image/jpeg':
      return imagejpeg($out_image, $new_file);
      break;
    case 'image/png':
      return imagepng($out_image, $new_file);
      break;
    case 'image/gif':
      return imagegif($out_image, $new_file);
      break;
    case 'image/bmp':
      return imagebmp($out_image, $new_file);
      break;
    default:
      return false;
      break;
  }
}


?>