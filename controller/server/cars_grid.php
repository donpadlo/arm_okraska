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
    $sql = "select count(*) as snt from cars $where ";
//echo "$sql<br/>";    
    $result = $sqlcn->ExecuteSQL($sql) or die("Не могу выбрать количество cars!" . mysqli_error($sqlcn->idsqlconnection));
    $row = mysqli_fetch_array($result);
    $count = $row['snt'];    
    if ($count > 0) {$total_pages = ceil($count / $limit);} else {$total_pages = 0;}    
    if ($page > $total_pages) $page = $total_pages;    
    $start = $limit * $page - $limit;
    if ($start<0){$start=0;};
    
 $sql = "select * from cars $where ORDER BY $sidx $sord LIMIT $start , $limit";      
 $result = $sqlcn->ExecuteSQL($sql) or die("Не могу выбрать список cars!" . mysqli_error($sqlcn->idsqlconnection));
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
            $row['model'],
            $row['number'],                        
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
 $model = _POST('model');
 $number = _POST('number');
 $sql="update cars set fio='$fio',mobile='$mobile',number='$number',model='$model' where id=$id";
 //echo "$sql";
 $result = $sqlcn->ExecuteSQL($sql) or die("Не удалось обновить cars!" . mysqli_error($sqlcn->idsqlconnection));
};
if ($oper=="add"){
 $id = _POST('id');   
 $fio = _POST('fio');
 $mobile = _POST('mobile');
 $model = _POST('model');
 $number = _POST('number'); 
 if ($fio!=""){
   $sql="insert into cars (id,dtcreate,model,number,fio,mobile) values "
           . "(null,now(),'$model','$number','$fio','$mobile')";  
   echo "$sql!";
   $result = $sqlcn->ExecuteSQL($sql) or die("Не удалось добавить cars!" . mysqli_error($sqlcn->idsqlconnection));
 };
};
if ($oper=="del"){
    $id = _POST('id');  
    $sql="delete from cars where id=$id";
    $result = $sqlcn->ExecuteSQL($sql) or die("Не удалось удалить cars!" . mysqli_error($sqlcn->idsqlconnection));
};
