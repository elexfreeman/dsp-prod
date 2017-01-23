<?php
/**
 * Created by PhpStorm.
 * User: elex
 * Date: 25.12.2016
 * Time: 13:44
 */

$mssqlhost = '10.2.22.5';    # Хост
$mssqlbase = 'DISP_WEB'; # БД
$mssqllogn = 'sa';    # Логин
$mssqlpass = '1qazxsw23edcvfr4!';    # Пароль

try {
    # Подключение к MSSQL
    $DBH = new PDO("odbc:driver={ODBC Driver 11 for SQL Server}; DSN=mssql1;SERVER=10.2.22.5; host=$mssqlhost;dbname=$mssqlbase", "$mssqllogn", "$mssqlpass");
} catch(PDOException $e) {
    echo $e->getMessage();
    exit;
}

$DBH->query("Select * from users ");
