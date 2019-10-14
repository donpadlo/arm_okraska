<link rel="stylesheet" href="controller/client/css/upload.css">
<link rel="stylesheet" href="controller/client/css/jquery.Jcrop.min.css">
<script src="controller/client/js/FileAPI/FileAPI.min.js"></script>
<script src="controller/client/js/FileAPI/FileAPI.exif.js"></script>
<script src="controller/client/js/jquery.fileapi.js"></script>
<script src="controller/client/js/jquery.Jcrop.min.js"></script>
<script src="controller/client/js/statics/jquery.modal.js"></script>
<div class="container-fluid">
        <div class="row" style="padding-right: 0px; padding-left: 0px;">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12" style="padding-right: 0px; padding-left: 0px;">							
                    <table id="order_list"></table>
                    <div id="order_pager"></div>                        
                </div>
        </div>
                    <div id="order_div">
                        Выберите заказ или добавьте его
                    </div>    
</div>
<script>
        jQuery("#order_list").jqGrid({
            url:route+'controller/server/order_grid.php',
            datatype: "json",
            colNames:['Id','Добавлен','Закрыт','Автомобиль','Исполнитель','Статус','Работа','Материалы','Запчасти','Комментарий',''],
            colModel:[   		
                    {name:'orders.id',index:'orders.id', width:55,search: false,hidden:true,editable:false},                    
                    {name:'dtcreate',index:'dtcreate', width:150,search: true,editable:false,hidden:false,editable:false},     
                    {name:'dtclose',index:'dtclose', width:150,search: true,editable:false,hidden:false,editable:false},     
                    {name:'cars.number',index:'cars.number', width:150,search: true,editable:false},     
                    {name:'painters.fio',index:'painters.fio', width:150,search: true,editable:false},     
                    {name:'status',index:'status', width:100,search: true,
                        edittype: "select",
                         editoptions: {
                             value: "0:Новый;1:В работе;3:Закрыт"
                         }
                        ,editable:true},
                    {name:'work_cost',index:'work_cost', width:100,search: false,editable:false,sortable:false},
                    {name:'mat_cost',index:'mat_cost', width:100,search: false,editable:false,sortable:false},
                    {name:'zap_cost',index:'zap_cost', width:100,search: false,editable:false,sortable:false},
                    {name:'comment',index:'comment', width:150,search: true,editable:true},     
                    {name:'myac', width:60, fixed:true, sortable:false, resize:false, formatter:'actions',formatoptions:{keys:true},search: false}
            ],
            autowidth: true,			
            rowNum:10,	   	
            pager: '#order_pager',
            sortname: 'orders.id',
            scroll:1,            
            userDataOnFooter : true,
            altRows : true,
            height: 140,
            guiStyle: "bootstrap4",            
            viewrecords: true,
            sortorder: "desc",
            editurl:route+'controller/server/order_grid.php',
            caption:"Список заказов",
            onSelectRow: function(ids) {	
                $("#order_div").html("<img src='controller/client/img/loading.gif'>");
                $("#order_div" ).load(route+"controller/server/order_view.php&order_id="+ids);
	    },            
        }).jqGrid("gridResize");
        jQuery("#order_list").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false});
        jQuery("#order_list").jqGrid('navGrid','#order_pager',{edit:true,add:false,del:true,search:true},{},{top: 0, left: 0, width: 500},{},{multipleSearch:false},{closeOnEscape:true} );    
        jQuery("#order_list").jqGrid('navButtonAdd',"#order_pager",{caption:'Добавить заказ',                              
            title: "Создать новый заказ",            
            position:"last",
            onClickButton:function(){
                $("#order_div").html("<img src='controller/client/img/loading.gif'>");
                $("#order_div" ).load(route+"controller/server/order_view.php&mode=addnew");
            }        
        });        
        BindResizeble("#order_list","#maincontent");
</script> 