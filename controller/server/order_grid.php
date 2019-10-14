<?php
$page = _GET('page');
$limit = _GET('rows');
$sidx = _GET('sidx');
$sord = _GET('sord');
$oper = _POST('oper');
$id = _POST('id');



// ///////////////////////////
// вычисляем фильтр
// ///////////////////////////
$filters = "";
if (isset($_GET["filters"])) {
    $filters = $_GET['filters'];
}
// получаем наложенные поисковые фильтры
$flt = json_decode($filters, true);
$where = "WHERE orders.archive=0 ";
$cnt = @count($flt['rules']);
for ($i = 0; $i < $cnt; $i ++) {
    $field = $flt['rules'][$i]['field'];
    $data = $flt['rules'][$i]['data'];
    $where = $where . " AND ($field LIKE '%$data%')";    
}
if ($oper==""){
    $sql = "select count(orders.id) as snt from orders left join cars on cars.id=orders.car_id left join painters on painters.id=orders.painter_id  $where ";
//echo "$sql<br/>";    
    $result = $sqlcn->ExecuteSQL($sql) or die("Не могу выбрать количество painters!" . mysqli_error($sqlcn->idsqlconnection));
    $row = mysqli_fetch_array($result);
    $count = $row['snt'];    
    if ($count > 0) {$total_pages = ceil($count / $limit);} else {$total_pages = 0;}    
    if ($page > $total_pages) $page = $total_pages;    
    $start = $limit * $page - $limit;
    if ($start<0){$start=0;};
    
 $sql = "select orders.id,orders.dtcreate,orders.dtclose,orders.status,orders.comments,cars.number as car,painters.fio from orders left join cars on cars.id=orders.car_id left join painters on painters.id=orders.painter_id $where ORDER BY $sidx $sord LIMIT $start , $limit";       
 $result = $sqlcn->ExecuteSQL($sql) or die("Не могу выбрать список painters!" . mysqli_error($sqlcn->idsqlconnection));
    $responce = new stdClass();
    $responce->page = $page;
    $responce->total = $total_pages;
    $responce->records = $count;
    $i = 0;
    while ($row = mysqli_fetch_array($result)) {
        $responce->rows[$i]['id'] = $row['id'];        
        switch ($row['status']) {
            case 0:$row['status']="Новый";break;
            case 1:$row['status']="В работе";break;
            case 3:$row['status']="Закрыт";break;
            default:break;
        };
        $order_info=GetOrderInfo($row['id']);
        $responce->rows[$i]['cell'] = array(
            $row['id'],
            $row['dtcreate'],
            $row['dtclose'],
            $row['car'],
            $row['fio'],
            $row['status'],
            $order_info["work"],
            $order_info["mat"],
            $order_info["zap"],
            $row['comments']            
        );
        $i ++;
    }
    echo json_encode($responce);    
};   
if ($oper=="edit"){
 $id = _POST('id');   
 $comments = _POST('comment');
 $status = _POST('status');
 if ($status==3){
    $sql="update orders set dtclose=now(),status='$status',comments='$comments' where id=$id"; 
 } else {
    $sql="update orders set dtclose=null,status='$status',comments='$comments' where id=$id";
 };
 //echo "$sql";
 $result = $sqlcn->ExecuteSQL($sql) or die("Не удалось обновить orders!" . mysqli_error($sqlcn->idsqlconnection));
};
if ($oper=="del"){
    $id = _POST('id');  
    $sql="update orders set archive=1 where id=$id";
    $result = $sqlcn->ExecuteSQL($sql) or die("Не удалось пометить на удаление orders!" . mysqli_error($sqlcn->idsqlconnection));
};
