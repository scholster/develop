<?php

header('Content-Type: application/json');
require_once '../Model/createDataBaseConnection.php';
require_once '../Model/LoginModel.php';
require_once '../Controller/LoginController.php';
require_once '../Util/functions.php';

$login = new LoginController();

if (!$login->loggedIn) {
    $data = array(
        'data' => 'inValid'
    );
    echo json_encode($data);
    exit();
}

if (isset($_POST['activity'])) {

    mysql_query("SET AUTOCOMMIT=0");
    mysql_query("START TRANSACTION");

    $userId = $_SESSION['userId'];
    $activity = parseInputString($_POST['activity']);

    $query = "INSERT INTO user_posts (post,`userId`) VALUES ('$activity','$userId')";
    mysql_query($query);
    $id = mysql_insert_id();
    if ($id != FALSE && $id > 0) {
        $query2 = "INSERT INTO user_activity (`userId`,`type`,`relationId`) VALUES ('$userId','1','$id')";
        $result = mysql_query($query2);
        if ($result) {
            mysql_query("COMMIT");
            $data = array(
                'data' => 'valid'
            );
        } else {
            mysql_query("ROLLBACK");
            $data = array(
                'data' => 'inValid'
            );
        }
    } else {
        mysql_query("ROLLBACK");
        $data = array(
            'data' => 'inValid'
        );
    }
} else {
    $data = array(
        'data' => 'inValid'
    );
}
echo json_encode($data);
?>