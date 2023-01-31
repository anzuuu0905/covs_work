<?php
/* 関数を読み込み */
require_once("functions.php");

/* 設定ファイルを読み込み */
include('config.php');

/* 定数を定義 */
define('ROOT_DIRECTORY', str_replace('/index.php', '', $_SERVER['PHP_SELF']));  //index.phpが置いてあるフォルダ
define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST'] . ROOT_DIRECTORY); //サイトトップのURL

$current_page = $_SERVER['REQUEST_URI'];
if (strpos($current_page, '?') !== false) {
  $current_page = substr($current_page, 0, strpos($current_page, '?'));
}
if (strpos($current_page, '#') !== false) {
  $current_page = substr($current_page, 0, strpos($current_page, '#'));
}
$current_page = substr($current_page, strlen(ROOT_DIRECTORY));
if (substr($current_page, -1) == '/') {
  $current_page .= 'index';
}
if (!file_exists("pages{$current_page}.php")) {
  if (file_exists("pages{$current_page}/index.php")) {
    $current_page .= '/index';
  } else {
    $current_page = '/404';
  }
}
define('CURRENT_PAGE', $current_page); //サイトトップから現在のページへの相対パス


/* ページを読み込み */
include('pages' . CURRENT_PAGE . '.php');

?>
