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

if (!$login->loggedIn) {
    $_SESSION['naviageTo'] = $_SERVER[REQUEST_URI];
    include_once '../login.php';
    exit();
}

$userObject = new UserDetailsController($_SESSION['userId']);
$userInfo = $userObject->info;

if (isset($_GET['subject'])) {
    $sub = $_GET['subject'];
    if (strcasecmp($sub, "Verbal") == 0) {
        $subject = 3;
        $userObject->verbalAnalytics->getDetailedAnalytics();
        $controller = $userObject->verbalAnalytics;
    } elseif (strcasecmp($sub, "Quant-DI") == 0) {
        $subject = 1;
        $userObject->quantAnalytics->getDetailedAnalytics();
        $controller = $userObject->quantAnalytics;
    } else {
        include_once '../notfound.html';
        exit();
    }
} else {
    $subject = 1;
    $userObject->quantAnalytics->getDetailedAnalytics();
    $controller = $userObject->quantAnalytics;
}

//$userInfo['demoFlag2'] = 0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php include_once '../include/headInclude.php'; ?>
        <title>Analytics | queskey</title>
        <script src="/assets/js/jquery.js" type="text/javascript"></script>
        <script>
        </script>
        <?php
        if ($userInfo['demoFlag2'] == 0) {
            ?>
            <script>
                $(window).bind("load", function() {
                    openDemo();
                });
            </script>
            <?php
        }
        ?>
    </head>

    <body>
        <div id="body_wrapper">
            <div id="headerAndNav">
                <?php include_once '../include/header.php'; ?>
            </div>
            <div class="inner_wrapper">
                <div class="top_wrapper">
                    <div class="page_header_back">
                        <div class="page_header_back_text" style="color:#959595">
                            Analytics Summary
                        </div>
                    </div>
                    <div>
                        Analytics Filter:
                        <select onchange="changeAnalyticsType(<?php echo $subject; ?>)" id="change_analytics_type">
                            <option value="0">All</option>
                            <option value="1">Correct</option>
                            <option value="2">Incorrect</option>
                            <option value="3">Last Week</option>
                            <option value="4">Last Month</option>
                        </select>

                    </div>
                    <div id="analytics_replace">
                        <table width="765"  height="100" style="text-align:center; margin-top:29px; float:left" >
                            <tr style="color:#4c4c4c; font-size:16px; ">
                                <td width="25%">Accuracy</td>
                                <td width="25%">Community Accuracy</td>
                                <td width="25%">Average Pace</td>
                                <td width="25%">Community Average pace</td>
                            </tr>
                            <tr style=" font-size:25px; font-family:Century_Gothic_Bold ">
                                <td><?php echo $controller->accuracy; ?> %</td>
                                <td><?php echo $controller->communityAccuracy; ?> %</td>
                                <td><?php echo secondsToString($controller->avgTime); ?></td>
                                <td><?php echo secondsToString($controller->communityAvgTime); ?></td>
                            </tr>
                            <tr style=" font-size:13px; font-family:Century_Gothic; color:#a1a1a1 ">
                                <td>(<?php echo $controller->correct; ?> out of <?php echo $controller->attempted; ?>)</td>
                                <td>&nbsp;</td>
                                <td>(Time per question)</td>
                                <td>(Time per question)</td>
                            </tr>
                        </table>
                        <div class="result_summary">TOPICS</div>
                        <table width="765" class="topics_analytics_table"    >
                            <?php if ($controller->detailedAnalytics != NULL) { ?>
                                <tr  height="57" style="font-size:14px; color:#838383;  font-family:Century_Gothic_Bold">
                                    <td width="151">Topic Name</td>
                                    <td>Accuracy</td>
                                    <td width="160">Community Accuracy</td>
                                    <td width="160">Your Average Pace<br><span style="font-size: 11px;">(Community Average Pace)</span></td>
                                </tr>

                                <?php
                                if ($controller->detailedAnalytics)
                                    foreach ($controller->detailedAnalytics as $detailedAnalytic) {
                                        ?>
                                        <tr height="88">
                                            <td width="151" class="analytics_topic"><?php echo $detailedAnalytic['topic']; ?></td>
                                            <td><div class="topic_graph">
                                                    <div class="topic_graph_line">
                                                        <div class="topic_graph_overlay" style="height:100%; width:<?php echo $detailedAnalytic['accuracy'] . '%'; ?>; 
                                                             background-color:<?php echo getAnalyticsColorCode($detailedAnalytic['accuracy'], $detailedAnalytic['communityAccuracy']); ?>; 
                                                             position:absolute"></div>
                                                    </div>
                                                    <div class="score_bg" style="margin-left:<?php echo ($detailedAnalytic['accuracy'] - 6.5) . '%'; ?>"><?php echo $detailedAnalytic['accuracy']; ?>%</div>
                                                </div>
                                                <div style=" font-size:13px; font-family:Century_Gothic; color:#a1a1a1 ">
                                                    (<?php echo $detailedAnalytic['correct']; ?> out of <?php echo $detailedAnalytic['total']; ?>)
                                                </div>
                                            </td>
                                            <td width="160" class="analytics_topic"><?php echo $detailedAnalytic['communityAccuracy']; ?> %</td>
                                            <td width="160" class="analytics_topic">
                                                <?php echo secondsToString($detailedAnalytic['avgTime']); ?><br>
                                                    <span style="font-size: 11px;">(<?php echo secondsToString($detailedAnalytic['commAvgTime']); ?>)</span>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                            } else {
                                ?>
                                <tr>
                                    <td width="100%">
                                        No Data Exist<br>
                                            <a href="/practice/">Take Quiz to generate Analytics</a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                    </div>
                </div>
                <?php include_once '../include/footer.php'; ?>
            </div>
        </div>
        <?php
        if ($userInfo['demoFlag2'] == 0) {
            ?>

            <div id="dashboard_demo">
                <div class="demo_bg"> </div>
                <div class="demo_bg_overlay">
                    <div id="body_wrapper_demo">
                        <div id="demo_start" style="top:205px; left:540px;">
                            <div class="demo_content">

                                <h3 id="demo_content_h3" style="font-size:22px;">Review your performance at runtime</h3>
                                <p id="demo_content_para">
                                    While you are practicing on queskey, your overall analytics are dynamically calculated. These involve your accuracy and average time, for each and every topic.<br/><br/> The same are compared with the analytics of the community, giving you an idea about your relative performance.<br/><br/> This section is visible only to you.
                                </p>
                            </div>
                            <div class="demo_kink" style="top: 48%;"></div>
                            <div class="demo_close" onclick="closeDemo()">X</div>
                            <div class="demo_btns">
                                <div id="demo_tog_btn" class="queskey_btn" onclick="closeDemo()">
                                    <div style="padding-top:7px; color: white;">Got it!</div>
                                </div>
                            </div>
                        </div>
                        <div id="demo_img" style="display: inline-block" class="navBtn_analytics_page_demo"/>
                    </div>
                </div>
            </div>
            <div style="opacity:0; position: absolute; left: 0px; top: 0px;" id="hideIt">
                <div class="demo_kink"></div>
                <div class="navBtn_analytics_page_demo"></div>
            </div>
            <?php
            $userObject->updateDemoFlag2();
        }
        ?>
    </body>
</html>