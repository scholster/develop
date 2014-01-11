<?php
session_start();
error_reporting(E_ALL);
$server="localhost";
$usrname="root";
$pswrd="";
$con=mysql_connect($server,$usrname,$pswrd) or die();
$database="queskey_develop";
mysql_select_db($database,$con);
?>