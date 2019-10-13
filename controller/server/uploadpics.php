<?php
$rs = array(
    'msg' => 'error'
); // Ответ по умолчанию, если пойдёт что-то не так
$dis = array(
    '.htaccess'
); // Запрещённые для загрузки файлы
$point_id= _POST("point_id");
$orig_file = $_FILES['filedata']['name'];
if (! in_array($orig_file, $dis)) {
    $userfile_name = GetRandomId(8) . '.' . pathinfo($orig_file, PATHINFO_EXTENSION);
    $src = $_FILES['filedata']['tmp_name'];
    $dst = WUO_ROOT . '/photos/' . $userfile_name;
    $res = move_uploaded_file($src, $dst);
    if ($res) {
        $rs['msg'] = $userfile_name;
        $sz = filesize($dst);       
            $sql="update points set photo='$userfile_name' where id=$point_id;";
            $sqlcn->ExecuteSQL($sql) or die('Не могу добавить файл! ' . mysqli_error($sqlcn->idsqlconnection));
        
    }
}

jsonExit($rs);