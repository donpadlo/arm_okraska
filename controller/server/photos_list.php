<?php
$order_id= _GET("order_id");
$sql = "select * from images where order_id=$order_id";
$result = $sqlcn->ExecuteSQL($sql) or die("Не могу выбрать список images!" . mysqli_error($sqlcn->idsqlconnection));
while ($row = mysqli_fetch_array($result)) {
  $photo=$row["image"];
  echo "<a target='_blank' href='photos/$photo'><img src='photos/$photo' width='200px'></a>";
};
 