<?php
$point_id= _GET("point_id");
$sql="select * from points where id=$point_id";
$result = $sqlcn->ExecuteSQL($sql) or die("Не могу выбрать список points!" . mysqli_error($sqlcn->idsqlconnection));
$comments="";
while ($row = mysqli_fetch_array($result)) {
  $comments=$row["comments"];
  $photo=$row["photo"];
};
if (! file_exists(WUO_ROOT."/photos/$photo")) {
    $photo = 'noimage.jpg';
};
if ($photo==""){$photo = 'noimage.jpg';};
?>
<div class="container-fluid">
    <div class="row">
        <div id="userpic" class="userpic">
            <div class="js-preview userpic__preview thumbnail" id="image_set_id">			
                <img width="200px" height="200px" src="photos/<?php echo "$photo";?>"> 
            </div>
            <div align="center" id="simple-btn" class="btn btn-primary js-fileapi-wrapper" style="text-align: center;">
                    <div class="js-browse" align="center">
                        <span class="btn-txt">Загрузить файл</span> 
                        <input type="file" name="filedata">
                    </div>
                    <div class="js-upload" style="display: none">
                        <div class="progress progress-success">
                            <div class="js-progress bar"></div>
                        </div>
                        <span align="center" class="btn-txt">Загружаю (<span class="js-size"></span>)</span>
                    </div>
            </div>
        </div>			                                                                       
    </div>
</div> 
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