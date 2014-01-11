<?php

require_once '../Model/createDataBaseConnection.php';

require_once '../Model/LoginModel.php';
require_once '../Controller/LoginController.php';

include_once '../Util/functions.php';

$login = new LoginController();

if (!$login->loggedIn) {
    $_SESSION['naviageTo'] = $_SERVER[REQUEST_URI];
    include_once '../login.php';
    exit();
}

$userId = $_SESSION['userId'];

if (isset($_POST['updateUserData'])) {
    $firstName = parseInputString($_POST['firstName']);
    $lastName = parseInputString($_POST['lastName']);
    $education = parseInputString($_POST['education']);
    $location = parseInputString($_POST['location']);
    $work = parseInputString($_POST['work']);

    if ($firstName != NULL && $firstName != "" && is_numeric($userId)) {
        $query = "UPDATE `user` SET `user_firstName`='$firstName',
                        `user_lastName` = '$lastName', user_college = '$education',
                        user_location = '$location', user_work = '$work' WHERE
                        user_id = '$userId'";
        $result = mysql_query($query);
        if ($result) {
            header("Location:/settings/");
            exit();
        }
    }
} elseif (isset($_POST['updateUserPassword'])) {
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmNewPassword = $_POST['confirmNewPassword'];

    $sql = "SELECT user_password FROM `user` WHERE user_id = '$userId'";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    if ($row[0] == sha1($oldPassword) && $newPassword == $confirmNewPassword && $newPassword != $oldPassword) {
        $password = sha1($newPassword);
        $query = "UPDATE `user` SET user_password = '$password', passwordtime = CURRENT_DATE
                    WHERE user_id = '$userId'";
        if (mysql_query($query)) {
            $_SESSION['passwordChangeMessage'] = "Password Changed Successfully";
            header("Location:/settings/");
            exit();
        } else {
            $_SESSION['passwordChangeMessage'] = "Some error occured. Please retry.";
            header("Location:/settings/");
            exit();
        }
    } else {
        if ($row[0] != sha1($oldPassword))
            $_SESSION['passwordChangeMessage'] = "Wrong old Password entered.";
        elseif ($newPassword == $oldPassword)
            $_SESSION['passwordChangeMessage'] = "Same old and new password.";
        else
            $_SESSION['passwordChangeMessage'] = "Some error occured. Please retry.";

        header("Location:/settings/");
        exit();
    }
} else {
    header("Location:/settings/");
    exit();
}
?>