<?php

header('Content-Type: application/json');
require_once '../Model/createDataBaseConnection.php';

require_once '../Model/LoginModel.php';
require_once '../Controller/LoginController.php';

$login = new LoginController();

if (!$login->loggedIn) {
    echo 'INVALID';
    exit();
}

$userId = $_SESSION['userId'];

if (!isset($_POST['type']) || !isset($_POST['commentId']) && is_numeric($_POST['commentId'])) {
    echo 'INVALID';
    exit();
}

$commentId = $_POST['commentId'];

mysql_query("SET AUTOCOMMIT=0");
mysql_query("START TRANSACTION");

if ($_POST['type'] == 0) {
    $query = "INSERT INTO user_questionCommentLike (`userId`,`commentId`) VALUES ('$userId','$commentId')";
} else {
    $query = "DELETE FROM user_questionCommentLike WHERE `userId` = '$userId' AND `commentId`='$commentId'";
}

$result = mysql_query($query);

$affectedRows = mysql_affected_rows();

$data2 = "Heloo";
if($affectedRows == 1){
    $result1 =    mysql_query("SELECT `userId` FROM user_questionComment WHERE id = '$commentId'");
    $commentByUserId = mysql_fetch_array($result1);
    if($commentByUserId[0] != $userId && $_POST['type'] == 0){
        $result2 = mysql_query("INSERT INTO user_alert (`type`,`userId`,`doneById`,`commentId`) VALUES ('1','$commentByUserId[0]','$userId','$commentId')");
        $data2 = mysql_error()."1";
    }elseif($commentByUserId[0] != $userId){
        $result2 = mysql_query("DELETE FROM user_alert 
                                WHERE `type` = '1' AND `userId` = '$commentByUserId[0]' AND `doneById` = '$userId' AND `commentId`='$commentId'");
        $data2 = mysql_error()."2";
    }else{
        $result2 = TRUE;
    }
}

if ($result && $result2 && $affectedRows == 1) {
    mysql_query("COMMIT");
    $data = array(
        'data' => 'valid',
        'error' => $data2
    );
} else {
    mysql_query("ROLLBACK");
    $data = array(
        'data' => 'invalid',
        'error' => $data2
    );
}
echo json_encode($data);
?>