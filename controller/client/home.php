<div id="period_area" style="display: none"> 
    <fieldset>    
        <label for="OldYear"><?php echo Date("Y")-1;?></label>
        <input onclick="year=<?php echo Date("Y")-1;?>;RePaintFace(month);" type="radio" name="RYear" id="OldYear">
        <label for="CurYear"><?php echo Date("Y");?></label>
        <input onclick="year=<?php echo Date("Y");?>;RePaintFace(month);" type="radio" name="RYear" id="CurYear">
     </fieldset>
    <hr>
    <fieldset>    
    <?php
     foreach ($month_array as $key => $month) {
        echo "<label for=\"month$key\">$month</label>";
        echo "<input onclick=\"RePaintFace($key);\" type=\"radio\" name=\"RMonth\" id=\"month$key\">";    
    };
    ?>
    </fieldset>
</div>
<input name="dtstart" id="dtstart" size=16 value="" readonly>
<div class="container-fluid" style="padding-right: 0px; padding-left: 0px;">
        <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-6">							
                    <table id="driverslist"></table>
                    <div id="driverspager"></div>                        
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-6">							
                    <div id="balance_at_home_info"></div>                        
                </div>
        </div>
</div>
<div id="dlg_driver" title="Выберите водителя">
    <p>Найдите водителя которого нужно добавить в этот месяц</p>
   <div id="sl_driver_list"> </div>
</div>
<script>
function RePaintFace(mm){   
        $("#balance_at_home_info").html("");
        $('#driverslist').jqGrid('GridUnload');
        month=mm;
        $("#dtstart").datepicker( "setDate" ,"01."+month+"."+year);
        console.log("Выбран год/месяц:",year,"/",month);
        jQuery("#driverslist").jqGrid({
            url:route+'controller/server/drivers.php&month='+month+"&year="+year,
            datatype: "json",
            colNames:['Id','Водитель','Баланс','Бригадир','Модель',"Номер",'Права','Паспорт','Телефон'],
            colModel:[   		
                    {name:'drivers.id',index:'drivers.id', width:55,search: false,hidden:true},
                    {name:'name',index:'name', width:150,search: true},  
                    {name:'balance',index:'balance', width:50,search: true,sortable: false},
                    {name:'bname',index:'bname', width:150,search: true},
                    {name:'car_model',index:'car_model', width:50,search: true,hidden:true},                        
                    {name:'car_number',index:'car_number', width:50,search: true},                        
                    {name:'dlicense',index:'dlicense', width:50,search: true,hidden:true},                        
                    {name:'pasport',index:'pasport', width:50,search: true,hidden:true},
                    {name:'mobile',index:'mobile', width:50,search: true,hidden:true}
            ],
            autowidth: true,			
            rowNum:10,	   	
            pager: '#driverspager',
            sortname: 'drivers.id',
            scroll:1,
            footerrow : true,
            userDataOnFooter : true,
            altRows : true,
            height: 480,
            viewrecords: true,
            sortorder: "desc",
            editurl:route+'controller/server/drivers.php&month='+month+"&year="+year,
            caption:"Список водителей",
            onSelectRow: function(ids) {	
		$("#balance_at_home_info" ).load(route+"controller/server/balance_at_home_info.php&id="+ids+"&month="+month+"&year="+year+"&random="+getRandomInt(1,1000));                                                                                         
	    },
        });        
        jQuery("#driverslist").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false});
        jQuery("#driverslist").jqGrid('navGrid','#driverspager',{edit:false,add:false,del:false,search:true},{},{top: 0, left: 0, width: 500},{},{multipleSearch:false},{closeOnEscape:true} );            
        jQuery("#driverslist").jqGrid('navButtonAdd',"#driverspager",{caption:'Добавить водителя',                              
            title: "Добавить водителя в этот месяц",            
            position:"last",
            onClickButton:function(){
                $("#dlg_driver" ).dialog("open" );       
                $(".chosen-select").chosen();
            }        
        });
        
};    
$(function() {
        $("#dlg_driver" ).dialog({
          autoOpen: false,        
          resizable: false,
          height:400,
          width: 640,
          modal: true,
      buttons: {
        "Добавить": function() {
            $( this ).dialog( "close" );            
            $.post(route+'controller/server/add_null_to_balance.php',{
                    driver_id:$("#sel_drive_list_ids").val(),
                    year:year,
                    month:month
                }, 
               function(data){             
                 jQuery("#driverslist").jqGrid().trigger('reloadGrid');                                
               }
            );               
          }        
      }          
        });  
        $.post(route+'controller/server/get_list_drivers.php',{mode:'get_select_list'}, 
           function(data){             
             $("#sl_driver_list").html(data);            
           }
        );          
        year=<?php echo Date("Y");?>;
        month=<?php echo Date("m");?>;      
        $( "#CurYear" ).checkboxradio({icon: false});
        $( "#OldYear" ).checkboxradio({icon: false});
        $('#CurYear').prop('checked',true).checkboxradio('refresh');
        for (var i=1;i<13;i++){
            $('#month'+i).checkboxradio({icon: false});
            $('#month'+i).prop('checked',false).checkboxradio('refresh');
        };
        $('#month'+month).prop('checked',true).checkboxradio('refresh');
        $('#OldYear').prop('checked',false).checkboxradio('refresh');
        $('#CurYear').prop('checked',true).checkboxradio('refresh');

        $("#dtstart").datepicker();
        $("#dtstart").datepicker( "option", "dateFormat", "dd.mm.yy");
        $("#dtstart").datepicker({    
            beforeShow: function() {
                setTimeout(function(){$(".ui-datepicker").css("z-index", 99999999999999);}, 0);
            }
        });    	
        $("#period_area").show();
        RePaintFace(month);
        $("#dtstart").datepicker( "setDate" , "0");
});
</script>