<?php

require_once '../Model/createDataBaseConnection.php';
require_once '../Util/functions.php';

if (isset($_POST['email']) && isset($_POST['type'])) {
    $email = parseInputString($_POST['email']);
    $type = $_POST['type'];
}

if ($type == "1") {
    $sql = "SELECT * FROM user WHERE user_emailId ='$email'";
} elseif($type == "0") {
    $sql = "SELECT * FROM `user` WHERE user_username = '$email' ";
} else{
    $username = $_POST['username'];
    $sql = "SELECT * FROM `user` WHERE user_username = '$username' OR `user_emailId` = '$email'";
}
$login = mysql_query($sql) or die(mysql_error());
$n = mysql_num_rows($login);
if ($n != 0) {
    echo '1';
    exit();
} else {
    echo '0';
    exit();
}
?>