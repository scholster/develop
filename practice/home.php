<script src="/assets/js/simple-slider.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="/assets/css/simple-slider.css" />
<link href="/assets/css/flat-ui.css" rel="stylesheet">
<script type="text/javascript" defer>
    $(document).ready(function() {
        if (!$.browser.opera) {
            $('select.select').each(function() {
                var title = $(this).attr('title');
                if ($('option:selected', this).val() != '')
                    title = $('option:selected', this).text();
                $(this)
                .css({'z-index': 10, 'opacity': 0, '-khtml-appearance': 'none'})
                .after('<span class="select">' + title + '</span>')
                .change(function() {
                    val = $('option:selected', this).text();
                    $(this).next().text(val);
                })
            });
        };
        
        var height = $(document).height();
        var intheight = parseInt(height)-200;
        $(".top_wrapper").css("height",intheight+"px");
       
        $("#timeInput").bind("slider:ready slider:changed", function (event, data) {
            // The currently selected value of the slider
            $("#timeResult").val(data.value.toFixed(1));
        });
        
        $("#questionNumber").bind("slider:ready slider:changed", function (event, data) {
            // The currently selected value of the slider
            $("#questionResult").val(data.value.toFixed(0));
        });
        
        $("#selectAll").click(function(){
            var checked_status = this.checked;
            $("input[name='quantTopics[]']").each(function(){
                this.checked = checked_status;
            });
            $("input[name='verbalTopics[]']").each(function(){
                this.checked = checked_status;
            });
        });
        
        practiceOnChangeType();
    });
</script>
<?php
require_once '../Util/DateTime.php';
$sub = 1;

if (isset($_GET['subject'])) {
    $subject = $_GET['subject'];
    if (strcasecmp($subject, "Verbal") == 0) {
        $sub = 3;
    } elseif (strcasecmp($subject, "Quant-DI") == 0) {
        $sub = 1;
    }
}

$quizArchive = $userObject->getQuizArchive();

include_once '../Controller/ContentController.php';

$contentObject = new ContentController();

$quantTopics = $contentObject->getTopics(1);
$verbalTopics = $contentObject->getTopics(3);
?>

<body>
    <div id="body_wrapper">
        <div id="headerAndNav">
            <?php include_once '../include/header.php'; ?>
        </div>
        <div class="inner_wrapper">
            <div class="top_wrapper">
                <div class="page_header_back">
                    <div class="page_header_back_text" style="color:#959595">
                        Start a new practice session
                    </div>
                </div>

                <form method="post" action="/startQuiz" class="practice_form" style="float:left">
                    <div style="display: none;">
                        Select practice type<br/>
                        <input type="radio" name="practiceType" value="1" style="display: inline;" onchange="practiceOnChangeType();" />Pre-Defined Test
                        <input type="radio" name="practiceType" value="2" style="display: inline;" checked="checked" onchange="practiceOnChangeType();"/>Create your own
                    </div>

                    <div id="practice_step1">

                        <h2 class="practice_subhead"> Choose Topics</h2>
                        <div class="subject_switch">
                            <table width="765px;">
                                <tr>
                                    <td width="52px" style="text-align:left; color:#999">QUANT</td>
                                    <td width="120px"  style="text-align:center ; ">
                                        <input type="checkbox" name="subject" value="1" data-toggle="switch" onchange="practiceOnChangeSubject()" style="display: none;"/>
                                    </td>
                                    <td width="52px" style="text-align:left">VERBAL</td>
                                    <td width="120px" style="float:right; text-align:right">
                                        <input type="checkbox" id="selectAll">
                                        <label for="selectAll"><span></span>Select All</label>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="subject_list" style="height: 282px;">
                            <div id="quant_topic_list">
                                <table width="742px;" style="float:right; padding-top:20px">
                                    <tr>
                                        <?php
                                        $i = 0;
                                        $totalTopics = count($quantTopics);
                                        foreach ($quantTopics as $quantTopic) {
                                            ?>
                                            <td width="33%" style="text-align:left">
                                                <input type="checkbox" name="quantTopics[]" id="<?php echo $quantTopic['topicId']; ?>" value="<?php echo $quantTopic['topicId']; ?>"/>
                                                <label for="<?php echo $quantTopic['topicId']; ?>"><span></span><?php echo $quantTopic['topic']; ?></label>
                                            </td>
                                            <?php
                                            $i++;
                                            if ($i % 3 == 0 && $totalTopics != $i) {
                                                echo '</tr><tr>';
                                            }
                                        }
                                        ?>
                                    </tr>
                                </table>
                            </div>

                            <div id="verbal_topic_list" style="display: none;">
                                <table width="97%" style="float:right; padding-top:20px">
                                    <tr>
                                        <?php
                                        $i = 0;
                                        $totalTopics = count($verbalTopics);
                                        foreach ($verbalTopics as $verbalTopic) {
                                            ?>
                                            <td width="33%" style="text-align:left">
                                                <input type="checkbox" name="verbalTopics[]" id="<?php echo $verbalTopic['topicId']; ?>" value="<?php echo $verbalTopic['topicId']; ?>"/>
                                                <label for="<?php echo $verbalTopic['topicId']; ?>"><span></span><?php echo $verbalTopic['topic']; ?></label>
                                            </td>
                                            <?php
                                            $i++;
                                            if ($i % 3 == 0 && $totalTopics != $i) {
                                                echo '</tr><tr>';
                                            }
                                        }
                                        ?>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="next_btn" onclick="practice_pagination_next()">Next</div>

                        <div class="practice_pagination">
                            <div class="pagination_bullets">

                                <div class="page_bullet_check"></div>
                                <div class="page_bullet" onclick="practice_pagination_next()"></div>
                            </div>
                        </div>
                    </div>
                    <script>
                        function modeChange(){
                            if($("#mode").is(':checked')){
                                $(".timeSlidder").show();
                                $(".noTimeSlidder").hide();
                            }
                            else{
                                $(".timeSlidder").hide();
                                $(".noTimeSlidder").show();
                            }
                        }
                    </script>
                    <div id="practice_step2"  style="display: none; opacity: 0">
                        <h2 class="practice_subhead" style="height: 130px;"> Just one last thing</h2>
                        <div class="subject_list" style="height: 282px;">
                            <table width="100%" border="0" style="font-family: Candara, Candara_Reg; color:#666; font-size:20px; letter-spacing:2px; padding-top: 25px; ">
                                <tr>
                                    <td style="text-align:right;padding-right:20px " >Select Mode</td>
                                    <td width="460px" style="padding-right: 20px; text-align: center;">
                                        <span>Practice</span>
                                        <input type="checkbox" value="check" name="mode" id="mode" data-toggle="switch" style="display: none;" onchange="modeChange()" />
                                        <span>Quiz</span>
                                    </td>
                                </tr>
                                <tr style="height: 10px; padding-top: 50px;">
                                    <td style="text-align:right;padding-right:20px " >&nbsp;</td>
                                    <td width="460px" style="padding-right: 20px;">
                                        <div style="position: absolute; left: 278px;">0</div>
                                        <div style="position: absolute; left: 390px;">5</div>
                                        <div style="position: absolute; left: 497px;">10</div>
                                        <div style="position: absolute; left: 610px;">15</div>
                                        <div style="position: absolute; left: 720px;">20</div>
                                    </td>
                                </tr>
                                <tr style="height: 50px;">
                                    <td width="250px" style="text-align:right;padding-right:20px " >Number of questions</td>
                                    <td width="460px" style="padding-right: 20px; "><input id="questionNumber" style="display: none;" value="10" type="text" 
                                                                                           data-slider="true" data-slider-values="0,5,10,15,20" 
                                                                                           data-slider-snap="true" data-slider-highlight="true">
                                        <input id="questionResult" value="10" type="hidden" name="questions"/> 
                                    </td>
                                </tr>
                                <tr class="noTimeSlidder">
                                    <td colspan="2">*message 1</td>
                                </tr>
                                <tr style="height: 10px;padding-top: 50px; display: none;" class="timeSlidder">
                                    <td style="text-align:right;padding-right:20px " >&nbsp;</td>
                                    <td width="460px" style="padding-right: 20px;">
                                        <div style="position: absolute; left: 268px;">0.5</div>
                                        <div style="position: absolute; left: 331px;">1.0</div>
                                        <div style="position: absolute; left: 397px;">1.5</div>
                                        <div style="position: absolute; left: 461px;">2.0</div>
                                        <div style="position: absolute; left: 527px;">2.5</div>
                                        <div style="position: absolute; left: 590px;">3.0</div>
                                        <div style="position: absolute; left: 653px;">3.5</div>
                                        <div style="position: absolute; left: 720px;">4.0</div>
                                    </td>
                                </tr>
                                <tr style="height: 50px; display: none;" class="timeSlidder">
                                    <td style="text-align:right;padding-right:20px " >Time/Question(min)</td>
                                    <td width="460px" style="padding-right: 20px;">
                                        <input id="timeInput" style="display: none;" value="2" type="text"
                                               data-slider="true" data-slider-values="0.5,1,1.5,2,2.5,3,3.5,4" 
                                               data-slider-snap="true" data-slider-highlight="true">
                                        <input id="timeResult" type="hidden" name="time" value="2"/>
                                    </td>
                                </tr>
                                <tr class="timeSlidder" style="display: none;">
                                    <td colspan="2">*message 2</td>
                                </tr>
                            </table>
                        </div>

                        <button type="submit" class="next_btn" style="border: none;">Start</button>

                        <div class="practice_pagination">
                            <div class="pagination_bullets">
                                <div class="page_bullet" onclick="practice_pagination_prev()"></div>
                                <div class="page_bullet_check"></div>
                            </div>
                        </div>
                    </div>
                </form>
                <?php
                if (isset($_SESSION['dailyQuizMessage']) && isset($_SESSION['dailyQuizMessage']) == TRUE) {
                    unset($_SESSION['dailyQuizMessage']);
                    ?>
                    <div style="float:left; text-align: center; width:100% ; margin-top:50px; font-family:Century Gothic Bold,Century_Gothic_Bold; color:#47a0ae">
                        You have completed the existing practice sessions.<br>
                        More sessions are on their way.
                    </div>
                    <?php
                }
                ?>
                <div style="float:left; width:100% ; margin-top:50px; font-family:Century Gothic Bold,Century_Gothic_Bold; color:#f08223">Practice Log</div>
                <ul class="quizArchiveList" id="quant_list"
                    <?php if ($sub == 1) echo 'style="display:block;"'; ?>>
                        <?php
                        if ($quizArchive[1]) {
                            foreach ($quizArchive[1] as $quiz) {
                                ?>
                            <li>
                                <div class="postActivityLeft"> 
                                    <div style="float: left;background-color: inherit;">
                                        <div class="quizArchiveText">Quiz taken on &nbsp;&nbsp;&nbsp;<span><?php echo dateIndia($quiz['date']); ?></span></div>

                                    </div>
                                </div>
                                <div class="postActivityRight">
                                    <a href="/practice/custom/<?php echo $quiz['quizId'] ?>">
                                        <div class="queskey_btn" id="dashboard_activity_btn_practice" style="padding-left:0px"> View Result </div>
                                    </a>
                                </div>
                            </li>
                            <?php
                        }
                    } else {
                        ?>
                        <li>
                            <div class = "postActivityLeft" style = "width:100%">
                                <div class = "quizArchiveText" style = "width:100%; text-align:center">You have not taken any quiz</div>
                            </div>
                        </li>
                        <?php
                    }
                    ?>
                </ul>

                <ul class="quizArchiveList" id="verbal_list"
                    <?php if ($sub == 3) echo 'style="display:block;"'; ?>>
                        <?php
                        if ($quizArchive[3]) {
                            foreach ($quizArchive[3] as $quiz) {
                                ?>
                            <li>
                                <div class="postActivityLeft"> 
                                    <div style="float: left;background-color: inherit;">
                                        <div class="quizArchiveText">Quiz taken on &nbsp;&nbsp;&nbsp;<span><?php echo dateIndia($quiz['date']); ?></span></div>

                                    </div>
                                </div>
                                <div class="postActivityRight">
                                    <a href="/practice/custom/<?php echo $quiz['quizId'] ?>">
                                        <div class="queskey_btn" id="dashboard_activity_btn_practice" style="padding-left:0px"> View Result </div>
                                    </a>
                                </div>
                            </li>
                            <?php
                        }
                    } else {
                        ?>
                        <li>
                            <div class = "postActivityLeft" style = "width:100%">
                                <div class = "quizArchiveText" style = "width:100%; text-align:center">You have not taken any quiz</div>
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

    <script src="/assets/js/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="/assets/js/jquery.ui.touch-punch.min.js"></script>
    <script src="/assets/js/bootstrap-select.js"></script>
    <script src="/assets/js/bootstrap-switch.js"></script>


    <script src="/assets/js/jquery.tagsinput.js"></script>
    <script src="/assets/js/jquery.placeholder.js"></script>


    <script src="/assets/js/application.js"></script>
</body>