<?php

require_once '../Model/createDataBaseConnection.php';
require_once '../Model/LoginModel.php';
require_once '../Controller/LoginController.php';


$login = new LoginController();

if (!$login->loggedIn) {
    include_once 'login.php';
    exit();
} else {
    require_once '../Model/UserDetailsModel.php';
    $object = new UserDetailsModel();
    $text = $object->getDashboardBarText();
    echo nl2br($text);
    exit();
}
?>