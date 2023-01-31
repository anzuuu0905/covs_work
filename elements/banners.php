<div id="banners_container">
  <div id="banners">
    <ul class="clearfix">
<?php
foreach ($banners as $banner) {
  if (!$banner['enabled']) continue;
?>
      <li><a href="<?php print($banner['url']); ?>" target="_blank" title="<?php print_text($banner['name']); ?>"><img src="<?php print_file($banner['path']); ?>" alt="<?php print_text($banner['name']); ?>"></a></li>
<?php } ?>
    </ul>
  </div>
</div>
