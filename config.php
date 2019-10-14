<?php
// Данный код создан и распространяется по лицензии GPL v3
// Изначальный автор данного кода - Грибов Павел
// http://грибовы.рф

// Режим отладки
$debug = true; // РЕКОМЕНДУЮ поставить false !!!

$codemysql = 'utf8'; // Кодировка базы
$mysql_base_id = ''; // Идентификатор соединения

$mysql_host = 'localhost'; // Хост БД
$mysql_user = 'donpadlo'; // Пользователь БД
$mysql_pass = 'padlopavel'; // Пароль пользователя БД
$mysql_base = 'pokraska'; // Имя базы

// Временная зона по умолчанию
date_default_timezone_set('Europe/Moscow');
$userewrite = 0;
// Если активен режим отладки, то показываем все ошибки и предупреждения
if ($debug) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}
?>
