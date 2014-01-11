<?php
$subTopicInfo = $controller->getSubTopicInfo();
if ($subTopicInfo == NULL) {
    include_once '../notfound.html';
    exit();
}
$controller->markUserReadContent($_SESSION['userId'], $subTopicInfo['id']);
$controller->setUserContentActivity($_SESSION['userId'], $subTopicInfo['topicId']);
$innerTopics = $controller->getInnerTopics($subTopicInfo['id']);
$notes = $controller->getSubTopicNotes($userId, $subTopicInfo['id']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php include_once '../include/headInclude.php'; ?>
        <title>queskey</title>
        <script type="text/javascript" src="https://c328740.ssl.cf1.rackcdn.com/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
        </script>
        <script>
            $(document).ready(function() {
                var height = $(document).height();
                var intheight = parseInt(height) - 200;
                $(".top_wrapper").css("height", intheight + "px");
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
                        <span class="page_header_back_link">
                            <a href="<?php echo str_replace(' ', '-', '/content/' . $controller->subject); ?>" class="page_header_back_a">
                                <?php
                                echo $controller->subjectLabel;
                                ?>
                            </a>
                        </span>
                        <span class="content_arrow">
                        </span>
                        <span class="page_header_back_link">
                            <a href="<?php echo str_replace(' ', '-', '/content/' . $controller->subject . '/' . $controller->topic); ?>" class="page_header_back_a">
                                <?php
                                echo $controller->topic;
                                ?>
                            </a>
                        </span>
                        <span class="content_arrow"></span>
                        <span class="page_header_back_text">
                            <?php echo $controller->subTopic; ?>
                        </span>
                    </div>



                    <div class="content_text" id="<?php echo $innerContentId; ?>">

                        <h1><?php echo $controller->subTopic; ?></h1>
                        <div style="display: none;">
                            <div style="width:100px; height: 20px; cursor: pointer;"
                                 onclick="showAddNotes()">
                                Add Notes <span id="addNotesSign" style="width: 10px;">+</span>
                            </div>
                            <div id="addNotesDiv" style="display: none;">
                                <textarea rows="4" cols="75" id="subTopicNotes"><?php echo $notes; ?></textarea>
                                <input type="button" value="Save notes" onclick="saveNotes(<?php echo $subTopicInfo['id']; ?>)" />
                            </div>
                        </div>
                        <p><?php echo $subTopicInfo['intro']; ?></p>

                        <?php
                        $i = 0;
                        $total = count($innerTopics);
                        if ($innerTopics)
                            foreach ($innerTopics as $innerTopic) {
                                $innerContents = $controller->getInnerContent($innerTopic['id'], $userId);
                                ?>
                                <div id="content_dropdown_box_<?php echo $i; ?>" class="content_dropdown" onclick="showInnerContent(<?php echo $i . ',' . $total; ?>)">
                                    <h2><?php echo $innerTopic['heading']; ?></h2>
                                    <div id="content_dropdown_arrow_<?php echo $i; ?>" class="content_dropdown_arrow">

                                    </div>
                                </div>
                                <div id="content_inner_<?php echo $i; ?>" style="display:none;">
                                    <?php
                                    $j = 0;
                                    if ($innerContents)
                                        foreach ($innerContents as $innerContent) {
//                                    echo "<p> Content Id" . $innerContent['id'] . "</p>";
                                            if ($innerContent['type'] == 3) {
                                                ?>
                                                <div class ="example" id="content_example_<?php echo $i . '_' . $j; ?>">
                                                    <?php echo $innerContent['content']; ?>
                                                </div>
                                                <?php
                                            } elseif ($innerContent['type'] == 2) {
                                                if ($innerContent['highlight'] == NULL) {
                                                    $class = "content_para_unhighlight";
                                                    $type = 1;
                                                } else {
                                                    $class = "content_para_highlight";
                                                    $type = 0;
                                                }
                                                ?>
                                                <div class ="<?php echo $class; ?>" id="content_para_<?php echo $i . '_' . $j; ?>" 
                                                     onclick="highlightDiv(<?php echo $innerContent['id'] . ',' . $i . ',' . $j . ',' . $type; ?>)">
                                                         <?php echo $innerContent['content']; ?>
                                                </div>
                                                <?php
                                            } else {
                                                echo $innerContent['content'];
                                            }
                                            $j++;
                                        }
                                    ?>
                                </div>
                                <?php
                                $i++;
                            }
                        ?>
                    </div>
                    <div style="float: right;"><a href="./" style="color: #f08222;">Back to <?php echo $controller->topic ?></a></div>
                </div>
                <?php include_once '../include/footer.php'; ?>
            </div>
        </div>
    </body>
</html>