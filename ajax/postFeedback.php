<?php
header('Content-Type: application/json');
require_once '../Model/createDataBaseConnection.php';
require_once '../Util/functions.php';


$data = NULL;
if (isset($_POST['feedback']) && strlen($_POST['feedback']) < 200 && strlen($_POST['feedback']) > 0) {

    $feedBack = trim($_POST['feedback'], " \t\n\r\0\x0B");

    $message = parseInputString($feedBack);

    mysql_query("SET AUTOCOMMIT=0");
    mysql_query("START TRANSACTION");

    $sql = "INSERT INTO feedback (feedback) VALUES ('$message')";
    $result = mysql_query($sql);
    $affectedRows = mysql_affected_rows();
    if ($result && $affectedRows == 1) {
        mysql_query("COMMIT");
        $data = array(
            'data' => 'Valid'
        );
    } else {
        mysql_query("ROLLBACK");
        $data = array(
            'data' => 'inValid'
        );
    }
}else{
    $data = array(
        'data' => 'inValid'
    );
}
echo json_encode($data);
?>