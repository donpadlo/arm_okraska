<?php
$page = _GET('page');
$limit = _GET('rows');
$sidx = _GET('sidx');
$sord = _GET('sord');
$oper = _POST('oper');
$id = _POST('id');
$order_id= _GET("order_id");
$type= _GET("type");

if ($oper==""){
    if ($type=="1"){
        $sql = "select count(*) as snt from points where order_id=$order_id";
    } else {
        $sql = "select count(*) as snt from payments where order_id=$order_id and type=$type ";
    };
//echo "$sql<br/>";    
    $result = $sqlcn->ExecuteSQL($sql) or die("Не могу выбрать количество payments!" . mysqli_error($sqlcn->idsqlconnection));
    $row = mysqli_fetch_array($result);
    $count = $row['snt'];    
    if ($count > 0) {$total_pages = ceil($count / $limit);} else {$total_pages = 0;}    
    if ($page > $total_pages) $page = $total_pages;    
    $start = $limit * $page - $limit;
    if ($start<0){$start=0;};

    if ($type=="1"){
         $sql = "select * from points where order_id=$order_id ORDER BY $sidx $sord LIMIT $start , $limit";      
    } else {
         $sql = "select * from payments where order_id=$order_id and type=$type ORDER BY $sidx $sord LIMIT $start , $limit";      
    };    
    $result = $sqlcn->ExecuteSQL($sql) or die("Не могу выбрать список cars!" . mysqli_error($sqlcn->idsqlconnection));
    $responce = new stdClass();
    $responce->page = $page;
    $responce->total = $total_pages;
    $responce->records = $count;
    $i = 0;
    $summ=0;
    while ($row = mysqli_fetch_array($result)) {
        $responce->rows[$i]['id'] = $row['id'];        
        $responce->rows[$i]['cell'] = array(
            $row['id'],
            $row['amount'],
            $row['cnt'],
            round($row['cnt']*$row['amount'],2),
            $row['comment'],
        );
        $summ=$summ+round($row['cnt']*$row['amount'],2);
        $i ++;
    };
    $responce->userdata['amount'] = 'Всего:';
    $responce->userdata['summ'] = $summ . ' руб';    
    echo json_encode($responce);    
};   
if ($oper=="edit"){
 $id = _POST('id');   
 $amount = _POST('amount');
 $cnt = _POST('cnt');
 $comment = _POST('comment');
    if ($type=="1"){
        $sql="update points set amount='$amount',cnt='$cnt',comment='$comment' where id=$id";
    } else {
        $sql="update payments set amount='$amount',cnt='$cnt',comment='$comment' where id=$id";
    };   
 //echo "$sql";
 $result = $sqlcn->ExecuteSQL($sql) or die("Не удалось обновить $sql!" . mysqli_error($sqlcn->idsqlconnection));
};
if ($oper=="add"){
 $id = _POST('id');   
 $amount = _POST('amount');
 $cnt = _POST('cnt');
 $comment = _POST('comment');
   $sql="insert into payments (id,order_id,type,amount,cnt,comment) values "
           . "(null,$order_id,'$type','$amount','$cnt','$comment')";  
   //echo "$sql!";
   $result = $sqlcn->ExecuteSQL($sql) or die("Не удалось добавить payments!" . mysqli_error($sqlcn->idsqlconnection)); 
};
if ($oper=="del"){
    $id = _POST('id');  
    if ($type=="1"){
        $sql="delete from points where id=$id";
    } else {
        $sql="delete from payments where id=$id";
    };       
    $result = $sqlcn->ExecuteSQL($sql) or die("Не удалось удалить payments!" . mysqli_error($sqlcn->idsqlconnection));
};
?>