<div class="container-fluid">
        <div class="row" style="padding-right: 0px; padding-left: 0px;">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12" style="padding-right: 0px; padding-left: 0px;">							
                    <table id="paint_list"></table>
                    <div id="paint_pager"></div>                        
                </div>
        </div>
</div>
<script>
        jQuery("#paint_list").jqGrid({
            url:route+'controller/server/painters_grid.php',
            datatype: "json",
            colNames:['Id','Добавлен','ФИО','Телефон',''],
            colModel:[   		
                    {name:'id',index:'id', width:55,search: false,hidden:true},                    
                    {name:'dtcreate',index:'dtcreate', width:150,search: true,editable:false,hidden:true},     
                    {name:'fio',index:'fio', width:150,search: true,editable:true},     
                    {name:'mobile',index:'mobile', width:150,search: true,editable:true},     
                    {name:'myac', width:60, fixed:true, sortable:false, resize:false, formatter:'actions',formatoptions:{keys:true},search: false}
            ],
            autowidth: true,			
            rowNum:10,	   	
            pager: '#paint_pager',
            sortname: 'fio',
            scroll:1,            
            userDataOnFooter : true,
            altRows : true,
            height: 140,
            guiStyle: "bootstrap4",            
            viewrecords: true,
            sortorder: "desc",
            editurl:route+'controller/server/painters_grid.php',
            caption:"Список исполнителей",
        }).jqGrid("gridResize");
        jQuery("#paint_list").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false});
        jQuery("#paint_list").jqGrid('navGrid','#paint_pager',{edit:true,add:true,del:true,search:true},{},{top: 0, left: 0, width: 500},{},{multipleSearch:false},{closeOnEscape:true} );    
//        $("#paint_list").navButtonAdd('#paint_pager',{
//                caption: "<i class=\"fas fa-align-justify\"></i>",
//                title: "Выбор колонок",				
//                buttonicon: 'none',
//                onClickButton: function () {
//                      $("#paint_list").jqGrid('columnChooser');
//                }
//        });                
        BindResizeble("#paint_list","#maincontent");
</script> 