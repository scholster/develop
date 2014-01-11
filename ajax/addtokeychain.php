<?php

header('Content-Type: application/json');
include_once '../Model/createDataBaseConnection.php';
$data = NULL;
if (isset($_SESSION['userId'])) {
    if (isset($_POST['heroId'])) {
        $userId = $_SESSION['userId'];
        $heroId = $_POST['heroId'];
        if (is_numeric($heroId) && $heroId != $userId) {
            $type = $_POST['type'];
            mysql_query("SET AUTOCOMMIT=0");
            mysql_query("START TRANSACTION");
            if ($type == 1) {
                $query = "INSERT INTO follower (`userId`,`heroId`) VALUES ('$userId','$heroId');";
                $result = mysql_query($query);
                $affectedRows = mysql_affected_rows();
                
                $insertId = mysql_insert_id();
                
                if ($result && $affectedRows == 1) {
                    mysql_query($query);

                    mysql_query("INSERT INTO user_alert (`type`,`userId`,`doneById`,`commentId`) VALUES ('3','$heroId','$userId','$insertId')");
                    
                    mysql_query("COMMIT");

                    $query = "SELECT `userId`,`heroId` FROM follower 
                    where (`userId`='$userId' AND `heroId`='$heroId') ||  (`userId`='$heroId' AND `heroId`='$userId')";
                    $result = mysql_query($query);
                    $num = mysql_num_rows($result);
                    $relation = "";
                    switch ($num) {
                        case 0 : $relation = "";
                            break;

                        case 1 : $row = mysql_fetch_assoc($result);
                            if ($row['heroId'] == $heroId) {
                                $relation = "Following";
                            } else {
                                $relation = "Follower";
                            }
                            break;

                        case 2 : $relation = "Friends";
                            break;
                    }

                    $data = array(
                        'message' => "success",
                        'relation' => $relation
                    );
                } else {
                    mysql_query("ROLLBACK");
                    $data = array(
                        'message' => "fail"
                    );
                }
            } else {
                $query = "DELETE FROM follower WHERE `userId`='$userId' AND `heroId`='$heroId'";
                $result = mysql_query($query);
                $affectedRows = mysql_affected_rows();
                if ($result && $affectedRows == 1) {
                    mysql_query("DELETE FROM user_alert 
                                WHERE `type` = '3' AND `userId` = '$heroId' AND `doneById` = '$userId'");
                    
                    
                    mysql_query("COMMIT");

                    $query = "SELECT `userId`,`heroId` FROM follower 
                    where (`userId`='$userId' AND `heroId`='$heroId') ||  (`userId`='$heroId' AND `heroId`='$userId')";                    
                    
                    $result = mysql_query($query);
                    $num = mysql_num_rows($result);
                    $relation = "";
                    switch ($num) {
                        case 0 : $relation = "";
                            break;

                        case 1 : $row = mysql_fetch_assoc($result);
                            if ($row['heroId'] == $heroId) {
                                $relation = "Following";
                            } else {
                                $relation = "Follower";
                            }
                            break;

                        case 2 : $relation = "Friends";
                            break;
                    }

                    $data = array(
                        'message' => "success",
                        'relation' => $relation
                    );
                } else {
                    mysql_query("ROLLBACK");
                    $data = array(
                        'message' => "fail"
                    );
                }
            }
        } else {
            $data = array(
                'message' => "invalid"
            );
        }
    }
} else {
    $data = array(
        'message' => "invalid"
    );
}
echo json_encode($data);
exit();
?>