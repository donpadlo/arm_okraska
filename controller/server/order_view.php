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
$sql="select orders.*,cars.number from orders left join cars on cars.id=car_id where orders.id=$order_id";
$result = $sqlcn->ExecuteSQL($sql) or die("Не могу выбрать список painters!" . mysqli_error($sqlcn->idsqlconnection));
while ($row = mysqli_fetch_array($result)) {
    $order_id=$row["id"];
    $car_id=$row["car_id"];
    $car_number=$row["number"];
    $painter_id=$row["painter_id"];
    $dtcreate=$row["dtcreate"];
    $dtclose=$row["dtclose"];
    $status=$row["status"];
    $order_comment=$row["comments"];
}; 
?>
<div align="center"><h3>Заказ №<?php echo "$order_id $car_number";?></h3></div>
<div class="container-fluid" style="padding-right: 0px; padding-left: 0px;">
        <div class="row">
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">							
                    <div class="form-group">
                        <label for="order_status">Статус заказа</label>
                        <select style='width:100%;' tabindex='40' name=status_id id=status_id>";
                            <option <?php if ($status==0){echo "selected";};?> value='0'>Новый</option>
                            <option <?php if ($status==1){echo "selected";};?> value='1'>В работе</option>
                            <option <?php if ($status==3){echo "selected";};?> value='3'>Закрыт</option>
                        </select>
                        <small class="form-text text-muted">Текущее состояние заказа</small>                         
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
<div class="container-fluid" style="padding-right: 0px; padding-left: 0px;">
        <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">							
                    <div align="center">
                        <img id="razvertka_id" ondblclick="AddPoint(event)" src="controller/client/img/razvertka.png">                        
                        <div class="points_list_div" id="points_list_div"></div>
                    </div>
                    <h3>Дополнительные фото</h3>
                    <div id="dop_photos" class="card-group">
                        
                    </div>                    
				<div align="center" id="new_dop_photo_load" class="btn btn-primary js-fileapi-wrapper" style="text-align: center;">
					<div class="js-browse" align="center">
						<span class="btn-txt">Загрузить файл</span> <input type="file" name="filedata">
					</div>
					<div class="js-upload" style="display: none">
						<div class="progress progress-success">
							<div class="js-progress bar"></div>
						</div>
						<span align="center" class="btn-txt">Загружаю (<span class="js-size"></span>)</span>
					</div>
				</div>
                <hr/>
                <label for="order_comment">Комментарий</label>
                <textarea class="form-control" id="order_comment" rows="2" name="order_comment"><?php echo "$order_comment";?></textarea>
                    
                </div>
                <div id="work_list_div_id" class="col-sm-6 col-md-6 col-lg-6 col-xl-6">							
                    <table id="work_list"></table>
                    <div id="work_pager"></div>                        
                    <table id="zap_list"></table>
                    <div id="zap_pager"></div>                        
                    <table id="mat_list"></table>
                    <div id="mat_pager"></div>                        
                </div>            
        </div>
</div>
<hr/>
<div align="center">
    <button onclick="SaveOrder()" type="button" class="btn btn-success">Сохранить изменения</button>
</div>
<!--Диалоговые окна-->
<div id="dlg_point" title="Элемент">    
   <div id="points_div_list_which_photos"> </div>
</div>
<div id="dlg_car_add" title="Новый автомобиль">    
     <div class="form-group">
        <label for="car_model_form">Модель</label>
        <input type="text" class="form-control" id="car_model_form" placeholder="Модель автомобиля">
        <label for="car_number_form">Номер</label>
        <input type="text" class="form-control" id="car_number_form" placeholder="Номер автомобиля">
        <label for="fio_form">ФИО владельца</label>
        <input type="text" class="form-control" id="fio_form" placeholder="ФИО владельца">
        <label for="mobile_form">Телефон</label>
        <input type="text" class="form-control" id="mobile_form" placeholder="Мобильный телефон">
     </div>
     <div align="center">
        <button onclick="SaveCar()" type="button" class="btn btn-success">Сохранить</button>
     </div>    
</div>

<script>
function SaveCar(){    
    $.post(route+'controller/server/save_car_from_order.php',{        
        car_model: $("#car_model_form").val(),
        car_number: $("#car_number_form").val(),        
        fio_form: $("#fio_form").val(),
        mobile: $("#mobile_form").val()
    }, 
       function(data){                
            $('#dlg_car_add').dialog('close');
            $().toastmessage('showWarningToast', 'Данные сохранены!');              
            CarsLoad();
            $("#car_model_form").val("");
            $("#car_number_form").val("");
            $("#fio_form").val("");
            $("#mobile_form").val("");            
       }
    );    
};
function SaveOrder(){
    $.post(route+'controller/server/save_order.php',{
        order_id:<?php echo $order_id;?>,
        status: $("#status_id").val(),
        car_id: $("#car_id").val(),
        painter_id: $("#painter_id").val(),
        comments: $("#order_comment").val(),
    }, 
       function(data){                      
            $().toastmessage('showWarningToast', 'Данные сохранены!');              
            jQuery("#order_list").jqGrid().trigger('reloadGrid');                                
       }
    );                               
};    
function WorkList(){
        jQuery("#work_list").jqGrid({
            url:route+'controller/server/payments_list.php&type=1&order_id=<?php echo "$order_id";?>',
            datatype: "json",
            colNames:['Id','Сумма','Комментарий',''],
            colModel:[   		
                    {name:'id',index:'id', width:55,search: false,hidden:true,editable:false},                    
                    {name:'amount',index:'amount', width:80,search: false,editable:true,hidden:false,fixed:true},     
                    {name:'comment',index:'comment', width:150,search: true,editable:true},     
                    {name:'myac', width:60, fixed:true, sortable:false, resize:false, formatter:'actions',formatoptions:{keys:true},search: false}
            ],
            autowidth: true,			
            rowNum:10,	   	
            pager: '#work_pager',
            sortname: 'id',
            scroll:1,            
            footerrow : true,
            userDataOnFooter : true,
            altRows : true,
            height: 140,
            guiStyle: "bootstrap4",            
            viewrecords: true,
            sortorder: "desc",
            editurl:route+'controller/server/payments_list.php&type=1&order_id=<?php echo "$order_id";?>',
            caption:"Список работ"
        }).jqGrid("gridResize");
        $("#work_list").remapColumns([0,2,1],true,false);
        jQuery("#work_list").jqGrid('navGrid','#work_pager',{edit:modedit,add:modedit,del:modedit,search:false},{},{top: 0, left: 0, width: 500},{},{multipleSearch:false},{closeOnEscape:true} );            
        BindResizeble("#work_list","#work_list_div_id");    
        // Запчасти
        jQuery("#zap_list").jqGrid({
            url:route+'controller/server/payments_list.php&type=2&order_id=<?php echo "$order_id";?>',
            datatype: "json",
            colNames:['Id','Сумма','Комментарий','Код запчасти',''],
            colModel:[   		
                    {name:'id',index:'id', width:55,search: false,hidden:true,editable:false},                    
                    {name:'amount',index:'amount', width:80,search: false,editable:true,hidden:false,fixed:true},     
                    {name:'comment',index:'comment', width:150,search: true,editable:true},     
                    {name:'code',index:'code', width:150,search: true,editable:true,hidden:false},     
                    {name:'myac', width:60, fixed:true, sortable:false, resize:false, formatter:'actions',formatoptions:{keys:true},search: false}
            ],
            autowidth: true,			
            rowNum:10,	   	
            pager: '#zap_pager',
            sortname: 'id',
            scroll:1,            
            footerrow : true,
            userDataOnFooter : true,
            altRows : true,
            height: 140,
            guiStyle: "bootstrap4",            
            viewrecords: true,
            sortorder: "desc",
            editurl:route+'controller/server/payments_list.php&type=2&order_id=<?php echo "$order_id";?>',
            caption:"Список запчастей"
        }).jqGrid("gridResize");
        $("#zap_list").remapColumns([0,3,2,1],true,false);
        jQuery("#zap_list").jqGrid('navGrid','#zap_pager',{edit:modedit,add:modedit,del:modedit,search:false},{},{top: 0, left: 0, width: 500},{},{multipleSearch:false},{closeOnEscape:true} );            
        BindResizeble("#zap_list","#work_list_div_id");    
        // материалы
        jQuery("#mat_list").jqGrid({
            url:route+'controller/server/payments_list.php&type=3&order_id=<?php echo "$order_id";?>',
            datatype: "json",
            colNames:['Id','Сумма','Комментарий','Код запчасти',''],
            colModel:[   		
                    {name:'id',index:'id', width:55,search: false,hidden:true,editable:false},                    
                    {name:'amount',index:'amount', width:80,search: false,editable:true,hidden:false,fixed:true},     
                    {name:'comment',index:'comment', width:150,search: true,editable:true},     
                    {name:'code',index:'code', width:150,search: true,editable:false,hidden:true},     
                    {name:'myac', width:60, fixed:true, sortable:false, resize:false, formatter:'actions',formatoptions:{keys:true},search: false}
            ],
            autowidth: true,			
            rowNum:10,	   	
            pager: '#mat_pager',
            sortname: 'id',
            scroll:1,            
            footerrow : true,
            userDataOnFooter : true,
            altRows : true,
            height: 140,
            guiStyle: "bootstrap4",            
            viewrecords: true,
            sortorder: "desc",
            editurl:route+'controller/server/payments_list.php&type=3&order_id=<?php echo "$order_id";?>',
            caption:"Список материалов"
        }).jqGrid("gridResize");
        $("#zap_list").remapColumns([0,2,1],true,false);
        jQuery("#mat_list").jqGrid('navGrid','#mat_pager',{edit:modedit,add:modedit,del:modedit,search:false},{},{top: 0, left: 0, width: 500},{},{multipleSearch:false},{closeOnEscape:true} );            
        BindResizeble("#mat_list","#work_list_div_id");    

}    
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
function PhotosList(){
    $("#dop_photos").html("<img src='controller/client/img/loading.gif'>");
    $("#dop_photos" ).load(route+"controller/server/photos_list.php&order_id=<?php echo "$order_id";?>");    
};
function OpenPic(photo){
 console.log(photo);
 newWin = window.open('photos/'+photo, 'printWindow');    
};    
function DeletePic(id){
   if (modedit==true){
    $.confirm({
        title: 'Подтверждение',
        content: 'Уверены что хотите удалить фото?',
        buttons: {
                Да: function () {
                    $.post(route+'controller/server/photo_del.php',{
                        id:id
                    }, 
                        function(data){                      
                            $("#dop_photos").html("<img src='controller/client/img/loading.gif'>");
                            $("#dop_photos" ).load(route+"controller/server/photos_list.php&order_id=<?php echo "$order_id";?>");               
                        }
                    );                    
                },
                Нет: function () {
                    console.log("отменили");
                }
            }        
    });    
    } else {
     $().toastmessage('showWarningToast', 'Закрыто для редактирования!'); 
    };
};    
function AddPoint(e){
   if (modedit==true){
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
    } else {
        $().toastmessage('showWarningToast', 'Закрыто для редактирования!'); 
    };
};
$(function() {
    <?php
     if ($status==3){echo "\n modedit=false;\n";} else {{echo "\n modedit=true;\n";}};
    ?>
    // Окно точек
    $("#dlg_point" ).dialog({
      autoOpen: false,        
      resizable: false,
      height:'auto',
      width: 'auto',
      modal: true,        
    });      
    //окно добавления авто
    $("#dlg_car_add" ).dialog({
      autoOpen: false,        
      resizable: false,
      height:'auto',
      width: 'auto',
      modal: true,        
    });      
    // Загружаем список автомобилей
    CarsLoad();
    // Загружаем список исполнителей
    PointersLoad();      
    // Загружаем список точек
    PointsLoad();
    // Загружаем работы
    WorkList();
    // Загружаем фоточки
    PhotosList();
    // работа с загрузкой фото
    $('#new_dop_photo_load').fileapi({
            url: route + 'controller/server/uploadfiles_dop.php?',
            data: {'order_id': <?php echo "$order_id";?>},
            multiple: true,
            maxSize: 10000 * FileAPI.MB,
            autoUpload: true,
            onFileComplete: function(evt, uiEvt) {
                    if (uiEvt.result.msg != 'error') {
                            filename=uiEvt.result.msg;
                                $("#dop_photos").html("<img src='controller/client/img/loading.gif'>");
                                $("#dop_photos" ).load(route+"controller/server/photos_list.php&order_id=<?php echo "$order_id";?>");    

                    }
            },
            elements: {
                    size: '.js-size',
                    active: {show: '.js-upload', hide: '.js-browse'},
                    progress: '.js-progress'
            }
    });
    
});    
</script>    