<?php
$rs = array(
    'msg' => 'error'
); // Ответ по умолчанию, если пойдёт что-то не так
$dis = array(
    '.htaccess'
); // Запрещённые для загрузки файлы
$order_id= _POST("order_id");
$orig_file = $_FILES['filedata']['name'];
if (! in_array($orig_file, $dis)) {
    $userfile_name = GetRandomId(8) . '.' . pathinfo($orig_file, PATHINFO_EXTENSION);
    $src = $_FILES['filedata']['tmp_name'];
    $dst = WUO_ROOT . '/photos/' . $userfile_name;
    $res = move_uploaded_file($src, $dst);
    if ($res) {
            $rs['msg'] = $userfile_name;
            $sz = filesize($dst);       
            $sql="insert into images (id,type,order_id,image) values "
                    . "(null,2,'$order_id','$userfile_name')";
            $sqlcn->ExecuteSQL($sql) or die('Не могу добавить файл! ' . mysqli_error($sqlcn->idsqlconnection));        
    }
}

jsonExit($rs);