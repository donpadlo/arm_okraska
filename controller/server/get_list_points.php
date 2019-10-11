<?php
$order_id= _POST("order_id");

$sql="select * from points where order_id=$order_id";
$result = $sqlcn->ExecuteSQL($sql) or die("Не могу выбрать список points!" . mysqli_error($sqlcn->idsqlconnection));
$cnt=0;
$res=array();
while ($row = mysqli_fetch_array($result)) {
    $coors= json_decode($row["coors"]);
    $res[$cnt]["coors"]=$coors;
    $res[$cnt]["comments"]=$row["comments"];
    $cnt++;
};
echo json_encode($res);
?>