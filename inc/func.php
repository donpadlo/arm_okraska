<?php
function GetOrderInfo($order_id){
 global $sqlcn;
 $sql="select round(sum(amount),2) as amount from payments where order_id=$order_id and type=3";
 $result = $sqlcn->ExecuteSQL($sql) or die("Не могу выбрать список painters!" . mysqli_error($sqlcn->idsqlconnection));
  $mat=0;
  while ($row = mysqli_fetch_array($result)) {
    $mat=$row["amount"];  
  }; 
 $sql="select round(sum(amount),2) as amount from payments where order_id=$order_id and type=2";
 $result = $sqlcn->ExecuteSQL($sql) or die("Не могу выбрать список painters!" . mysqli_error($sqlcn->idsqlconnection));
  $zap=0;
  while ($row = mysqli_fetch_array($result)) {
    $zap=$row["amount"];  
  }; 
 $sql="select round(sum(amount),2) as amount from points where order_id=$order_id";
 $result = $sqlcn->ExecuteSQL($sql) or die("Не могу выбрать список painters!" . mysqli_error($sqlcn->idsqlconnection));
  $work=0;
  while ($row = mysqli_fetch_array($result)) {
    $work=$row["amount"];  
  }; 
  $res=array();
  $res["mat"]=$mat;
  $res["zap"]=$zap;
  $res["work"]=$work;
  //ну и статус заодно..  
  $sql="select status from orders where id=$order_id";
  $result = $sqlcn->ExecuteSQL($sql) or die("Не могу выбрать заказ!" . mysqli_error($sqlcn->idsqlconnection));
    while ($row = mysqli_fetch_array($result)) {
      $status=$row["status"];  
    }; 
    switch ($status) {
        case 0:$res["status_txt"]="Новый";break;
        case 1:$res["status_txt"]="В работе";break;
        case 2:$res["status_txt"]="Закончен,не оплачен";break;
        case 3:$res["status_txt"]="Закрыт";break;
        default: $res["status_txt"]="";break;
    }
  return $res;
};
function GetCarById($car_id){
 global $sqlcn;   
 $sql="select * from cars where id=$car_id";
 $result = $sqlcn->ExecuteSQL($sql) or die("Не могу выбрать список painters!" . mysqli_error($sqlcn->idsqlconnection));
 $car="";
  while ($row = mysqli_fetch_array($result)) {
    $car=$row["number"]." ".$row["model"];  
  }; 
  return $car;
}
function GetPainterById($painter_id){
 global $sqlcn;   
 $sql="select * from painters where id=$painter_id";
 $result = $sqlcn->ExecuteSQL($sql) or die("Не могу выбрать список painters!" . mysqli_error($sqlcn->idsqlconnection));
 $painter="";
  while ($row = mysqli_fetch_array($result)) {
    $painter=$row["fio"];  
  }; 
  return $painter;
}

?>