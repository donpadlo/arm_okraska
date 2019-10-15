<?php
$order_id= _GET("order_id");
$sql = "select * from images where order_id=$order_id";
$result = $sqlcn->ExecuteSQL($sql) or die("Не могу выбрать список images!" . mysqli_error($sqlcn->idsqlconnection));
while ($row = mysqli_fetch_array($result)) {
  $id=$row["id"];
  $photo=$row["image"];
?>  
    <div class="card" style="width: 200px">      
        <img src="photos/<?php echo "$photo";?>" class="card-img-top">      
      <div class="card-img-overlay">
        <p class="me-cart card-title icons_pic">            
                <i onclick='DeletePic(<?php echo $id;?>);' class="fas fa-trash-alt"></i>                        
                <i onclick='OpenPic("<?php echo "$photo";?>");' class="fas fa-search-location"></i>            
        </p>
      </div>
    </div>  
<?php
};
?> 