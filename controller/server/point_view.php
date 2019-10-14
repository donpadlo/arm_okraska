<?php
$point_id= _GET("point_id");
$sql="select * from points where id=$point_id";
$result = $sqlcn->ExecuteSQL($sql) or die("Не могу выбрать список points!" . mysqli_error($sqlcn->idsqlconnection));
$comments="";
while ($row = mysqli_fetch_array($result)) {
  $comments=$row["comment"];
  $amount_point=$row["amount"];
  $cnt_point=$row["cnt"];
  $photo=$row["photo"];
};
if (! file_exists(WUO_ROOT."/photos/$photo")) {
    $photo = 'noimage.jpg';
};
if ($photo==""){$photo = 'noimage.jpg';};
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6" style="padding-right: 0px; padding-left: 0px;">
            <div id="userpic" class="userpic">
                <a target="_blank" href="photos/<?php echo "$photo";?>">
                    <div class="js-preview userpic__preview thumbnail" id="image_set_id">			                    
                            <img width="100%" src="photos/<?php echo "$photo";?>">                    
                    </div>
                </a>                    
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
        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6" style="padding-right: 0px; padding-left: 0px;">
            <div class="form-group">
                <label for="point_amount_win_textarea">Цена за работу</label>
                <input type="text" class="form-control" id="point_amount_win_textarea" placeholder="Цена за работу" value="<?php echo "$amount_point";?>">
                <label for="point_cnt_win_textarea">Количество</label>
                <input type="text" class="form-control" id="point_cnt_win_textarea" placeholder="Количество" value='<?php echo "$cnt_point";?>'>                
                <label for="point_commets_win_textarea">Комментарий</label>
                <textarea class="form-control" id="point_commets_win_textarea" rows="2" name="point_commets_win_textarea"><?php echo "$comments";?></textarea>
            </div>            
        </div>
    </div>
</div> 
<div align="center">
    <button onclick="SavePointCommetns()" type="button" class="btn btn-success">Сохранить изменения</button>
</div>
<script>
function SavePointCommetns(){
    $.post(route+'controller/server/point_save_comment.php',{
        point_id:<?php echo $point_id;?>,
        comments: $("#point_commets_win_textarea").val(),
        amount: $("#point_amount_win_textarea").val(),
        cnt: $("#point_cnt_win_textarea").val()
    }, 
       function(data){                      
         $().toastmessage('showWarningToast', 'Сохранено');          
         $("#dlg_point" ).dialog("close");  
         jQuery("#work_list").jqGrid().trigger('reloadGrid');                                
       }
    );        
};    
$(function() {
    $('#simple-btn').fileapi({
            url: route + 'controller/server/uploadpics.php',
            data: {'point_id': <?php echo "$point_id";?>},
            multiple: true,
            maxSize: 10000 * FileAPI.MB,
            autoUpload: true,
            onFileComplete: function(evt, uiEvt) {
                    if (uiEvt.result.msg != 'error') {
                           filename=uiEvt.result.msg;
                           $("#image_set_id").html('<img width="100%" src="photos/'+filename+'"> ');
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