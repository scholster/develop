<?php

header('Content-Type: application/json');
require_once '../Model/createDataBaseConnection.php';
require_once '../Model/LoginModel.php';
require_once '../Controller/LoginController.php';

$login = new LoginController();

if (!$login->loggedIn) {
    $data = array(
        'data' => 'inValid'
    );
    echo json_encode($data);
    exit();
}


if (isset($_POST['paraId'])) {
    $paraId = $_POST['paraId'];
    $userId = $_SESSION['userId'];
    $type = $_POST['type'];
    mysql_query("SET AUTOCOMMIT=0");
    mysql_query("START TRANSACTION");
    if ($type == 1) {
        $query = "INSERT INTO user_contenthighlight (userid,`paraId`) VALUES ('$userId','$paraId')";
    } else {
        $query = "DELETE FROM user_contenthighlight WHERE userid = '$userId' AND `paraId`='$paraId'";
    }

    $result = mysql_query($query);
    $affectedRows = mysql_affected_rows();
    if ($result && $affectedRows == 1) {
        $data = array(
            'data' => 'valid'
        );
        echo json_encode($data);
        mysql_query("COMMIT");
    } else {
        echo mysql_error();
        mysql_query("ROLLBACK");
    }
} else {
    $data = array(
        'data' => 'inValid'
    );
    echo json_encode($data);
    exit();
}
?>