<?php
require_once 'Model/createDataBaseConnection.php';
require_once 'Model/UserDetailsModel.php';
require_once 'Controller/UserDetailsController.php';

require_once 'Controller/AnalyticsController.php';
require_once 'Model/AnalyticsModel.php';

require_once 'Util/functions.php';

if (isset($_SESSION['naviageTo'])) {
    $href = $_SESSION['naviageTo'];
    unset($_SESSION['naviageTo']);
    header("Location:" . $href);
    exit();
}

$userObject = new UserDetailsController($_SESSION['userId']);
$userInfo = $userObject->info;

$activity = $userObject->getActivity(-1, NULL);

$quantAnalytics = $userObject->quantAnalytics;
$verbalAnalytics = $userObject->verbalAnalytics;

$circleQuant = getCircleData($quantAnalytics->correct, $quantAnalytics->attempted, 50);
$circleVerbal = getCircleData($verbalAnalytics->correct, $verbalAnalytics->attempted, 50);

$journeyStats = $userObject->journeyStats;

$whatNewText = $userObject->getDashboardBarText();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php include_once 'include/headInclude.php'; ?>
        <title>queskey</title>
        <?php
        if ($userInfo['demoFlag'] == 0) {
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
                <?php include_once 'include/header.php'; ?>
            </div>
            <div id="dashboard_wrapper">
                <div id="queskey_trivia">
                    <div class="trivia_ribbon"></div>
                    <div class="trivia_btn" onclick="refreshBar();"></div>
                    <div class="trivia_fact">
                        <p align="center" id="dashboard_bar"><?php echo nl2br($whatNewText); ?></p>
                    </div>
                </div>

                <div id="quant_wrapper">
                    <div class="dashboard_subject" style="color:#3892a0">Quant & Data Interpretation</div>
                    <div class="dashboard_sub_journey">
                        <a href="/content/Quant-DI">
                            <div class="dashboard_sub_journey_left">
                                <div style="color:#46a9b8; margin-left:7px; padding-top:10px">Lesson</div>
                            </div>
                            <div class="dashboard_sub_journey_right">
                                <div class="quant_journey_bubble"></div>
                                <div class="quant_journey_bg"></div>
                                <div class="quant_journey_progress" style="width: <?php echo $journeyStats[1]['done']; ?>px;"></div>
                            </div>
                        </a>
                    </div>


                    <div class="dashboard_sub_analytics">
                        <a href="/analytics/Quant-DI"><div class="view_all_analytics">View detailed analytics</div></a>
                        <div class="score_circle_container">
                            <div class="sub_analytics_score">Accuracy</div>
                            <div class="sub_analytics_circle">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1">
                                    <path d="M 52 2 A 50 50 0 <?php echo $circleQuant['flag1']; ?> 1 <?php echo 52 + $circleQuant['diffX']; ?> <?php echo 2 + $circleQuant['diffY']; ?>
                                          L 52 51 Z" fill="#46a9b8" stroke="#ffffff" stroke-width="1" stroke-linejoin="round" 
                                          isShadow="true" stroke-opacity="0.5"></path>
                                    <path d="M 52 2 A 50 50 0 <?php echo $circleQuant['flag2']; ?> 0 <?php echo 52 + $circleQuant['diffX']; ?> <?php echo 2 + $circleQuant['diffY']; ?>
                                          L 52 51 Z" fill="#cccccc" stroke="#ffffff" stroke-width="1" stroke-linejoin="round"
                                          isShadow="true" stroke-opacity="0.5"></path>
                                </svg>
                                <div class="sub_analytics_accuracy">
                                    <span style="line-height: 70px;"><?php echo $quantAnalytics->accuracy; ?>%</span>
                                </div>
                            </div>
                            <div class="sub_analytics_avg">Community Accuracy
            
                                <div style="font-family:Century Gothic Bold,Century_Gothic_Bold; font-size:15px"><?php echo $quantAnalytics->communityAccuracy; ?>%</div>
                            </div>
                        </div>
                        <div class="score_bar_container">
                            <div class="sub_analytics_score">Time</div>
                            <div class="your_time_container">
                                <div class="your_time_icon"></div>
                                <div>
                                    <p class="your_time_value" style="color:#47a0ae"><?php echo secondsToString($quantAnalytics->avgTime); ?></p>
                                    <p class="time_base">your time</p>
                                </div>
                            </div>
                            <div class="your_time_container">
                                <div class="your_time_icon_com"></div>
                                <div>
                                    <p class="your_time_value" style="color:#47a0ae"><?php echo secondsToString($quantAnalytics->communityAvgTime); ?></p>
                                    <p class="time_base">Community time</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="dashboard_quant_practice_btn" class="queskey_btn">
                        <a href="/practice/Quant-DI">  <div style="padding-top:9px; width: 138px; height: 35px; color: white;">practice</div></a>
                    </div>
                </div>
                <div id="quant_wrapper" style="float:right">
                    <div class="dashboard_subject" style="color:#d05963">Verbal & Logical Reasoning</div>
                    <a href="/content/Verbal">
                        <div class="dashboard_sub_journey">
                            <div class="dashboard_sub_journey_left">
                                <div style="color:#cd5a64; margin-left:7px; padding-top:10px">Lesson</div>
                            </div>
                            <div class="dashboard_sub_journey_right">
                                <div class="verbal_journey_bubble"></div>
                                <div class="verbal_journey_bg"></div>
                                <div class="verbal_journey_progress" style="width: <?php echo $journeyStats[3]['done']; ?>px;"></div>
                            </div>
                        </div>
                    </a>
                    <div class="dashboard_sub_analytics">
                        <a href="/analytics/Verbal"><div class="view_all_analytics">View detailed analytics</div></a>
                        <div class="score_circle_container">
                            <div class="sub_analytics_score" style="color:#cd5a64">Accuracy</div>
                            <div class="sub_analytics_circle">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" style="z-index: 10;">
                                    <path d="M 52 2 A 50 50 0 <?php echo $circleVerbal['flag1']; ?> 1 <?php echo 52 + $circleVerbal['diffX']; ?> <?php echo 2 + $circleVerbal['diffY']; ?>
                                          L 52 51 Z" fill="#cd5a64" stroke="#ffffff" stroke-width="1" stroke-linejoin="round" 
                                          isShadow="true" stroke-opacity="0.5"></path>
                                    <path d="M 52 2 A 50 50 0 <?php echo $circleVerbal['flag2']; ?> 0 <?php echo 52 + $circleVerbal['diffX']; ?> <?php echo 2 + $circleVerbal['diffY']; ?>
                                          L 52 51 Z" fill="#cccccc" stroke="#ffffff" stroke-width="1" stroke-linejoin="round"
                                          isShadow="true" stroke-opacity="0.5"></path>
                                </svg>
                                <div class="sub_analytics_accuracy" style="color: #cf5a63;">
                                <span style="line-height: 70px;"><?php echo $verbalAnalytics->accuracy; ?>%</span>
                            </div>
                            </div>
                            <div class="sub_analytics_avg"style="color:#cd5a64">Community Accuracy
                                <div style="font-family:Century Gothic Bold,Century_Gothic_Bold; font-size:15px"><?php echo $verbalAnalytics->communityAccuracy; ?>%</div>
                            </div>
                        </div>
                        <div class="score_bar_container">
                            <div class="sub_analytics_score" style="color:#cd5a64">Time</div>
                            <div class="your_time_container">
                                <div class="your_time_icon"></div>
                                <div>
                                    <p class="your_time_value" style="color:#ce5a65"><?php echo secondsToString($verbalAnalytics->avgTime); ?></p>
                                    <p class="time_base">your time</p>
                                </div>
                            </div>
                            <div class="your_time_container">
                                <div class="your_time_icon_com"></div>
                                <div>
                                    <p class="your_time_value" style="color:#ce5a65"><?php echo secondsToString($verbalAnalytics->communityAvgTime); ?></p>
                                    <p class="time_base">Community time</p>
                                </div>
                            </div>
                        </div>


                        <!--                        <div class="score_bar_container">
                                                    <div class="sub_analytics_score" style="color:#cd5a64">Time</div>
                                                    <div class="sub_bar" style="background-color:#cd5a64">
                                                        <div class="sub_bar_overlay"style="background-color:#f5cbcd"></div>
                                                    </div>
                                                </div>-->



                    </div>

                    <div id="dashboard_verbal_practice_btn" class="queskey_btn">
                        <a href="/practice/Verbal">
                            <div style="padding-top:9px; width: 138px; height: 35px; color: white;">practice</div>
                        </a>
                    </div>
                    <!--                    <div class ="dashboard_quiz_text">
                                            <p align="left">total quizzes Taken&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;     54<br/>
                                                quiz left for today&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;     2</p>
                                        </div>-->
                </div>
                <!--                <div id="dashboard_post">
                                    <div class="dashPostBox">
                                        <textarea name="question" id="postActivityBox" maxlength="140" class="dashPostText" placeholder="Whats on your mind"></textarea>
                                        <input class="dashPostButton" type="button" value="Post" onclick="postActivity()" />
                                    </div>
                                </div>-->
                <ul id="postActivityList">
                    <?php
                    if ($activity)
                        foreach ($activity as $feed) {
                            ?>
                            <li>
                                <div class="postActivityLeft"> <a href="/user/<?php echo $feed['userId']; ?>"><img class="other_user_image" src="<?php echo $feed['image']; ?>" width="68" height="68"></img></a>
                                    <div style="float: left;background-color: inherit;">
                                        <div class="postActivityText"><?php echo $feed['name']; ?> <?php echo $feed['line']; ?></div>
                                        <div class="tideActivityFooter" <?php if ($feed['subject'] == 3) echo "style='color:#e06b75;'"; ?>> <?php echo $feed['post']; ?> </div>
                                    </div>
                                </div>
                                <div class="postActivityRight">
                                    <?php
                                    if ($feed['type'] != 1) {
                                        ?>
                                        <a href="<?php echo $feed['link']; ?>"><div class="<?php
                            if ($feed['type'] == 6) {
                                echo 'dashboard_activity_btn_content';
                            } else {
                                echo 'dashboard_activity_btn_quiz';
                            }
                                        ?>" >
                                                <?php echo $feed['button']; ?></div></a>
                                        <div id="activity_other_users">
            <!--                                        <img src="assets/img/activity_user.jpg" class="activity_user" />
                                            <img src="assets/img/activity_user.jpg" class="activity_user" />
                                            <img src="assets/img/activity_user.jpg" class="activity_user" />
                                            <div class="activity_user">+28</div>-->
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </li>
                            <?php
                        }
                    ?>
                </ul>
                <?php include_once 'include/footer.php'; ?>
            </div>

        </div>

        <?php
        if ($userInfo['demoFlag'] == 0) {
            ?>

            <div id="dashboard_demo">
                <div class="demo_bg"> </div>
                <div class="demo_bg_overlay">
                    <div id="body_wrapper_demo">
                        <div id="demo">
                            <div class="demo_content">
                                <h2 id="demo_content_heading"></h2>
                                <h3 id="demo_content_h3"></h3>
                                <p id="demo_content_para">
                                </p>
                            </div>
                            <div class="demo_kink"></div>
                            <div class="demo_close" onclick="closeDemo()">X</div>
                            <div class="demo_btns">
                                <div class="demo_skip" onclick="closeDemo()">Skip</div>
                                <div id="demo_tog_btn" class="queskey_btn" onclick="nextDemoStep()">
                                    <div style="padding-top:7px; color: white;">NEXT</div>
                                </div>
                            </div>
                        </div>
                        <div id="demo_start" style="top:200px; left:330px;">
                            <div class="demo_content">
                                <h2 style="text-transform: none;">Hi 
                                    <?php
                                    if ($userInfo['firstName'] != '' || $userInfo['lastName'] != '') {
                                        echo $userInfo['firstName'] != '' ? $userInfo['firstName'] : $userInfo['lastName'];
                                    } else {
                                        echo $userInfo['username'];
                                    }
                                    ?>
                                </h2>
                                <p style="width: 100%; text-align: center;">
                                    Welcome to <span style="color: #f08223">queskey</span><br>
                                        Let’s have a look at the features
                                </p>
                            </div>
                            <div class="demo_close" onclick="closeDemo()">X</div>
                            <div class="demo_btns">
                                <div class="demo_skip" onclick="closeDemo()">Skip</div>
                                <div id="demo_tog_btn" class="queskey_btn" onclick="startDemo()">
                                    <div style="padding-top:7px; color: white;">Start Demo</div>
                                </div>
                            </div>
                        </div>
                        <div id="demo_end" style="top:200px; left:330px;">
                            <div class="demo_content">
                                <p style="width: 100%; text-align: center;">
                                    Thats All! You are ready to go.
                                </p>
                            </div>
                            <div class="demo_close" onclick="closeDemo()">X</div>
                            <div class="demo_btns">
                                <div id="demo_tog_btn" class="queskey_btn" onclick="closeDemo()">
                                    <div style="padding-top:7px; color: white;">Done</div>
                                </div>
                            </div>
                        </div>
                        <div id="demo_img" class=""/>
                    </div>
                </div>
            </div>
            <div style="opacity:0; position: absolute; left: 0px; top: 0px;" id="hideIt">
                <div class="navBtn_activity_demo"></div>
                <div class="navBtn_analytics_demo"></div>
                <div class="navBtn_analytics_summary_demo"></div>
                <div class="navBtn_content_demo"></div>
                <div class="navBtn_journey_demo"></div>
                <div class="navBtn_practice_demo"></div>
                <div class="demo_kink"></div>
            </div>
            <?php
            $userObject->updateDemoFlag();
        }
        ?>
    </body>
</html>