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
$where = "";
$cnt = @count($flt['rules']);
for ($i = 0; $i < $cnt; $i ++) {
    $field = $flt['rules'][$i]['field'];
    $data = $flt['rules'][$i]['data'];
    $where = $where . "($field LIKE '%$data%')";
    if ($i < ($cnt - 1)) {
        $where = $where . " AND ";
    }
}
if ($where != "") {$where = "WHERE " . $where;}

if ($oper==""){
    $sql = "select count(*) as snt from painters $where ";
//echo "$sql<br/>";    
    $result = $sqlcn->ExecuteSQL($sql) or die("Не могу выбрать количество painters!" . mysqli_error($sqlcn->idsqlconnection));
    $row = mysqli_fetch_array($result);
    $count = $row['snt'];    
    if ($count > 0) {$total_pages = ceil($count / $limit);} else {$total_pages = 0;}    
    if ($page > $total_pages) $page = $total_pages;    
    $start = $limit * $page - $limit;
    if ($start<0){$start=0;};
    
 $sql = "select * from painters $where ORDER BY $sidx $sord LIMIT $start , $limit";      
 $result = $sqlcn->ExecuteSQL($sql) or die("Не могу выбрать список painters!" . mysqli_error($sqlcn->idsqlconnection));
    $responce = new stdClass();
    $responce->page = $page;
    $responce->total = $total_pages;
    $responce->records = $count;
    $i = 0;
    while ($row = mysqli_fetch_array($result)) {
        $responce->rows[$i]['id'] = $row['id'];        
        $responce->rows[$i]['cell'] = array(
            $row['id'],
            $row['dtcreate'],
            $row['fio'],
            $row['mobile']
        );
        $i ++;
    }
    echo json_encode($responce);    
};   
if ($oper=="edit"){
 $id = _POST('id');   
 $fio = _POST('fio');
 $mobile = _POST('mobile');
 $sql="update painters set fio='$fio',mobile='$mobile' where id=$id";
 //echo "$sql";
 $result = $sqlcn->ExecuteSQL($sql) or die("Не удалось обновить painters!" . mysqli_error($sqlcn->idsqlconnection));
};
if ($oper=="add"){
 $id = _POST('id');   
 $fio = _POST('fio');
 $mobile = _POST('mobile');
 if ($fio!=""){
   $sql="insert into painters (id,dtcreate,fio,mobile,image) values "
           . "(null,now(),'$fio','$mobile','')";  
   $result = $sqlcn->ExecuteSQL($sql) or die("Не удалось добавить painters!" . mysqli_error($sqlcn->idsqlconnection));
 };
};
if ($oper=="del"){
    $id = _POST('id');  
    $sql="delete from painters where id=$id";
    $result = $sqlcn->ExecuteSQL($sql) or die("Не удалось удалить painters!" . mysqli_error($sqlcn->idsqlconnection));
};
