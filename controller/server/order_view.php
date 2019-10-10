<?php
$mode= _GET("mode");
$order_id=_GET("order_id");
if ($mode=="addnew"){
  $sql="insert into orders (id,car_id,painter_id,dtcreate,dtclose,status,comments,archive) values "
          . "(null,-1,-1,now(),null,0,'',1)";  
  $result = $sqlcn->ExecuteSQL($sql) or die("Не удалось добавить orders!" . mysqli_error($sqlcn->idsqlconnection));
  $order_id=mysqli_insert_id($sqlcn->idsqlconnection);
};

// читаю информацию по заказу и строю страницу
$sql="select * from orders where id=$order_id";
$result = $sqlcn->ExecuteSQL($sql) or die("Не могу выбрать список painters!" . mysqli_error($sqlcn->idsqlconnection));
while ($row = mysqli_fetch_array($result)) {
    $order_id=$row["id"];
    $car_id=$row["car_id"];
    $painter_id=$row["painter_id"];
    $dtcreate=$row["dtcreate"];
    $dtclose=$row["dtclose"];
    $status=$row["status"];
    $comments=$row["comments"];
}; 
//
?>
<div align="center"><h3>Заказ №<?php echo $order_id;?></h3></div>
<div class="container-fluid" style="padding-right: 0px; padding-left: 0px;">
        <div class="row">
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">							
                    <div class="form-group">
                        <label for="dtcreate">Дата заказа</label>
                        <input class="form-control" readonly="true" type="text" name="dtcreate" id="dtcreate" value="<?php echo MySQLDateTimeToDateTime($dtcreate);?>">                    
                        <small class="form-text text-muted">Дата и время создания заказа</small>                         
                    </div>
                </div>            
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">							
                    <label for="car_id">Автомобиль</label>
                    <div id="cars_list_div"></div>
                    <small class="form-text text-muted">Номер и фамилия водителя</small>
                </div>
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">							
                    <label for="painter_id">Исполнитель</label>
                    <div id="painters_list_div"></div>
                    <small class="form-text text-muted">Маляр, исполнитель</small>
                </div>
        </div>
</div>
<div align="center"><h3>Кузов</h3></div>
<div class="container-fluid" style="padding-right: 0px; padding-left: 0px;">
        <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">							
                    <div align="center">
                        <img src="controller/client/img/razvertka.png">
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">							
                    <div align="center"><h4>Элементы</h4></div>
                    1<br/>
                    2<br/>
                    3<br/>
                </div>            
        </div>
</div>
<div align="center">
    <button onclick="SaveOrder()" type="button" class="btn btn-success">Сохранить изменения</button>
</div>
<script>
$(function() {
    // Загружаем список автомобилей
    $.post(route+'controller/server/sel_list_cars.php',{default:<?php echo $car_id;?>}, 
       function(data){             
          $("#cars_list_div").html(data);
          $(".chosen-select").chosen();
          $("#car_id").chosen('destroy').val(<?php echo $car_id;?>).chosen(); 
       }
    );               
    // Загружаем список исполнителей
    $.post(route+'controller/server/sel_list_painters.php',{default:<?php echo $painter_id;?>}, 
       function(data){             
         $("#painters_list_div").html(data)
          $(".chosen-select").chosen();
          $("#painter_id").chosen('destroy').val(<?php echo $painter_id;?>).chosen();          
       }
    );               
    
        
});    
</script>    