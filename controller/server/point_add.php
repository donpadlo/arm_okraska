<?php

$order_id= _POST("order_id");
$x= _POST("x");
$y= _POST("y");
$coors=array();
$coors[]=$x;
$coors[]=$y;
$cr= json_encode($coors);
$sql="insert into points (id,order_id,coors,amount,cnt,comment) values "
        . "(null,$order_id,'$cr',0,1,'')";
$result = $sqlcn->ExecuteSQL($sql) or die("Не могу добавить точку!" . mysqli_error($sqlcn->idsqlconnection));
$point_id=mysqli_insert_id($sqlcn->idsqlconnection);
echo "$point_id";