<?php

$point_id= _POST("point_id");
$comments= _POST("comments");
$amount= _POST("amount");
$cnt= _POST("cnt");

$sql="update points set comment='$comments',amount='$amount',cnt='$cnt' where id=$point_id";
$result = $sqlcn->ExecuteSQL($sql) or die("Не могу обновить points!" . mysqli_error($sqlcn->idsqlconnection));