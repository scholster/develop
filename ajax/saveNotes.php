<?php

header('Content-Type: application/json');
require_once '../Model/createDataBaseConnection.php';
require_once '../Model/LoginModel.php';
require_once '../Controller/LoginController.php';
require_once '../Util/functions.php';

$data = NULL;
$login = new LoginController();

if (!$login->loggedIn) {
    $data = array(
        'data' => 'inValid'
    );
    echo json_encode($data);
    exit();
}

if (isset($_POST['subTopicId']) && isset($_POST['notes'])) {
    $notes = parseInputString($_POST['notes']);
    $userId = $_SESSION['userId'];
    $subTopicId = $_POST['subTopicId'];
    mysql_query("SET AUTOCOMMIT=0");
    mysql_query("START TRANSACTION");

    $sql = "SELECT COUNT(*) FROM user_contentnotes WHERE subtopicid ='$subTopicId' AND userid = '$userId'";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    if ($row[0] > 0) {
        $query = "UPDATE user_contentnotes SET notes = '$notes' WHERE subtopicid ='$subTopicId' AND userid = '$userId'";
    } else {
        $query = "INSERT INTO user_contentnotes (notes,userid,subtopicid) VALUES ('$notes','$userId','$subTopicId')";
    }
    $result2 = mysql_query($query);
    $affectedRows = mysql_affected_rows();
    if ($result2 && $affectedRows <= 1) {
        $data = array(
            'data' => 'valid'
        );
        mysql_query("COMMIT");
    } else {
        $data = array(
            'data' => 'inValid'
        );
        mysql_query("ROLLBACK");
    }
} else {
    $data = array(
        'data' => 'inValid'
    );
}
echo json_encode($data);
?>