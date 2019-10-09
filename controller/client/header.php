<!DOCTYPE html>
<html lang="ru-RU">
<head id="idheader">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="<?php echo "$cfg->sitename"; ?>">
<meta name="author" content="(c) 2019 by Gribov Pavel http://грибовы.рф">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="generator" content="yarus">
<title><?php echo "$cfg->sitename"; ?></title>
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="vendor/components/jqueryui/themes/base/jquery-ui.min.css">
<link rel="stylesheet" href="vendor/components/bootstrap/css//bootstrap.min.css">
<link rel="stylesheet" href="vendor/free-jqgrid/dist/css/ui.jqgrid.min.css">
<link rel="stylesheet" href="controller/client/css/jquery.toastmessage.css">
<link rel="stylesheet" href="controller/client/css/chosen.min.css">
<link rel="stylesheet" href="vendor/components/font-awesome/css/fontawesome.min.css">
<script src="vendor/components/jquery/jquery.min.js"></script>
<script src="vendor/components/jqueryui/jquery-ui.min.js"></script>
<script src="controller/client/js/jquery.toastmessage.js"></script>
<script src="controller/client/js/chosen.jquery.min.js"></script>
<script src="controller/client/js/driver.js"></script>
<script src="vendor/components/bootstrap/js/bootstrap.min.js"></script>
<script src="vendor/free-jqgrid/dist/jquery.jqgrid.min.js"></script>
<script>
<?php
// определяем какие месяцы разрешено редактировать
    $cur_period=Date("Y-n-01");
    $date = new DateTime();
    $date->modify('-1 month');
    $old_period=$date->format('Y-n-01');
?>
    cur_period="<?php echo "$cur_period";?>";
    old_period="<?php echo "$old_period";?>";
    route = '<?php echo 'index.php?route=/'; ?>';
</script>    