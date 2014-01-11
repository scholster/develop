<?php
include_once '../Model/createDataBaseConnection.php';
include_once '../Model/NewUserModel.php';
include_once '../Util/functions.php';

if (isset($_POST['email'])&&isset($_POST['password'])&&isset($_POST['username'])) {
    $newUser = new newUserModel();
    $newUser->setEmail(parseInputString($_POST['email']));
    $newUser->setPassword(parseInputString($_POST['password']));
    $newUser->setUsername(parseInputString($_POST['username']));
    $return = $newUser->newUser();
    if ($return) {
        $_SESSION['email'] = $_POST['email'];
        sendIntroMail($_SESSION['email'],$newUser->getUsername());
        echo '1';
        exit();
    }
} else {
    echo '2';
    exit();
}
?>