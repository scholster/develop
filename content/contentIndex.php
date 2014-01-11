<?php
$topics = NULL;
//$controller = new ContentController();
if ($controller->subjectId == 1) {
    $topics = $controller->getTopics(1);
} else {
    $topics = $controller->getTopics(3);
}

$topicDone = $controller->getUserTopics($userId);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php include_once '../include/headInclude.php'; ?>
        <title>queskey</title>
        <script type="text/javascript" defer>
            $(document).ready(function() {
                var height = $(document).height();
                var intheight = parseInt(height)-200;
                $(".top_wrapper").css("height",intheight+"px");
            });
        </script>
    </head>
    <body>
        <div id="body_wrapper">
            <div id="headerAndNav">
                <?php include_once '../include/header.php'; ?>
            </div>
            <div class="inner_wrapper">
                <div class="top_wrapper">
                    <div class="page_header_back">
                        <span class="page_header_back_text" style="color:#959595">
                            <?php
                            echo $controller->subjectLabel;
                            ?>
                        </span>
                        <span class="content_arrow"></span>
                    </div>
                    <ul class="content_topic_list">
                        <?php
                        if ($topics)
                            foreach ($topics as $topic) {
                                if ($topic['publish'] == 1) {
                                    ?>
                                    <li>
                                        <a href="<?php echo str_replace(' ', '-', '/content/' . $controller->subject . '/' . $topic['topic']); ?>">
                                            <div class="topic_icon_container">
                                                <div class="topic_icon">
                                                    <img src="/assets/contentImage/<?php echo $topic['image']; ?>" alt="<?php echo $topic['topic']; ?>" width="108" height="108" />
                                                </div>

                                            </div>
                                            <div class="topic_info_main">
                                                <p class="topic_list_name"><?php echo $topic['topic']; ?></p>
                                                <p class="topic_list_desc" style="width: 355px;"><?php echo $topic['intro']; ?></p>
                                                <div class="topic_list_progress">
                                                    <div class="topic_list_progress_base">
                                                        <div class="topic_list_progress_score" style="width:<?php 
                                                        if(isset($topicDone[$topic['topicId']]))
                                                            {                                                            echo $topicDone[$topic['topicId']]."%"; }
                                                            else{
                                                                echo '0%';
                                                            }
                                                        
                                                        ?>">
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="topic_list_button" class="queskey_btn">
                                                <div style="padding-top:9px;">STUDY</div>
                                            </div>
                                        </a>
                                    </li>
                                    <?php
                                } else {
                                    ?>
                                    <li>
                                        <div class="topic_icon_container">
                                            <div class="topic_icon">
                                                <img src="/assets/img/icon_topic_lock.png" width="108" height="108"/>
                                            </div>
                                        </div>
                                        <div class="topic_info_main">
                                            <p class="topic_list_name"><?php echo $topic['topic']; ?></p>
                                            <p class="topic_list_desc" style="width: 355px;"><?php echo $topic['intro']; ?></p>

                                        </div>
                                        <div class="topic_list_button_soon">
                                            <div style="padding-top:9px;">Coming Soon</div>
                                        </div>
                                    </li>
                                    <?php
                                }
                            }
                        ?>

                    </ul>
                </div>
                <?php include_once '../include/footer.php'; ?>
            </div>
        </div>
    </body>
</html>