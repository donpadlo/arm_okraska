<?php
$point_id= _GET("point_id");
$sql="select * from points where id=$point_id";
$result = $sqlcn->ExecuteSQL($sql) or die("Не могу выбрать список points!" . mysqli_error($sqlcn->idsqlconnection));
$comments="";
while ($row = mysqli_fetch_array($result)) {
  $comments=$row["comments"];
};
?>
<div class="form-group">
    <label for="point_commets_win_textarea">Комментарий</label>
    <textarea class="form-control" id="point_commets_win_textarea" rows="2" cols="45" name="point_commets_win_textarea"><?php echo "$comments";?></textarea>
</div>
<div align="center">
    <button onclick="SavePointCommetns()" type="button" class="btn btn-success">Сохранить изменения</button>
</div>
<script>
function SavePointCommetns(){
    $.post(route+'controller/server/point_save_comment.php',{
        point_id:<?php echo $point_id;?>,
        comments: $("#point_commets_win_textarea").val()
    }, 
       function(data){                      
         $().toastmessage('showWarningToast', 'Сохранено');          
         $("#dlg_point" ).dialog("close");  
       }
    );        
};    
</script>    