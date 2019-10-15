<?php

$order_id= _POST("order_id");
$status= _POST("status");
$car_id= _POST("car_id");
$comments= _POST("comments");
$painter_id= _POST("painter_id");
$sql="update orders set comments='$comments',car_id='$car_id',painter_id='$painter_id',archive=0,status=$status where id=$order_id;";
$sqlcn->ExecuteSQL($sql) or die('Не могу обновить закааз! ' . mysqli_error($sqlcn->idsqlconnection));

