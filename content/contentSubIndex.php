<?php
//$controller = new ContentController();
$topic = str_replace("-", " ", $controller->topic);
$topicInfo = $controller->getTopicInfo($topic);
if ($topicInfo == NULL) {
    include_once '../notfound.html';
    exit();
}
$subTopics = $controller->getSubTopics($topicInfo['topicId'],$userId);
$reviewQuizIds = $controller->getReviewQuiz($topicInfo['topicId'],$userId);

$topicProgress = $controller->getUserTopicProgress($topicInfo['topicId'],$userId);

//$userInfo['demoFlag3'] = 0;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php include_once '../include/headInclude.php'; ?>
        <title>queskey</title>
        <script type="text/javascript" defer>
            $(document).ready(function() {
                var height = $(document).height();
                var intheight = parseInt(height) - 200;
                $(".top_wrapper").css("height", intheight + "px");
            });
        </script>
        <?php
        if ($userInfo['demoFlag3'] == 0) {
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
                        <span class="page_header_back_link">
                            <a href="<?php echo str_replace(' ', '-', '/content/' . $controller->subject); ?>" class="page_header_back_a">
                                <?php
                                echo $controller->subjectLabel;
                                ?>
                            </a>
                        </span>
                        <span class="content_arrow"></span>
                        <span class="page_header_back_text">
                            <?php echo $controller->topic; ?>
                        </span>
                        <span class="content_arrow"></span>
                    </div>
                    <div class="content_subtopic_name">

                        <div class="topic_icon_container">
                            <div class="topic_icon">
                                <img src="/assets/contentImage/<?php echo $topicInfo['image']; ?>" width="108" height="108" />
                            </div>
                        </div>
                        <div class="topic_info_large">
                            <p class="topic_list_name_large"><?php echo $topicInfo['topic']; ?></p>
                            <p class="topic_list_desc"><?php echo $topicInfo['intro']; ?></p>
                            <div class="topic_list_progress">
                                <div class="topic_list_progress_base_large"><div class="topic_list_progress_score" style="width:<?php echo $topicProgress . '%'; ?>"></div> </div>
                            </div>
                        </div>
                    </div>

                    <ul class="content_subtopic_list" style="padding-bottom: 80px">
                        <?php
                        if ($subTopics)
                            foreach ($subTopics as $subTopic) {
                                ?>
                                <li>
                                    <div class="topic_info">
                                        <p class="subtopic_list_name"><?php echo $subTopic['subTopic']; ?></p>
                                    </div>
                                    <?php
                                    $subTopicQuizIds = $controller->getSubTopicQuiz($subTopic['id'], $userId);
                                    if ($subTopicQuizIds)
                                        foreach ($subTopicQuizIds as $subTopicQuiz) {
                                            ?>
                                            <a href="/practice/1/<?php echo $subTopicQuiz['id']; ?>">
                                                <div class = "subtopic_icon_container"
                                                     <?php if ($subTopicQuiz['total'] == $subTopicQuiz['done']) echo 'style="border-color: #ffb400;"'; ?>>
                                                    <div class = "sub_topic_icon"><img style="margin-left: -5px;" src = "/assets/img/subtopic_quiz.png" width="23" height="23" /></div>
                                                    <div class = "sub_topic_icon_text">Practice</div>
                                                </div>
                                            </a>
                                            <?php
                                        }
                                    ?>

                                    <a href = "<?php echo str_replace(' ', '-', '/content/' . $controller->subject . '/' . $controller->topic . '/' . $subTopic['subTopic']); ?>">
                                        <div class = "subtopic_icon_container" 
                                             <?php if ($subTopic['readflag'] == $subTopic['id']) echo 'style="border-color: #ffb400;"'; ?>>
                                            <div class = "sub_topic_icon"><img src = "/assets/img/subtopic_play.png" width="23" height="23" /></div>
                                            <div class = "sub_topic_icon_text">Study</div>
                                        </div>
                                    </a>
                                </li>
                                <?php
                            }
                        ?>
                        <li>
                            <div class="topic_info">
                                <p class="subtopic_list_name" style="color: #cf5a63;"><?php echo $controller->topic ?> Drills</p>

                            </div>
                            <?php
                            if ($reviewQuizIds)
                                foreach ($reviewQuizIds as $reviewQuiz) {
                                    ?>
                                    <a href="/practice/2/<?php echo $reviewQuiz['id']; ?>">
                                        <div class = "subtopic_icon_container"
                                             <?php if ($reviewQuiz['doneflag'] == $reviewQuiz['id']) echo 'style="border-color: #ffb400;"'; ?>>
                                            <div class = "sub_topic_icon"><img style="margin-left: -5px;" src = "/assets/img/subtopic_quiz_review.png" width="23" height="23"/></div>
                                            <div class = "sub_topic_icon_text">Practice</div>
                                        </div>
                                    </a>
                                    <?php
                                }
                            ?>
                        </li>
                    </ul>
                </div>
                <?php include_once '../include/footer.php'; ?>
            </div>
        </div>
        <?php
        if ($userInfo['demoFlag3'] == 0) {
            ?>

            <div id="dashboard_demo">
                <div class="demo_bg"> </div>
                <div class="demo_bg_overlay">
                    <div id="body_wrapper_demo">
                        <div id="demo_start" style="top:150px; left:271px;">
                            <div class="demo_content">
                                <img src="/assets/img/subtopic_intro.jpg" alt="Subtopic Index Summary"/>
                            </div>
                            <div class="demo_close" onclick="closeDemo()">X</div>
                            <div class="demo_btns">
                                <div id="demo_tog_btn" class="queskey_btn" onclick="closeDemo()">
                                    <div style="padding-top:7px; color: white;">Got it!</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="opacity:0; position: absolute; left: 0px; top: 0px;" id="hideIt">
                <div class="demo_kink"></div>
                <div class="navBtn_analytics_page_demo"></div>
            </div>
            <?php
            $userObject->updateDemoFlag3();
        }
        ?>
    </body>
</html>