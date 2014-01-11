<?php
require_once '../Model/createDataBaseConnection.php';

require_once '../Model/LoginModel.php';
require_once '../Controller/LoginController.php';

$login = new LoginController();

if (!$login->loggedIn) {
    echo 'INVALID';
    exit();
}


if (isset($_POST['quesId'])) {
    $quesId = $_POST['quesId'];
} else {
    echo 'INVALID';
    exit();
}

$userId = $_SESSION['userId'];

$result = mysql_query("SELECT solution FROM content_question WHERE `questionId` = '$quesId'");
$row = mysql_fetch_array($result);


$query2 = "SELECT count(ul.id) as likes,qc.`userId`, qc.comment,qc.id, u.`user_firstName`,u.`user_lastName`,u.user_username,u.`user_fbId`,u.`user_picId`,qc.id as commentId
            FROM user_questionComment qc LEFT JOIN user_questionCommentLike ul ON qc.id = ul.`commentId` ,`user` u WHERE `quesId` = '$quesId' AND u.user_id = qc.`userId`
            GROUP BY qc.id ORDER BY likes desc";

$result2 = mysql_query($query2);
?>

<div id="queskey_post">
    <div class="dashPostBox">
        <textarea name="question" maxlength="140" id="questionComment" class="queskeyPostText" placeholder="Improve Solution/Ask Doubt" onfocus="//extraPostBox();" onclick=""></textarea>
        <input class="queskeyPostButton" type="button" value="Post" onclick="postQuestionReply(<?php echo $quesId; ?>)">
    </div>
</div>

<table class="result_sol_table" width="100%" id="result_table">
    <tr class="queskey_anser">
        <td class="postSolnLeft" width="68px"><img class="queskey_image" src="http://behance.vo.llnwd.net/profiles23/2202141/projects/8097109/c8a850b9ac651bc025ac2b3aa1083cc7.jpg"/></td>
        <td class="postSolnText" ><p align="justify"><span class="resultActivityText">Queskey Solution</span>
                <br/> <?php echo nl2br($row[0]); ?> </p>
        </td>
    </tr>

    <script>
        function likeQuestionComment(type, commentId, commentNo) {
            $("#commentLike" + commentNo).attr('disabled', 'disabled');
            var likes = $("#likesNo" + commentNo).html();
            var likes_num = parseInt(likes);
            $.post("/ajax/likeUnlikeUserQuestionComment.php", {
                type: type,
                commentId: commentId
            }, function(data) {
                if (data.data == 'valid') {
                    if (type == 0) {
                        $("#commentLike" + commentNo).val("Unlike");
                        $("#commentLike" + commentNo).attr("onclick", "likeQuestionComment(" + 1 + "," + commentId + "," + commentNo + ")");
                        $("#likesNo" + commentNo).html(likes_num + 1);
                    } else {
                        $("#commentLike" + commentNo).val("Like");
                        $("#commentLike" + commentNo).attr("onclick", "likeQuestionComment(" + 0 + "," + commentId + "," + commentNo + ")");
                        $("#likesNo" + commentNo).html(likes_num - 1);
                    }
                }
                $("#commentLike" + commentNo).removeAttr('disabled');
            });
        }

    </script>

    <?php
    $commentNo = 1;
    while ($row = mysql_fetch_assoc($result2)) {

        if ($row['user_fbId'] > 0) {
            $image = "https://graph.facebook.com/" . $row['user_fbId'] . "/picture?width=137&height=137";
        } elseif ($row['user_picId'] != '0') {
            $image = "/assets/userPic/user_" . $row['userId'] . "_c." . $row['user_picId'];
        } else {
            $image = "/assets/userPic/default.png";
        }

        $commentId = $row['commentId'];

        $result = mysql_query("SELECT count(*) FROM user_questionCommentLike WHERE `commentId` = '$commentId' AND `userId` = '$userId'");
        $likesCount = mysql_fetch_array($result);
        echo mysql_error();
        if ($likesCount[0] == 0) {
            $type = 0;
        } else {
            $type = 1;
        }
        ?>
        <tr class="<?php if ($commentNo == 1)
        echo "best_anser";
    else
        echo "other_usr_anser";
    ?>">
            <td class="postSolnLeft" width="68px"><a href="/user/<?php echo $row['userId']; ?>"><img class="other_user_image" src="<?php echo $image; ?>"></a></td>
            <td class="postSolnText" ><p><span class="resultActivityText"><?php echo (($row['user_firstName'] != NULL || $row['user_lastName'] != NULL ) ? $row['user_firstName'] . " " . $row['user_lastName'] : $row['user_username']); ?></span>
                    <br/> <?php echo nl2br($row['comment']); ?> </p>
            </td>
            <td width="85px">
                <input type="button" class="like_soln_btn" id="commentLike<?php echo $row['commentId']; ?>" onclick="likeQuestionComment(<?php echo $type . ',' . $row['commentId'] . ',' . $row['commentId']; ?>);"
                       value="<?php
                   if ($type == 1) {
                       echo "Unlike";
                   } else {
                       echo "Like";
                   }
                   ?>"
                       />

                <div class="soln_like">+<span id="likesNo<?php echo $row['commentId']; ?>"><?php echo $row['likes']; ?></span></div>
            </td>
        </tr>
        <?php
        $commentNo++;
    }
    ?>
</table>