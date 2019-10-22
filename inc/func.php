<?php
/*
 *  Получаем выплаты за период по водителю
 *  $type= 0 - не выплаченные, 1 - выплаченные
 *  $painter_id = -1 всего, или Х - если водитель указан
 */
function GetPay20Pers($dtstart,$dtend,$type,$painter_id){
 global $sqlcn;    
    $amount=0;   
    if ($painter_id==-1){
     $sql="select * from orders where  status=3 and  dtclose between '$dtend' and '$dtstart' and archive=0 and pay20=$type order by dtcreate desc";
    } else {
     $sql="select * from orders where   status=3 and dtclose between '$dtend' and '$dtstart' and archive=0  and pay20=$type and painter_id=$painter_id order by dtcreate desc";    
    };       
    $result = $sqlcn->ExecuteSQL($sql) or die("Не могу выбрать список заказов!" . mysqli_error($sqlcn->idsqlconnection));
    while ($row = mysqli_fetch_array($result)) {
        $oa=GetOrderInfo($row["id"]);  
        $vp_20=round(($oa["work"])*0.2,2);       
        $amount=$amount+$vp_20;
    };
    return $amount;  
};
/*
 *  Получаем выплаты за период по водителю
 *  $type= 0 - не выплаченные, 1 - выплаченные
 *  $painter_id = -1 всего, или Х - если водитель указан 
 */
function GetPay30Pers($dtstart,$dtend,$type,$painter_id){
 global $sqlcn;    
    $amount=0;   
    if ($painter_id==-1){
     $sql="select * from orders where status=3 and dtclose between '$dtend' and '$dtstart'  and archive=0 and pay30=$type order by dtcreate desc";
    } else {
     $sql="select * from orders where  status=3 and dtclose between '$dtend' and '$dtstart' and archive=0  and pay30=$type and painter_id=$painter_id order by dtcreate desc";    
    };           
    //echo "$sql<br/>";
    $result = $sqlcn->ExecuteSQL($sql) or die("Не могу выбрать список заказов!" . mysqli_error($sqlcn->idsqlconnection));
    while ($row = mysqli_fetch_array($result)) {
        $oa=GetOrderInfo($row["id"]);
        $vp_30=round(($oa["work"]-$oa["mat"]/2)*0.3,2);       
        //echo "$vp_30<br/>";
        $amount=$amount+$vp_30;
    };
    return $amount;      
};

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