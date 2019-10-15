<?php

$id= _POST("id");

$sql="delete  from images where id=$id";
$result = $sqlcn->ExecuteSQL($sql) or die("Не могу удалить фото!" . mysqli_error($sqlcn->idsqlconnection));
