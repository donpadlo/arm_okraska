<?php
$order_id= _POST("order_id");
$sql="update orders set status=3 where id=$order_id";    
$sqlcn->ExecuteSQL($sql) or die('Не могу обновить закааз! ' . mysqli_error($sqlcn->idsqlconnection));