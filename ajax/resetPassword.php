<?php

header('Content-Type: application/json');
include_once '../Model/createDataBaseConnection.php';
$data = NULL;
if (isset($_SESSION['passwordChange']) && isset($_POST['password'])) {
    $userId = $_SESSION['passwordChange'];
    $password = sha1($_POST['password']);
    mysql_query("SET AUTOCOMMIT=0");
    mysql_query("START TRANSACTION");

    $query = "DELETE FROM user_forgotPasswords where `userId` = '$userId'";
    $result = mysql_query($query);
    $affectedRows = mysql_affected_rows();
    if ($result && $affectedRows == 1) {
        $query = "UPDATE `user` SET user_password = '$password' , passwordtime = CURRENT_TIMESTAMP WHERE user_id = '$userId'";
        $result2 = mysql_query($query);
        if ($result2 && (mysql_affected_rows() == 1 || mysql_affected_rows() == 0)) {
            mysql_query("COMMIT");
            $data = array(
                'data' => '1'
            );
        } else {
            mysql_query("ROLLBACK");
            $data = array(
                'data' => '2'
            );
        }
    } else {
        mysql_query("ROLLBACK");
        $data = array(
            'data' => '3'
        );
    }
} else {
    echo 'INVALID';
    exit();
}
echo json_encode($data);
exit();
?>