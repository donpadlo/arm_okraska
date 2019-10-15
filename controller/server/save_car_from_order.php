<?php

$car_model= _POST("car_model");
$car_number= _POST("car_number");
$fio_form= _POST("fio_form");
$mobile= _POST("mobile");

$sql="insert into cars (id,dtcreate,model,number,fio,mobile) values (null,now(),'$car_model','$car_number','$fio_form','$mobile')";
$sqlcn->ExecuteSQL($sql) or die("Не могу добавить car! ($sql) " . mysqli_error($sqlcn->idsqlconnection));
?>