<?php
require_once '../Model/createDataBaseConnection.php';

require_once '../Model/LoginModel.php';
require_once '../Controller/LoginController.php';

require_once '../Model/UserDetailsModel.php';
require_once '../Controller/UserDetailsController.php';

require_once '../Model/AnalyticsModel.php';
require_once '../Controller/AnalyticsController.php';

require_once '../Util/DateTime.php';

$login = new LoginController();

if (!$login->loggedIn) {
    $_SESSION['naviageTo'] = $_SERVER[REQUEST_URI];
    include_once '../login.php';
    exit();
}

$userObject = new UserDetailsController($_SESSION['userId']);
$userInfo = $userObject->info;

$userId = $_SESSION['userId'];

$query = "SELECT `user_firstName`, `user_lastName`,user_username, `user_fbId`,`user_picId`, `commentId` , `doneById`, `type` , COUNT(`doneById`) as num, `seen`, time,
            qc.`quesId`, dq.`quizId`
            FROM (SELECT * FROM user_alert WHERE `userId` = '$userId' ORDER BY `time` DESC) alerts 
            LEFT JOIN user_questionComment qc ON qc.id = alerts.`commentId` LEFT JOIN content_dailyQuizQuestion dq ON qc.`quesId` = dq.`questionId`
            ,`user` u
            WHERE `doneById`=user_id 
            GROUP BY `commentId`, `type` ORDER BY time desc;";

$result = mysql_query($query);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>queskey</title>
        <link rel="stylesheet" href="/assets/css/style.css" media="screen" />
        <script src="http://code.jquery.com/jquery-latest.min.js"></script>
        <meta property="og:title" content="queskey"/>
        <meta property="og:image" content="http://sphotos-a.ak.fbcdn.net/hphotos-ak-prn1/72671_554366534608562_503161730_n.jpg"/>
        <meta property="og:site_name" content="queskey"/>
        <meta property="og:description" content="Begin your CAT preparation."/>
        <meta property="og:type" content="website"/>
        <meta property="og:url" content="http://queskey.com"/>
        <link rel="shortcut icon" href="/queskey.ico" />
        <script src="/assets/js/functions_1.0.js" type="text/javascript"></script>
        <script>

            $(document).ready(function() {

                var h = $(window).height();

                var height = h < 600 ? 600 : h;
                $('div#body_wrapper').css('height', 10);

            });

        </script>
    </head>

    <body>
        <div id="body_wrapper">
            <div id="headerAndNav">
                <?php include_once '../include/header.php'; ?>
            </div>
            <div class="inner_wrapper">
                <div class="page_header_back"><div class="page_header_back_text">Alerts</div></div>
                <ul id="inner_message_List">
                    <?php
                    if (mysql_num_rows($result)) {
                        while ($row = mysql_fetch_assoc($result)) {
                            if ($row['user_fbId'] > 0) {
                                $img = "https://graph.facebook.com/" . $row['user_fbId'] . "/picture?width=137&height=137";
                            } else {
                                $img = "/assets/userPic/default.png";
                            }

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
                                $topicInfo = $userObject->getTopicInfo($row['commentId']);
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
                                    <div class="inner_message_Left"> <img class="other_user_image" src="<?php echo $img; ?>"/>
                                        <div style="float: left;background-color: inherit;">
                                            <div class="inner_message_sender"><?php echo $name; ?></div>
                                            <div class="inner_message_text "> 
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
                                    </div>
                                    <div class="inner_message_Right">
                                        <div id="inner_message_Time" ><?php echo agoIndia($row['time'], time()); ?></div>
                                    </div>
                                </li>
                            </a>
                            <?php
                        }
                    } else {
                        echo '<div style="width: 100%;height: 47px;background-color: #f2f2f2;margin-top: 30px;padding-top: 24px;font-size: 18px;color: #666;text-align: center;">You have no Alert</div>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </body>
</html>