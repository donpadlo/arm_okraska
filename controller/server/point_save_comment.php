<?php

$point_id= _POST("point_id");
$comments= _POST("comments");

$sql="update points set comments='$comments' where id=$point_id";
$result = $sqlcn->ExecuteSQL($sql) or die("Не могу обновить points!" . mysqli_error($sqlcn->idsqlconnection));