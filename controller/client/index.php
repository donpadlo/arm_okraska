<?php
include_once 'header.php';
include_once 'navbar.php';
echo '<div class="container-fluid" id="maincontent" name="maincontent">';
include_once ("$content_page.php");    
echo "</div>";
include_once 'footer.php';
?>
