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

$meId = $_SESSION['userId'];

$isme = FALSE;

if (isset($_GET['id']) && $_GET['id'] != $meId) {
    $youId = $_GET['id'];
} else {
    header("Location:/");
    exit();
}

$userObject = new UserDetailsController($meId);
$userInfo = $userObject->info;

$youObject = new UserDetailsController($youId);
$youInfo = $youObject->info;

if($youInfo == NULL){
    include_once '../notFound.php';
    exit();
}

$activity = $youObject->getActivity($youId, NULL);

$messages = $userObject->getMessages($youId);
$relation = $userObject->getRelation($youId);

$bestTopics = $youObject->getBestInTopics($youId);
$journeyStats = $youObject->journeyStats;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php include_once '../include/headInclude.php'; ?>
        <title>queskey</title>
        <script src="http://code.jquery.com/jquery-latest.min.js"></script>
        <script>
            var scrollApi;
            $(document).ready(function() {                
                scrollApi = $("#message_thread").jScrollPane({
                    horizontalDragMaxWidth:0,
                    contentWidth:'0px',
                    maintainPosition: false
                }).data('jsp');
                
                setInterval(function() {
                    loadMoreMessages(<?php echo $youId . ',"' . $userInfo['userImage'] . '","' . $youInfo['userImage'] . '"'; ?>,scrollApi)
                }, 10000);
                
                var height = $(document).height();
                var intheight = parseInt(height)-200;
                $(".top_wrapper").css("height",intheight+"px");
            });
        </script>
    </head>
    <body>
        <?php include_once '../google/analytics.php'; ?>
        <div id="body_wrapper">
            <div id="headerAndNav">
                <?php include_once '../include/header.php'; ?>
            </div>
            <div class="inner_wrapper">
                <div class="top_wrapper">
                    <?php if (!$isme) {
                        ?>

                        <img id="other_user_profile_pic" src="<?php echo $youInfo['userImage']; ?>"/>
                        <div id="user_profile_name">
                            <?php
                            if ($youInfo['firstName'] != '' || $youInfo['lastName'] != '') {
                                echo $youInfo['firstName'] . ' ' . $youInfo['lastName'];
                            } else {
                                echo $youInfo['username'];
                            }
                            ?>
                        </div>
                        <!--                    <div id="user_profile_relation" style="height: 0px;">
                        <?php
//                        if ($relation == 1) {
//                            echo 'Friends';
//                        } elseif ($relation == 2) {
//                            echo 'Following';
//                        } elseif ($relation == 3) {
//                            echo 'Follower';
//                        }
                        ?>
                                            </div>-->

                        <div id="profile_add_keychain" class="queskey_btn" style="<?php
                    if ($relation == 1 || $relation == 2) {
                        echo 'display:none;';
                    }
                        ?>" onclick="addtoKeychain(<?php echo $youId; ?>, 1)">
                            <span style="margin-top: 11px;
                                  font-size: 12px;
                                  float: left;
                                  text-align: center;
                                  width: 100%;">Add to KeyChain</span>
                        </div>
                        <div id="profile_remove_keychain" class="queskey_btn" style="<?php
                         if ($relation == 3 || $relation == 4) {
                             echo 'display:none;';
                         }
                        ?>" onclick="addtoKeychain(<?php echo $youId; ?>, 2)">
                            <span style="margin-top: 11px;
                                  font-size: 12px;
                                  float: left;
                                  text-align: center;
                                  width: 100%;">Remove</span>
                        </div>
                        <?php
                    }
                    ?>
                    <div style="width: 765px; float: left;">
                        <div id="profile_journey_wrapper" style="height: 163px; float: left;">
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


                        </div>
                        <div id="profile_journey_wrapper" style="float:right;height: 163px;">
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
                        </div>
                    </div>
                    <?php
                    if (!$isme) {
                        ?>
                        <div class="profile_left">
                            <?php if ($youInfo['education'] != '' || $youInfo['location'] || $youInfo['work']) { ?>
                                <h2>whereabouts</h2>
                                <div class="profile_basic">
                                    <ul class="profile_basic_list">

                                        <?php
                                        if ($youInfo['education'] != '') {
                                            ?>
                                            <li>
                                                <div class="profile_collge_icons"></div>
                                                <div class="profile_basic_name">
                                                    <?php echo $youInfo['education']; ?>
                                                </div>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if ($youInfo['location'] != '') {
                                            ?>
                                            <li>
                                                <div class="profile_location_icons"></div>
                                                <div class="profile_basic_name">
                                                    <?php echo $youInfo['location']; ?>
                                                </div>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if ($youInfo['work'] != '') {
                                            ?>
                                            <li>
                                                <div class="profile_work_icons"></div>
                                                <div class="profile_basic_name">
                                                    <?php echo $youInfo['work']; ?>
                                                </div>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <?php
                            }
                            ?>
                            <h2 style="margin-top: 40px;">score</h2>
                            <div id="profile_progBar">
                                <div class="overlay"></div>
                                <div class="progress" style="width: <?php echo $youObject->smartScore . "%"; ?>;"></div>
                                <div class="score_bg" style="margin-left:<?php echo ($youObject->smartScore - 7.5) . "%"; ?> ; margin-top:-47px;"><?php echo $youObject->smartScore; ?></div>
                            </div>
                            <h2 style="margin-top: 40px;"><?php echo $youInfo['firstName'] ?> is good in</h2>
                            <div id="profile_strong_subs_list">
                                <?php
                                $flag = 0;
                                if ($bestTopics) {
                                    foreach ($bestTopics as $bestTopic) {
                                        if ($bestTopic['percent'] > 60) {
                                            ?>
                                            <div class="profile_strong_subs">
                                                <div class="subject_icon"><img src="/assets/contentImage/<?php echo $bestTopic['image']; ?>" width="67" /></div>
                                                <div class="subject_name"><p align="center"><?php echo $bestTopic['topic']; ?></p></div>
                                            </div>       
                                            <?php
                                            $flag = 1;
                                        }
                                    }
                                }
                                if ($flag == 0) {
                                    echo 'No best topic';
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                    } else {
                        ?>
                        <div class="profile_left" style="width: 736px;">
                            <div style="width: 368px; float: left;">
                                <h2>whereabouts</h2>
                                <div class="profile_basic">
                                    <ul class="profile_basic_list">
                                        <li>
                                            <div class="profile_collge_icons"></div>
                                            <div class="profile_basic_name">
                                                <?php
                                                if ($youInfo['education'] != '') {
                                                    echo $youInfo['education'];
                                                }
                                                ?>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="profile_location_icons"></div>
                                            <div class="profile_basic_name">
                                                <?php
                                                if ($youInfo['location'] != '') {
                                                    echo $youInfo['location'];
                                                }
                                                ?>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="profile_work_icons"></div>
                                            <div class="profile_basic_name">
                                                <?php
                                                if ($youInfo['location'] != '') {
                                                    echo $youInfo['location'];
                                                }
                                                ?>
                                            </div>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                            <div style="width: 308px; float: right;">
                                <h3>score</h3>
                                <div id="profile_progBar">
                                    <div class="overlay"></div>
                                    <div class="progress" style="width: 32%;"></div>
                                </div>
                            </div>
                            <div style="width: 368px;">
                                <h3><?php echo $youInfo['firstName'] ?> is good in</h3>
                                <div id="profile_strong_subs_list">
                                    <?php
                                    if ($bestTopics) {
                                        foreach ($bestTopics as $bestTopic) {
                                            ?>
                                            <div class="profile_strong_subs">
                                                <div class="subject_icon"><img src="/assets/contentImage/<?php echo $bestTopic['image']; ?>" width="67" /></div>
                                                <div class="subject_name"><?php echo $bestTopic['topic']; ?></div>
                                            </div>       
                                            <?php
                                        }
                                    } else {
                                        echo 'No best topic';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>    
                        <?php
                    }
                    ?>

                    <?php if (!$isme) {
                        ?>
                        <div class="profile_right"> 

                            <div id="profile_chat">

                                <textarea name="question" id="messageBox" maxlength="400" class="send_chat" placeholder="Send Message"></textarea>
                                <button class="messageSend_btn" onclick='sendMessage(scrollApi,<?php echo $youId . ',"' . $userInfo['userImage'] . '","' . $youInfo['userImage'] . '"'; ?>)'>Send</button>
                                <div id="message_thread">
                                    <?php
                                    if ($messages) {
                                        foreach ($messages as $message) {
                                            if ($message['from'] == $meId) {
                                                ?>
                                                <div class="msg_thread_right">
                                                    <div class="msg_text_container_right">
                                                        <div id="msg_thread_text">
                                                            <p align="justify"> <?php echo nl2br($message['message']); ?> </p>
                                                        </div>
                                                        <div class="msg_thread_stat"> <?php echo agoIndia($message['time'], time()); ?> </div>
                                                    </div>
                                                    <img class="msg_thread_asker_image_right" src="<?php echo $userInfo['userImage']; ?>" alt="<?php echo $userInfo['username'] ?>"></img>
                                                </div>
                                                <?php
                                            } else {
                                                ?>
                                                <div class="msg_thread_left">
                                                    <img class="msg_thread_asker_image" src="<?php echo $youInfo['userImage']; ?>" alt="<?php echo $youInfo['username'] ?>"></img>
                                                    <div class="msg_text_container_left">
                                                        <div id="msg_thread_text">
                                                            <p align="justify"> <?php echo nl2br($message['message']); ?> </p>
                                                        </div>
                                                        <div class="msg_thread_stat"><?php echo agoIndia($message['time'], time()); ?> </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                    } else {
                                        ?>
                                        <div id="user_chat_else" style="width: 368px;text-align: center;font-size: 21px;height: 260px;color: #666;padding-top: 160px;background-color: #f2f2f2;line-height: 30px;margin-top: 20px;">Start a Conversation</div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>

                        </div>
                        <?php
                    }
                    ?>
                    <ul id="postActivityList" style="float: left; margin-top: 10px;">
                        <?php
                        if ($activity)
                            foreach ($activity as $feed) {
                                ?>
                                <li>
                                    <div class="postActivityLeft"> <a href="/user/<?php echo $feed['userId']; ?>"><img class="other_user_image" src="<?php echo $feed['image']; ?>"></a>
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
                </div>
                <?php include_once '../include/footer.php'; ?>
            </div>
        </div>
    </body>
</html>