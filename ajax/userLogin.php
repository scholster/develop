<?php

session_start();
require_once '../Model/createDataBaseConnection.php';
require_once '../Model/LoginModel.php';
require_once '../Util/functions.php';
require_once '../Controller/LoginController.php';
$login = new LoginController();
if (isset($_POST['loginUserName']) && isset($_POST['loginPassword'])) {
    $login->Login(parseInputString($_POST['loginUserName']),  parseInputString($_POST['loginPassword']));
} else {
    echo 'INVALID';
    exit();
}
if ($login->loggedIn) {
    echo '1';
    exit();
}
else {
    echo '0';
    exit();
}
?>