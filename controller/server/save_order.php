<?php

$order_id= _POST("order_id");
$status= _POST("status");
$car_id= _POST("car_id");
$comments= _POST("comments");
$painter_id= _POST("painter_id");
if ($status==3){
    $sql="update orders set dtclose=now(),comments='$comments',car_id='$car_id',painter_id='$painter_id',archive=0,status=$status where id=$order_id;";      
} else {
  $sql="update orders set dtclose=null,comments='$comments',car_id='$car_id',painter_id='$painter_id',archive=0,status=$status where id=$order_id;";  
};
$sqlcn->ExecuteSQL($sql) or die('Не могу обновить закааз! ' . mysqli_error($sqlcn->idsqlconnection));

