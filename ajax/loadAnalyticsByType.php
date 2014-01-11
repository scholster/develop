<?php
require_once '../Model/createDataBaseConnection.php';
require_once '../Model/LoginModel.php';
require_once '../Controller/LoginController.php';

require_once '../Controller/AnalyticsController.php';
require_once '../Model/AnalyticsModel.php';

require_once '../Util/functions.php';

$login = new LoginController();

if (!$login->loggedIn && isset($_POST['subject']) && isset($_POST['type'])) {
    echo 'INVALID';
    exit();
}

$subject = $_POST['subject'];
$userId = $_SESSION['userId'];
$type = $_POST['type'];

$controller = new AnalyticsController($subject, $userId);

if ($type == 0) {
    $controller->getBasicAnalytics();
    $controller->getDetailedAnalytics();
} elseif ($type == 1) {
    $controller->getBasicAnalyticsByCorrect();
    $controller->getDetailedAnalyticsByCorrect();
} elseif ($type == 2) {
    $controller->getBasicAnalyticsByInCorrect();
    $controller->getDetailedAnalyticsByInCorrect();
} elseif ($type == 3) {
    $controller->getBasicAnalyticsByTime();
} elseif ($type == 4) {
    
} else {
    $controller->getBasicAnalytics();
    $controller->getDetailedAnalytics();
}
?>
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

