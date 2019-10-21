<?php

$dtstart= _POST("dt");
$painter_id=_POST("painter_id");
        
$str_exp = explode(".", $dtstart);
if (count($str_exp) == 0) {$str_exp = explode("/", $dtstart);};
$dtstart = $str_exp[2] . "-" . $str_exp[1] . "-" . $str_exp[0];
//дата конца 2 и 1 месяца назад
$dtend2month= date('Y-m-d', strtotime($dtstart . ' - 2 month'));
$dtend1month= date('Y-m-d', strtotime($dtstart . ' - 1 month'));

$daymonth=date("d", strtotime($dtstart));      

if ($daymonth<7){
  $per_cur_start=$dtstart." 23:59:59";
  $per_cur_end=date('Y-m-8 00:00:00', strtotime($dtstart . ' - 1 month'));
  $per_7_start=date('Y-m-7 23:59:59', strtotime($dtstart . ' - 1 month'));
  $per_7_end=$dtend2month." 00:00:00";  
} else {
  $per_cur_start=$dtstart." 23:59:59";
  $per_cur_end=date('Y-m-8 00:00:00', strtotime($dtstart));
  $per_7_start=date('Y-m-7 23:59:59', strtotime($dtstart));
  $per_7_end=$dtend2month." 00:00:00";      
};


$where="";
if ($painter_id!="-1"){
     $where="and painter_id=$painter_id";
};

echo "<h3>Ордера</h3>";
echo '<table class="table table-striped table-hover table-sm">';
echo '<thead><tr>';
echo '<th scope="col">№</th>';
echo '<th scope="col">Начато</th>';
echo '<th scope="col">Закрыто</th>';
echo '<th scope="col">Исполнитель</th>';
echo '<th scope="col">Автомобиль</th>';
echo '<th scope="col">Работа</th>';
echo '<th scope="col">Материалы</th>';
echo '<th scope="col">Запчасти</th>';
echo '<th scope="col">Статус</th>';
echo '<th scope="col">Выплата 20%</th>';
echo '<th scope="col">Выплата 30%</th>';
echo '<th scope="col">Всего<br/>к выплате</th>';
echo '</tr></thead>';

echo "<tr class='table-info' scope='row'><td colspan='12'><div id=curr_pays>Текущие выплаты (30%) с $per_cur_start по $per_cur_end</td></tr>";
$sql="select * from orders where  dtcreate between '$per_cur_end' and '$per_cur_start' $where and archive=0 order by dtcreate desc";
$res = $sqlcn->ExecuteSQL($sql);
while ($row = mysqli_fetch_array($res)) {
  $order_id=$row["id"];
  $car_id=$row["car_id"];
  $car_number=GetCarById($car_id);
  $painter_id=$row["painter_id"];
  $painter=GetPainterById($painter_id);
  $dtcreate=$row["dtcreate"];
  $dtclose=$row["dtclose"];
  $status=$row["status"];
  $comments=$row["comments"];
  $pay20=$row["pay20"];
  $pay30=$row["pay30"];
  $week=date("W", strtotime($dtcreate));      
  $daymonth=date("d", strtotime($dtcreate));      
  $oa=GetOrderInfo($order_id);  
  $vp_20=round(($oa["work"]-$oa["mat"]/2)*0.2,2);
  $vp_30=round(($oa["work"]-$oa["mat"]/2)*0.3,2);
  $vl_all=$vp_20+$vp_30;
  echo "<tr>";
    echo "<td>$order_id</td>";
    echo "<td>$dtcreate</td>";
    echo "<td>$dtclose</td>";
    echo "<td>$painter</td>";
    echo "<td>$car_number</td>";
    echo "<td>".$oa["work"]."</td>";
    echo "<td>".$oa["mat"]."</td>";
    echo "<td>".$oa["zap"]."</td>";
    echo "<td>".$oa["status_txt"]."</td>";
    echo "<td>$vp_20</td>";
    echo "<td>$vp_30</td>";
    echo "<td>$vl_all</td>";
  echo "</tr>";  
};

echo "<tr class='table-info' scope='row'><td colspan='12'><div id=curr_pays>Доплаты (20%) с $per_7_start по $per_7_end</td></tr>";
$sql="select * from orders where  dtcreate between '$per_7_end' and '$per_7_start' $where and archive=0 order by dtcreate desc";
$res = $sqlcn->ExecuteSQL($sql);
while ($row = mysqli_fetch_array($res)) {
  $order_id=$row["id"];
  $car_id=$row["car_id"];
  $car_number=GetCarById($car_id);
  $painter_id=$row["painter_id"];
  $painter=GetPainterById($painter_id);
  $dtcreate=$row["dtcreate"];
  $dtclose=$row["dtclose"];
  $status=$row["status"];
  $comments=$row["comments"];
  $pay20=$row["pay20"];
  $pay30=$row["pay30"];
  $week=date("W", strtotime($dtcreate));      
  $daymonth=date("d", strtotime($dtcreate));      
  $oa=GetOrderInfo($order_id);  
  $vp_20=round(($oa["work"]-$oa["mat"]/2)*0.2,2);
  $vp_30=round(($oa["work"]-$oa["mat"]/2)*0.3,2);
  $vl_all=$vp_20+$vp_30;
  echo "<tr>";
    echo "<td>$order_id</td>";
    echo "<td>$dtcreate</td>";
    echo "<td>$dtclose</td>";
    echo "<td>$painter</td>";
    echo "<td>$car_number</td>";
    echo "<td>".$oa["work"]."</td>";
    echo "<td>".$oa["mat"]."</td>";
    echo "<td>".$oa["zap"]."</td>";
    echo "<td>".$oa["status_txt"]."</td>";
    echo "<td>$vp_20</td>";
    echo "<td>$vp_30</td>";
    echo "<td>$vl_all</td>";
  echo "</tr>";  
};


echo '</table>';
?>
<script>
</script>    