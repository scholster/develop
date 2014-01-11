<?php

require_once 'Model/createDataBaseConnection.php';
require_once 'Model/LoginModel.php';
require_once 'Controller/LoginController.php';


$login = new LoginController();

if (!$login->loggedIn) {
    include_once 'login.php';
    exit();
} else {
    include_once 'dashboard.php';
    exit();
}
?>