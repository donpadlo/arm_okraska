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
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">							
                    <div align="center">
                        <img id="razvertka_id" ondblclick="AddPoint(event)" src="controller/client/img/razvertka.png">
                        <img id="razvertka_id" ondblclick="AddPoint(event)" src="controller/client/img/1.jpg">
                        <div class="points_list_div" id="points_list_div"></div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">							
                    <div align="center"><h4>Работа</h4></div>
                    <div id="work_list_div">
                    </div>
                </div>            
        </div>
</div>
<div align="center">
    <button onclick="SaveOrder()" type="button" class="btn btn-success">Сохранить изменения</button>
</div>
<!--Диалоговые окна-->
<div id="dlg_point" title="Элемент">    
   <div id="points_div_list_which_photos"> </div>
</div>
<script>
function CarsLoad(){
    $.post(route+'controller/server/sel_list_cars.php',{default:<?php echo $car_id;?>}, 
       function(data){             
          $("#cars_list_div").html(data);
          $(".chosen-select").chosen();
          $("#car_id").chosen('destroy').val(<?php echo $car_id;?>).chosen(); 
       }
    );                   
};
function PointersLoad(){
    $.post(route+'controller/server/sel_list_painters.php',{default:<?php echo $painter_id;?>}, 
       function(data){             
         $("#painters_list_div").html(data)
          $(".chosen-select").chosen();
          $("#painter_id").chosen('destroy').val(<?php echo $painter_id;?>).chosen();          
       }
    );                   
};
function PointsLoad(){
    $.post(route+'controller/server/get_list_points.php',{order_id:<?php echo $order_id;?>}, 
       function(data){             
         points_list=JSON.parse(data);                   
         $("#points_list_div").html("");
         sm=razvertka_id.getBoundingClientRect();
//         $("#points_list_div").height(sm.height);
//         $("#points_list_div").width(sm.width);         
         //$("#points_list_div").left(sm.left);         
         points_list.forEach(function(item, i, arr) {
            console.log(item);
            var point_id=item.point_id;
            x=Number(item.coors[0])+Number(sm.left);
            console.log(x);
            y=item.coors[1];
            $("#points_list_div").append("<div onclick='OpenPointWin("+point_id+")' class='dot' style='top:"+y+"px;left:"+x+"px'></div>");
         });
       }
    );                       
};
function OpenPointWin(point_id){
    console.log("Открываем точку:"+point_id);
    $("#dlg_point" ).dialog("open");
    $("#points_div_list_which_photos").html("<img src='controller/client/img/loading.gif'>");
    $("#points_div_list_which_photos" ).load(route+"controller/server/point_view.php&point_id="+point_id);
    
}    
function AddPoint(e){    
    var x = e.offsetX == undefined ? e.layerX : e.offsetX;
    var y = e.offsetY == undefined ? e.layerY : e.offsetY;
    x=x-5;
    y=y-4;
    sm=razvertka_id.getBoundingClientRect();   
    $.post(route+'controller/server/point_add.php',{
        order_id:<?php echo $order_id;?>,
        x: x,
        y: y
    }, 
       function(data){                      
         PointsLoad();
         if (Number(data)>0){
            $().toastmessage('showWarningToast', 'Точка добавлена!');              
            OpenPointWin(data);
         } else {
            $().toastmessage('showWarningToast', 'Ошибка добавления точки!'); 
         };
       }
    );                           
};
$(function() {
    // Окно точек
    $("#dlg_point" ).dialog({
      autoOpen: false,        
      resizable: false,
      height:400,
      width: 640,
      modal: true,        
    });      
    // Загружаем список автомобилей
    CarsLoad();
    // Загружаем список исполнителей
    PointersLoad();      
    // Загружаем список комментариев
    PointsLoad();
});    
</script>    