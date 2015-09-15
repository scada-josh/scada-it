<?php

function OpenDbConnection() {
//    $dbhost = 'localhost';
//    $dbuser = 'root';
//    $dbpass = '';
//    $dbname = 'code-aholic';
    
    $dbhost = 'localhost';
    $dbuser = 'codeaholic_user';
    $dbpass = 'aaa';
    $dbname = 'codeaholic_web';

    
    $conn = mysql_connect($dbhost, $dbuser, $dbpass) or die('Error connecting to mysql');
    
    mysql_select_db($dbname) or die("Cannot connect Database.");
    mysql_query('SET NAMES UTF8');
    
    return $conn;
}

function CloseDbConnection($conn){
    mysql_close($conn);
}
?>
