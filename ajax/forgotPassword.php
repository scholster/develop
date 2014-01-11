<?php

header('Content-Type: application/json');
include_once '../Model/createDataBaseConnection.php';
include_once '../Util/functions.php';

$data = NULL;

if (isset($_POST['email'])) {
    $email = parseInputString($_POST['email']);
    $random1 = rand("100000", "999999");
    $sql = "SELECT user_id as id, `user_firstName` as name FROM `user` WHERE `user_emailId` = '$email'";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    if ($row) {
        $id = $row[0];
        mysql_query("SET AUTOCOMMIT=0");
        mysql_query("START TRANSACTION");

        $resultquery = mysql_query("SELECT COUNT(*) as count FROM user_forgotPasswords WHERE `userId` = '$id'");
        $num = mysql_fetch_array($resultquery);
        if ($num[0] == 0) {
            $query = "INSERT INTO user_forgotPasswords (`userId`,random1) VALUES ('$id','$random1')";
        } else {
            $query = "UPDATE user_forgotPasswords SET random1 = '$random1' WHERE `userId` = '$id'";
        }
        $result = mysql_query($query);
        $affectedRows = mysql_affected_rows();
        if ($affectedRows && $affectedRows == 1) {
            $message = '
        <p style="text-align:justify">
        Hi ' . $row[1] . '<br><br>
        You recently asked to reset your Queskey password.<br>
        <a href="http://queskey.com/resetPassword?u=' . $id . '&n=' . $random1 . '" target="_blank">Click here to change your password</a><br>
        Alternatively, you can enter the following password reset code:<br>
        ' . $random1 . '<br>
        Cheers<br>
        Team queskey.</p>';

            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
            $headers .= 'From: Team-Queskey <team@queskey.com>' . "\r\nSender: Team-Queskey <team@queskey.com>\r\n";

            $mail = mail($email, 'Queskey|Reset Password', $message, $headers,'-fdump@queskey.com');
            if ($mail) {
                $data = array(
                    'data' => '1',
                    'id' => $id
                );
                mysql_query("COMMIT");
            } else {
                $data = array(
                    'data' => '2'
                );
                mysql_query("ROLLBACK");
            }
        } else {
            $data = array(
                    'data' => '3'
                );
            mysql_query("ROLLBACK");
        }
    } else {
        $data = array(
            'data' => '4'
        );
    }
} else {
    $data = array(
        'data' => 'INVALID'
    );
}
echo json_encode($data);
?>