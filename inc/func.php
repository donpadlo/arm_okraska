<?php
function GetOrderInfo($order_id){
 global $sqlcn;
 $sql="select round(sum(amount*cnt),2) as amount from payments where order_id=$order_id and type=2";
 $result = $sqlcn->ExecuteSQL($sql) or die("Не могу выбрать список painters!" . mysqli_error($sqlcn->idsqlconnection));
  $mat=0;
  while ($row = mysqli_fetch_array($result)) {
    $mat=$row["amount"];  
  }; 
 $sql="select round(sum(amount*cnt),2) as amount from payments where order_id=$order_id and type=3";
 $result = $sqlcn->ExecuteSQL($sql) or die("Не могу выбрать список painters!" . mysqli_error($sqlcn->idsqlconnection));
  $zap=0;
  while ($row = mysqli_fetch_array($result)) {
    $zap=$row["amount"];  
  }; 
 $sql="select round(sum(amount*cnt),2) as amount from points where order_id=$order_id";
 $result = $sqlcn->ExecuteSQL($sql) or die("Не могу выбрать список painters!" . mysqli_error($sqlcn->idsqlconnection));
  $work=0;
  while ($row = mysqli_fetch_array($result)) {
    $work=$row["amount"];  
  }; 
  $res=array();
  $res["mat"]=$mat;
  $res["zap"]=$zap;
  $res["work"]=$work;
  return $res;
};
?>