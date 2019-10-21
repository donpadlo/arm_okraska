<?php
    $mode= _POST("mode");
    $per_end=_POST("per_end");
    $per_start=_POST("per_start");
    $painter_id=_POST("painter_id");
    $vp_20_0=GetPay20Pers($per_start,$per_end,0,$painter_id);
    $vp_20_1=GetPay20Pers($per_start,$per_end,1,$painter_id);
    $vp_30_0=GetPay30Pers($per_start,$per_end,0,$painter_id);
    $vp_30_1=GetPay30Pers($per_start,$per_end,1,$painter_id);    
    if ($mode==20){
        ?>            
        <div class="card-group">
          <div class="card">    
            <div class="card-body">
              <h5 class="card-title">Доплаты</h5>
              <p class="card-text"><?php echo "Выплачено 20%: $vp_20_1,к выплате: $vp_20_0";?></p>      
              <p class="card-text"><?php echo "Выплачено 30%: $vp_30_1,к выплате: $vp_30_0"; ?></p>
            </div>
          </div>
        </div>        
        <?php
    };
    if ($mode==30){
        ?>            
        <div class="card-group">
          <div class="card">    
            <div class="card-body">
              <h5 class="card-title">Текущие выплаты</h5>
              <p class="card-text"><?php echo "Выплачено 20%: $vp_20_1,к выплате: $vp_20_0";?></p>      
              <p class="card-text"><?php echo "Выплачено 30%: $vp_30_1,к выплате: $vp_30_0"; ?></p>
            </div>
          </div>
        </div>        
        <?php
        };
    
?>    