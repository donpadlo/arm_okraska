<div class="form-group">
    <label for="dtstart">Период</label>
    <input class="form-control" name="dtstart" id="dtstart" size=16 value="" readonly>
    <label for="painter_id">Исполнитель</label>
    <div id="painters_list_div"></div>
    <button onclick="CreateReport()" type="button" class="btn btn-success">Сформировать</button>
</div>
<div id="report">
    Данный отчет формирует список выплат по по заказам
</id>
<script>
function  CreateReport(){
  $("#report").html("<img src='controller/client/img/loading.gif'>");
    $.post(route+'controller/server/report_orders.php',{
        dt:$("#dtstart").val(),
        painter_id: $("#painter_id").val()
    }, 
       function(data){             
         $("#report").html(data);            
       }
    );  
};   
function PointersLoad(){
    $.post(route+'controller/server/sel_list_painters.php',{default:-1}, 
       function(data){             
         $("#painters_list_div").html(data)
          $(".chosen-select").chosen();
          $("#painter_id").chosen('destroy').val([-1]).chosen();          
       }
    );                   
};
$(function() {    
    year=<?php echo Date("Y");?>;
    month=<?php echo Date("m");?>;   
        $("#dtstart").datepicker();
        $("#dtstart").datepicker( "option", "dateFormat", "dd.mm.yy");
        $("#dtstart").datepicker({    
            beforeShow: function() {
                setTimeout(function(){$(".ui-datepicker").css("z-index", 99999999999999);}, 0);
            }
        });    	                
        $("#dtstart").datepicker( "setDate" , "0");
        PointersLoad();
});    
</script>    