<?php
session_start();
include_once '../Model/createDataBaseConnection.php';
include_once '../Util/functions.php';
if(isset($_SESSION['userId'])&&isset($_POST['toId'])&&isset($_POST['message'])){
    $message = trim($_POST['message']," \t\n\r\0\x0B" );
    if($message==''){
        echo 'INVALID';
        exit();
    }
    $fromId = $_SESSION['userId'];
    $toId = $_POST['toId'];
    
    $message = parseInputString($message);
    
    echo $fromId;
    echo $toId;
    echo $message;
    
    if($fromId==$toId){
        echo 'SAME';
        exit();
    }
    
    $query = "INSERT INTO message (`from`,`to`,`messagetext`) VALUES ($fromId,$toId,'$message'); ";
    if(mysql_query($query))
        echo 'SUCCESS';
    else echo mysql_error();
}
else{
    echo 'INVALID';
    exit();
}
?>