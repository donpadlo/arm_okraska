<?php
$sql="select * from cars";
$result = $sqlcn->ExecuteSQL($sql) or die("Не могу выбрать список автомобилей!" . mysqli_error($sqlcn->idsqlconnection));
$sts = "<select class='chosen-select' style='width:100%;' tabindex='40' name=car_id id=car_id>";
$sts = $sts . "<option value='-1'>Не выбрано</option>";
while ($row = mysqli_fetch_array($result)) {
        $id = $row["id"];
        $name = $row["number"]." (".$row["fio"].")";
        $sts = $sts . "<option value='$id'>$name</option>";
    }
$sts = $sts . "</select>";
echo "$sts";
?>