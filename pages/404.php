<?php
$page_title = "$site_name | Page not found";
$page_description = '';
$page_keywords = '';
//$style_files[] = "styles/index.css";
//$script_files[] = "scripts/index.js";
include("elements/header.php");
?>

<div id="container">
<div id="content">

<div class="main clearfix">
  <div class="box">
    <h2>Page Not Found (404)</h2>
    <p>The page you are looking for might have removed or be temporarily anavailable.</p>        
    <p>Return to the <a href="<?php echo SITE_URL; ?>/">homepage</a>.</p>        
  </div>
</div>

</div><!-- #content -->
</div><!-- #container -->

<?php include "elements/footer.php"; ?>
