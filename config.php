<?php
/* 共通の変数・定数 */
// サイト名
$site_name = 'Creating A World-Class Mountain Destination';
// デフォルトのページタイトル
$page_title = $site_name;
// デフォルトのdescription
$page_description = '';
// デフォルトのkeyword
$page_keywords = '';
// 共通のcssファイルの配列
$style_files = array(
	//'styles/base.css',
	'css/reset.css',
	'css/layout.css'
);
// 共通のjsファイルの配列
$script_files = array(
	'scripts/jquery-1.4.2.js',
	'js/scrolltopcontrol.js',
	'scripts/whiteprojects.js',
);

// dataディレクトリ
define('DATA_DIRECTORY', __DIR__ . '/data/');

/* テキスト画像出力用の定数 */
define('TEXT_IMAGE_DIRECTORY', 'images/texts/'); // 出力画像ファイルのディレクトリ
define('TEXT_STYLE_DIRECTORY', 'styles/texts/'); // スタイルファイルのディレクトリ
define('TEXT_FONT_DIRECTORY', 'fonts/'); // フォントファイルのディレクトリ
define('TEXT_STYLE_DEFAULT', 'default'); // デフォルトのスタイル
define('TEXT_SPACE_WIDTH', 0.5); // 半角スペースの幅（フォントサイズとの比率）


/* サイト固有の変数 */

$event_categories = array(
    array(
        'id'    => 1,
        'name'  => 'SPORTS & FESTIVAL',
    ),
    array(
        'id'    => 2,
        'name'  => 'CEREMONY & CONVENTION',
    ),
);

$media_categories = array(
    array(
        'id'    => 1,
        'name'  => 'None',
    ),
);

$link_categories = array(
    array(
        'id'    => 1,
        'name'  => 'ATHLETE',
    ),
    array(
        'id'    => 2,
        'name'  => 'MODEL/TALENT',
    ),
    array(
        'id'    => 3,
        'name'  => 'ARTIST',
    ),
);

// トップに表示するイベントの件数
$top_events_number = 3;

// 白ページの画像の最大幅
$shiro_image_max_width = 590;

// バナーの最大高さ
$banner_max_height = 60;

// プロフィール欄の画像URL
$profile_image_url = 'images/profilephoto.png';

?>