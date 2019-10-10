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
            colNames:['Id','Добавлен','Закрыт','Автомобиль','Исполнитель','Статус','Комментарий',''],
            colModel:[   		
                    {name:'orders.id',index:'orders.id', width:55,search: false,hidden:true,editable:false},                    
                    {name:'dtcreate',index:'dtcreate', width:150,search: true,editable:false,hidden:false,editable:false},     
                    {name:'dtclose',index:'dtclose', width:150,search: true,editable:false,hidden:false,editable:false},     
                    {name:'cars.number',index:'cars.number', width:150,search: true,editable:false},     
                    {name:'painters.fio',index:'painters.fio', width:150,search: true,editable:false},     
                    {name:'status',index:'status', width:150,search: true,editable:true},     
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
        }).jqGrid("gridResize");
        jQuery("#order_list").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false});
        jQuery("#order_list").jqGrid('navGrid','#order_pager',{edit:true,add:false,del:true,search:true},{},{top: 0, left: 0, width: 500},{},{multipleSearch:false},{closeOnEscape:true} );    
        jQuery("#order_list").jqGrid('navButtonAdd',"#order_pager",{caption:'Добавить заказ',                              
            title: "Создать новый заказ",            
            position:"last",
            onClickButton:function(){
            }        
        });        
        BindResizeble("#order_list","#maincontent");
</script> 