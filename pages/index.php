<?php
// 最新のイベント3件を取得
$events_all = load_data('events');
$events_all = array_reverse($events_all);
$events = array();
foreach ($events_all as $event) {
  if ($event['enabled']) {
    array_unshift($events, $event); 
    if (count($events) >= $top_events_number) break;
  }
}

$page_title = "ホテル支配人オブ・ザ・イヤー丸山俊郎ウェブサイトーGeneral Manager of the Year Toshiro Maruyama official web siteー <~Creating a world-class Mountain Destination~>";
$page_description = '世界水準の山岳高原観光地を目指して〜Towards an even more attractive HAKUBA〜 ホテル支配人世界一受賞者【丸山俊郎オフィシャルウェブサイト】';
$page_keywords = 'ホテル支配人世界一,Hakuba,events,sports,MC,アナウンサー,司会,toshiro,maruyama,Toshiro Maruyama,白馬,イベント,スポーツ,Tossy,丸山,俊郎,happo-one,八方尾根,ウェブサイト,丸山俊郎,ryokan,世界一,ホテル,支配人,しろうま荘,general manager, general manager of the year,global, winner,ホテル支配人オブ・ザ・イヤー,白馬高校,観光英語,国際観光課,インターナショナルスクール,理事,ラグジュアリートラベルガイド,luxury travel guide,luxury travel guide awards,world luxury hotel awards';
//$style_files[] = "styles/index.css";
//$script_files[] = "scripts/index.js";
include("elements/header.php");
?>

<div id="container">
<div id="content">
<div id="main">


<div id="mainVisual" class="mainImg">
	<img src="<?php print_file('images/mainImg.jpg'); ?>" alt="Towards an even more attractive HAKUBA." />
</div>
<h2>ホテル支配人オブ・ザ・イヤー受賞者 丸山俊郎ウェブサイト<br>
Creating A World Class Mountain Destination</h2>

<div class="topSection">
		<h3 class="magazineTi">Magazine</h3>
		<ul class="topMenu">
		<li><img src="<?php print_file('images/magazin_01.jpg'); ?>" alt="雑誌A"/></li>
		<li><img src="images/magazin_02.jpg" alt="雑誌B"/></li>
		<li><img src="images/magazin_03.jpg" alt="雑誌C"/></li>
		</ul>
		<ul class="topMenu2">
		<li><img src="images/magazin_04.jpg" alt="雑誌4"/></li>
		<li><img src="images/magazin_05.jpg" alt="雑誌5"/></li>
		<li><img src="images/magazin_06.jpg" alt="雑誌6"/></li>
		</ul>
		
		</div>


</div><!--main end-->


<div id="sub">
<img src="<?php print_file('images/subImg.jpg'); ?>" alt="丸山" />
		<h3 class="sideTi">Award</h3>
			
		<ul class="bnrList">
		<li><img src="<?php print_file('images/trophy.jpg'); ?>" alt="trophy" /></li>
		<li><a href="#"><img src="<?php print_file('images/awardlogo.jpg'); ?>" alt="awardlogo" /></a></li>
		</ul>
		
		
 
 <div class="sideInformation">
		<h3 class="sideEventTi">Up Coming Event</h3>
<?php if (!empty($events)) : ?>
 	 <ul class="sideInfoList">
<?php foreach ($events as $event) { ?>
		 <li>
      <span><?php print(date('n月j日', $event['start_at'])); ?></span>
<?php if ($event['start_at'] != $event['end_at']) { ?>
         〜 <?php print(date('n月j日', $event['end_at'])); ?>
<?php } ?>
      <?php print_text($event['name']); ?>
    </li>
<?php } ?>
  </ul>
<?php else : ?>
  <p>現在開催予定のイベントはありません。</p>
<?php endif; ?>
 
  <a href="<?php echo SITE_URL; ?>/events" class="sideMore">More</a>
</div>
</div><!-- sub -->

</div><!-- #content -->
		<p class="ate">
			<!-- 講演・パネリスト等のご依頼、ご質問は、<a href="http://www.shiroumaso.com/contact.html" class="border" target="_blank">こちら</a>からお願い致します。 -->
			<a href="https://www.instagram.com/toshiromaruyama/" target="_blank" class="ateSns"><img src="<?php print_file('images/banner_link_3.png'); ?>" alt="Toshiro Maruyama Instagram"></a>
		</p>
</div><!-- #container -->

<?php include "elements/footer.php"; ?>