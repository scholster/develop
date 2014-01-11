<?php
require_once '../Model/createDataBaseConnection.php';
require_once '../Model/LoginModel.php';
require_once '../Controller/LoginController.php';
require_once '../Util/DateTime.php';

require_once '../Model/UserDetailsModel.php';

$login = new LoginController();

if (!$login->loggedIn) {
    echo 'INVALID';
    exit();
}

$userModel = new UserDetailsModel();

$userId = $_SESSION['userId'];

$query = "SELECT `user_firstName`, `user_lastName`,user_username, `user_fbId`,`user_picId`, `commentId` , `doneById`, `type` , COUNT(`doneById`) as num, `seen`, time,
            qc.`quesId`, dq.`quizId`
            FROM (SELECT * FROM user_alert WHERE `userId` = '$userId' ORDER BY `time` DESC) alerts 
            LEFT JOIN user_questionComment qc ON qc.id = alerts.`commentId` LEFT JOIN content_dailyQuizQuestion dq ON qc.`quesId` = dq.`questionId`
            ,`user` u
            WHERE `doneById`=user_id 
            GROUP BY `commentId`, `type` ORDER BY seen,time desc LIMIT 0,20;";

$result = mysql_query($query);

mysql_query("UPDATE user_alert SET seen='1' WHERE `userId` = '$userId'");
?>
<script>
    $(document).ready(function(){
        $('#alert_scroll').jScrollPane();
    });
</script>
<div id="message_pop_kink" style="left: 16px;"></div>
<div id="alert_scroll" style="overflow-y: auto; height: 270px; margin-bottom: 25px;">
    <ul id="message_pop_List">
        <?php
        $i = 1;
        if (mysql_num_rows($result) > 0) {
            while ($row = mysql_fetch_assoc($result)) {

                if ($row['user_fbId'] > 0) {
                    $img = "https://graph.facebook.com/" . $row['user_fbId'] . "/picture?width=137&height=137";
                } elseif ($row['user_picId'] != '0') {
                    $img = "/assets/userPic/user_" . $row['doneById'] . "_c." . $row['user_picId'];
                } else {
                    $img = "/assets/userPic/default.png";
                }

                if ($row['user_firstName'] != '' || $row['user_lastName'] != '') {
                    $name = $row['user_firstName'] . ' ' . $row['user_lastName'];
                } else {
                    $name = $row['user_username'];
                }

                if ($row['type'] == 3) {
                    $link = "/user/" . $row['doneById'];
                } elseif ($row['type'] == 5) {
                    $topicInfo = $userModel->getTopicName($row['commentId']);
                    $link = "/content/" . ($topicInfo[1] == 1 ? "Quant-DI" : "Verbal") . "/" . str_replace(' ', '-', $topicInfo[0]);
                    $img = "/assets/img/mr_queskey.png";
                    $alert = "&apos;" . $topicInfo[0] . "&apos; Theory and Practice Drills with solutions are now live";
                    $name = '<span style="color:#f08223;">Queskey<span>';
                } else {
                    $link = "/practice/3/" . $row['quizId'] . "/" . $row['quesId'];
                }
                ?>
                <a href="<?php echo $link; ?>">
                    <li <?php
        if ($row['seen'] == '0') {
            echo "style='background-color:#FFF0CD;'";
        }
                ?>>
                        <div class="message_pop_Left">
                            <img class="message_pop_image" src="<?php echo $img; ?>">

                            <div class="message_pop_sender"><?php echo $name; ?></div>
                            <div class="message_pop_text ">
                                <?php
                                if ($row['type'] == 1 && $row['num'] == 1) {
                                    $alert = "likes your post";
                                } elseif ($row['type'] == 1 && $row['num'] == 2) {
                                    $alert = "+1 other likes your post";
                                } elseif ($row['type'] == 1 && $row['num'] > 2) {
                                    $alert = "+" . ($row['num'] - 1) . "others liked on comment you post";
                                } elseif ($row['type'] == 2 && $row['num'] == 1) {
                                    $alert = "posted on question you post";
                                } elseif ($row['type'] == 2 && $row['num'] == 2) {
                                    $alert = "+1 other posted on question you post";
                                } elseif ($row['type'] == 2 && $row['num'] > 2) {
                                    $alert = "+" . ($row['num'] - 1) . "others posted on question you post";
                                } elseif ($row['type'] == 3) {
                                    $alert = "added you to keychain";
                                }
                                ?>
                                <p><?php echo $alert; ?></p>
                            </div>
                        </div>
                        <div id="message_pop_Time" ><?php echo agoIndia($row['time'], time()); ?></div>
                    </li>
                </a>
                <?php
                $i++;
                if ($row['seen'] == 1 && $i > 5) {
                    break;
                }
            }
        } else {
            echo '<div style="width: 100%;text-align: center;margin-top: 20px;color: #666;">No Alerts</div>';
        }
        ?>

    </ul>
</div>
<div style="position: absolute; top: 270px; left: 5px; z-index: 2;">
    <a href="/alerts/"><div class="message_pop_view_all" style="height:20px; background-color:#FFF">view all alerts</div></a>
</div>