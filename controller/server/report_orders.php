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
echo '<th scope="col">Всего</th>';
echo '</tr></thead>';

$idcnt=0;
echo "<tr class='table-info' scope='row'><td colspan='12'><div id=curr_pays>Текущие выплаты (30%) с $per_cur_start по $per_cur_end</div></td></tr>";
$sql="select * from orders where  dtcreate between '$per_cur_end' and '$per_cur_start' $where and archive=0 order by dtcreate desc";
$res = $sqlcn->ExecuteSQL($sql);
while ($row = mysqli_fetch_array($res)) {
  $idcnt++;
  $order_id=$row["id"];
  $car_id=$row["car_id"];
  $car_number=GetCarById($car_id);
  $painter_id_t=$row["painter_id"];
  $painter=GetPainterById($painter_id_t);
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
  if  ($status!=3) {
    $vp_20=0;$vp_30=0;
  };
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
    echo "<td>";
        echo "$vp_20";
        if (($status==3) and ($pay20==0)){
          echo " <button id='p20$idcnt' onclick='Pay($order_id,20,\"p20$idcnt\");' title='Выплатить' type='button' class='btn btn-outline-danger btn-sm'>$</button>";  
        };
    echo "</td>";
    echo "<td>";
        echo "$vp_30";
        if (($status==3) and ($pay30==0)){
            echo " <button id='p30$idcnt' onclick='Pay($order_id,30,\"p30$idcnt\");' title='Выплатить' type='button' class='btn btn-outline-danger btn-sm'>$</button>";            
        };
    echo "</td>";
    echo "<td>$vl_all</td>";
  echo "</tr>";  
};

echo "<tr class='table-info' scope='row'><td colspan='12'><div id=do_pays>Доплаты (20%) с $per_7_start по $per_7_end</div></td></tr>";
$sql="select * from orders where  dtcreate between '$per_7_end' and '$per_7_start' $where and archive=0 order by dtcreate desc";
$res = $sqlcn->ExecuteSQL($sql);
while ($row = mysqli_fetch_array($res)) {
  $idcnt++;
  $order_id=$row["id"];
  $car_id=$row["car_id"];
  $car_number=GetCarById($car_id);
  $painter_id_t=$row["painter_id"];
  $painter=GetPainterById($painter_id_t);
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
  if  ($status!=3) {
    $vp_20=0;$vp_30=0;
  };    
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
    echo "<td>";
        echo "$vp_20";
        if (($status==3) and ($pay20==0)){
            echo " <button id='p20$idcnt' onclick='Pay($order_id,20,\"p20$idcnt\");' title='Выплатить' type='button' class='btn btn-outline-danger btn-sm'>$</button>";  
        };
    echo "</td>";
    echo "<td>";
        echo "$vp_30";
        if (($status==3) and ($pay30==0)){
          echo " <button id='p30$idcnt' onclick='Pay($order_id,30,\"p30$idcnt\");' title='Выплатить' type='button' class='btn btn-outline-danger btn-sm'>$</button>";  
        };
    echo "</td>";
    echo "<td>$vl_all</td>";
  echo "</tr>";  
};
echo '</table>';
?>
<script>
function Pay(order_id,type,buttonid){
    if ($("#"+buttonid).prop( "disabled")==false){
    $.confirm({
        title: 'Подтверждение',
        content: 'Уверены что хотите сделать выплату?',
        buttons: {
                Да: function () {
                    $.post(route+'controller/server/pay_by_type.php',{
                        order_id:order_id,
                        type:type
                    }, 
                        function(data){    
                                Update30Pers(<?php echo "\"$per_cur_end\",\"$per_cur_start\",$painter_id";?>,buttonid);
                                Update20Pers(<?php echo "\"$per_7_end\",\"$per_7_start\",$painter_id";?>,buttonid);                                                        
                        }
                    );                    
                },
                Нет: function () {
                    console.log("отменили");
                }
            }        
    }); 
   };
};
function Update30Pers(per_end,per_start,painter_id,gotoid){
    if (gotoid == undefined) gotoid = "";
    $.post(route+'controller/server/GetBonuses.php',{
            mode:'30',
            per_end:per_end,
            per_start:per_start,
            painter_id:painter_id
        }, 
       function(data){
           console.log("--перегружаю #curr_pays");
           $("#curr_pays").html(data);
           if (gotoid!=""){
                console.log("--иду к ",gotoid);
                window.location.hash=gotoid;
                console.log("--гашу кнопку ",gotoid);
                $("#"+gotoid).prop( "disabled", true ); 
           };
       }
    );         
}    
function Update20Pers(per_end,per_start,painter_id,gotoid){
    if (gotoid == undefined) gotoid = "";
    $.post(route+'controller/server/GetBonuses.php',{
            mode:'20',
            per_end:per_end,
            per_start:per_start,
            painter_id:painter_id
        }, 
       function(data){
           console.log("--перегружаю #do_pays");
           $("#do_pays").html(data);
           if (gotoid!=""){
                console.log("--иду к ",gotoid);
                window.location.hash=gotoid;
                console.log("--гашу кнопку ",gotoid);
                $("#"+gotoid).prop( "disabled", true );
           };
           
       }
    );             
}    

    $(function() { 
        Update30Pers(<?php echo "\"$per_cur_end\",\"$per_cur_start\",$painter_id";?>);
        Update20Pers(<?php echo "\"$per_7_end\",\"$per_7_start\",$painter_id";?>);
    });   
</script>    