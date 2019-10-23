<?php
$order_id= _POST("order_id");
$type= _POST("type");
if ($type==20){
    $sql="update orders set pay20=1 where id=$order_id";    
};
if ($type==30){
    $sql="update orders set pay30=1 where id=$order_id";    
};
if ($type=="all"){
    $sql="update orders set pay30=1,pay20=1 where id=$order_id";    
};

$sqlcn->ExecuteSQL($sql) or die('Не могу обновить закааз! ' . mysqli_error($sqlcn->idsqlconnection));