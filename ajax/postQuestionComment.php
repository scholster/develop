<?php
require_once '../Model/createDataBaseConnection.php';

require_once '../Model/LoginModel.php';
require_once '../Controller/LoginController.php';

require_once '../Model/UserDetailsModel.php';
require_once '../Controller/UserDetailsController.php';

require_once '../Model/AnalyticsModel.php';
require_once '../Controller/AnalyticsController.php';

require_once '../Util/functions.php';

$login = new LoginController();

$userObject = new UserDetailsController($_SESSION['userId']);
$userInfo = $userObject->info;

if (!$login->loggedIn) {
    echo 'INVALID';
    exit();
}

$userId = $_SESSION['userId'];

if (isset($_POST['quesId']) && isset($_POST['comment']) && is_numeric($_POST['quesId'])) {
    $message = trim($_POST['comment'], " \t\n\r\0\x0B");
    if ($message == '') {
        echo '';
        exit();
    }

    $quesId = $_POST['quesId'];

    $message = parseInputString($message);

    mysql_query("SET AUTOCOMMIT=0");
    mysql_query("START TRANSACTION");

    $sql = "INSERT INTO user_questionComment (`userId`,`quesId`,comment) VALUES ('$userId','$quesId','$message')";
    mysql_query($sql);

    $commentId = mysql_insert_id();

    $type = 0;

    $result = mysql_query("SELECT DISTINCT `userId` FROM user_questionComment WHERE `quesId` = '$quesId' AND `userId` != '$userId'");
    while ($row = mysql_fetch_array($result)) {
        mysql_query("INSERT INTO user_alert (`type`,`userId`,`doneById`,`commentId`) VALUES ('2','$row[0]','$userId','$commentId')");
    }

    if ($commentId != FALSE && $commentId > 0) {
        mysql_query("COMMIT");
        ?>
        <tr class="other_usr_anser">
            <td class="postSolnLeft" width="68px"><a href="/user/<?php echo $userId; ?>"><img class="other_user_image" src="<?php echo $userInfo['userImage']; ?>"></a></td>
            <td class="postSolnText" ><p><span class="resultActivityText">
                        <?php
                        if ($userInfo['firstName'] != '' || $userInfo['lastName'] != '') {
                            echo $userInfo['firstName'] . ' ' . $userInfo['lastName'];
                        } else {
                            echo $userInfo['username'];
                        }
                        ?>
                    </span>
                    <br/> <?php echo nl2br($message); ?> </p>
            </td>
            <td width="85px">
                <input type="button" class="like_soln_btn" id="commentLike<?php echo $commentId; ?>" onclick="likeQuestionComment(<?php echo $type . ',' . $commentId . ',' . $commentId; ?>);"
                       value="<?php
                       if ($type == 1) {
                           echo "Unlike";
                       } else {
                           echo "Like";
                       }
                       ?>"
                       />

                <div class="soln_like">+<span id="likesNo<?php echo $commentId; ?>">0</span></div>
            </td>
        </tr>
        <?php
    } else {
        mysql_query("ROLLBACK");
        exit();
    }
}
?>