<?php
$questions = $controller->getQuestions(2);
$avgTime = $controller->getQuestionAvgTime(2);
$resultInfo = $controller->getReviewQuizResult();
$size = count($questions);
?>
<script>

    var totalQuestions = <?php echo $size; ?>;
    var currentQuestion = 1;

    window.onresize = function(event) {
        setPageWidth();
    };

    function setPageWidth() {
        var wrap_width = $('#quiz_result_content').css("width");
        var wrap_width_int = parseInt(wrap_width);
        wrap_width_int = wrap_width_int / 2;
        $('#quiz_ansers').css('width', wrap_width_int - 70);
        $('.quiz_list_ques_text').css('width', wrap_width_int - 190);

        $('.resultActivityFooter').css('width', wrap_width_int - 400);



        var window_height = $(window).height();
        var window_height_int = parseInt(window_height);
        $('.inner_wrapper_result').css('height', window_height_int - 100);
        $('.quiz_result_container').css('height', window_height_int - 180);
        $('.quiz_result_container_last').css('height', window_height_int - 180);


        var result_summary_table_width = $('#quizQuesTable' + currentQuestion).width();
        var result_summary_table_width_int = parseInt(result_summary_table_width);
        var result_option_content_width = result_summary_table_width_int - 257;
        $('.result_option_content').css('width', result_option_content_width);

        $('.quiz_result_container').jScrollPane({
            horizontalDragMaxWidth: 0,
            contentWidth: '0px',
            maintainPosition: false
        });
        $('.quiz_result_container .jspContainer').css('width', $('.quiz_result_container').width() - 5);
        $('.quiz_result_container').css('width', $('.quiz_result_container').width() - 1);
        $('.quiz_result_container_last').jScrollPane({
            horizontalDragMaxWidth: 0,
            contentWidth: '0px',
            maintainPosition: false,
            autoReinitialise: true
        });
    }

    $(window).bind("load", function() {
        $("#quizQuesDiv1").show();
        setPageWidth();
    });


    function navigateToQuestion(quesNo) {
        if (0 < quesNo && quesNo <= totalQuestions) {
            $("#navigateNo" + currentQuestion).attr("class", "quiz_list_question");
            $("#quizQuesDiv" + currentQuestion).hide();
            $("#quizQuesDiv" + quesNo).show();
            currentQuestion = quesNo;
            $("#navigateNo" + currentQuestion).attr("class", "quiz_list_question_current");
        }
    }

</script>


<?php include_once 'quizInclude.php'; ?>
<div id="quiz_result_content">
    <div class="inner_wrapper_result">
        <div class="page_header_back_quiz" style="background-image:url(/assets/img/subtopic_quiz_review.png); 
             background-repeat: no-repeat; padding-left: 50px; background-position: 15px 15px;">
            <?php echo $controller->topicName; ?>  Drill Result
        </div>
        <div class="quiz_result_container">
            <ul id="quiz_ansers">
                <?php
                $i = 1;
                if ($questions)
                    foreach ($questions as $question) {
                        ?>

                        <li id="navigateNo<?php echo $i; ?>" style="cursor: pointer;" onclick="navigateToQuestion(<?php echo $i; ?>)" class="<?php
                        if ($i == 1) {
                            echo 'quiz_list_question_current';
                        } else {
                            echo 'quiz_list_question';
                        }
                        ?>">
                            <table cellpadding="10">
                                <tr>
                                    <?php
                                    if ($question['answer'] != NULL && $question['answer'] != '') {
                                        if ($question['answer'] == $question['correctOption']) {
                                            ?>
                                            <td class="ques_right_icon"></td>
                                        <?php } else {
                                            ?>
                                            <td class="ques_wrong_icon"></td>
                                            <?php
                                        }
                                    } else {
                                        echo '<td class="ques_notAttempted_icon"></td>';
                                    }
                                    ?>
                                    <td class="quiz_list_ques_no" width="50px"> Q<?php echo $i; ?></td>
                                    <td class="quiz_list_ques_text" >
                                        <p align="justify"><?php echo $question['question'] ?> </p>
                                    </td></tr>
                            </table>
                        </li>
                        <?php
                        $i++;
                    }
                ?>        
            </ul>
        </div>
        <div class="quiz_result_container_last">
            <div class="quiz_result_right">

                <div class="result_summary_head">summary</div>
                <?php
                $i = 1;
                if ($questions)
                    foreach ($questions as $question) {
                        ?>
                        <div id="quizQuesDiv<?php echo $i; ?>" style="display: none;">
                            <table class="result_summary_table" id="quizQuesTable<?php echo $i; ?>"  width="100%">
                                <tr>
                                    <?php
                                    if ($question['correctOption'] == 1) {
                                        echo '<td class="quiz_list_option_icon_right" width="25px"></td>';
                                    } elseif ($question['answer'] == 1 && $question['answer'] != $question['correctOption']) {
                                        echo '<td class="quiz_list_option_icon_wrong" width="25px"></td>';
                                    } else {
                                        echo '<td class="quiz_list_option_icon_default" width="25px"></td>';
                                    }
                                    ?>
                                    <td class="result_option_sno" width="32px">A.</td>
                                    <td class="result_option_content"><?php echo $question['option1']; ?></td>
                                    <td class="result_option_comment" width="200px">
                                        <?php
                                        if ($question['correctOption'] == 1 && $question['answer'] == 1) {
                                            echo '<span>YOUR ANSWER IS CORRECT</span>';
                                        } elseif ($question['answer'] == 1 && $question['answer'] != $question['correctOption']) {
                                            echo '<span>YOUR ANSWER</span>';
                                        } elseif ($question['correctOption'] == 1) {
                                            echo '<span>CORRECT OPTION</span>';
                                        } else {
                                            echo '&nbsp;';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <?php
                                    if ($question['correctOption'] == 2) {
                                        echo '<td class="quiz_list_option_icon_right" width="25px"></td>';
                                    } elseif ($question['answer'] == 2 && $question['answer'] != $question['correctOption']) {
                                        echo '<td class="quiz_list_option_icon_wrong" width="25px"></td>';
                                    } else {
                                        echo '<td class="quiz_list_option_icon_default" width="25px"></td>';
                                    }
                                    ?>
                                    <td class="result_option_sno" width="32px">B.</td>
                                    <td class="result_option_content"><?php echo $question['option2']; ?></td>
                                    <td class="result_option_comment" width="200px">
                                        <?php
                                        if ($question['correctOption'] == 2 && $question['answer'] == 2) {
                                            echo '<span>YOUR ANSWER IS CORRECT</span>';
                                        } elseif ($question['answer'] == 2 && $question['answer'] != $question['correctOption']) {
                                            echo '<span>YOUR ANSWER</span>';
                                        } elseif ($question['correctOption'] == 2) {
                                            echo '<span>CORRECT OPTION</span>';
                                        } else {
                                            echo '&nbsp;';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <?php
                                    if ($question['correctOption'] == 3) {
                                        echo '<td class="quiz_list_option_icon_right" width="25px"></td>';
                                    } elseif ($question['answer'] == 3 && $question['answer'] != $question['correctOption']) {
                                        echo '<td class="quiz_list_option_icon_wrong" width="25px"></td>';
                                    } else {
                                        echo '<td class="quiz_list_option_icon_default" width="25px"></td>';
                                    }
                                    ?>
                                    <td class="result_option_sno" width="32px">C.</td>
                                    <td class="result_option_content"><?php echo $question['option3']; ?></td>
                                    <td class="result_option_comment" width="200px">
                                        <?php
                                        if ($question['correctOption'] == 3 && $question['answer'] == 3) {
                                            echo '<span>YOUR ANSWER IS CORRECT</span>';
                                        } elseif ($question['answer'] == 3 && $question['answer'] != $question['correctOption']) {
                                            echo '<span>YOUR ANSWER</span>';
                                        } elseif ($question['correctOption'] == 3) {
                                            echo '<span>CORRECT OPTION</span>';
                                        } else {
                                            echo '&nbsp;';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <?php
                                    if ($question['correctOption'] == 4) {
                                        echo '<td class="quiz_list_option_icon_right" width="25px"></td>';
                                    } elseif ($question['answer'] == 4 && $question['answer'] != $question['correctOption']) {
                                        echo '<td class="quiz_list_option_icon_wrong" width="25px"></td>';
                                    } else {
                                        echo '<td class="quiz_list_option_icon_default" width="25px"></td>';
                                    }
                                    ?>
                                    <td class="result_option_sno" width="32px">D.</td>
                                    <td class="result_option_content"><?php echo $question['option4']; ?></td>
                                    <td class="result_option_comment" width="200px">
                                        <?php
                                        if ($question['correctOption'] == 4 && $question['answer'] == 4) {
                                            echo '<span>YOUR ANSWER IS CORRECT</span>';
                                        } elseif ($question['answer'] == 4 && $question['answer'] != $question['correctOption']) {
                                            echo '<span>YOUR ANSWER</span>';
                                        } elseif ($question['correctOption'] == 4) {
                                            echo '<span>CORRECT OPTION</span>';
                                        } else {
                                            echo '&nbsp;';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                                if ($question['option5'] != NULL && $question['option5'] != '') {
                                    ?>
                                    <tr>
                                        <?php
                                        if ($question['correctOption'] == 5) {
                                            echo '<td class="quiz_list_option_icon_right" width="25px"></td>';
                                        } elseif ($question['answer'] == 5 && $question['answer'] != $question['correctOption']) {
                                            echo '<td class="quiz_list_option_icon_wrong" width="25px"></td>';
                                        } else {
                                            echo '<td class="quiz_list_option_icon_default" width="25px"></td>';
                                        }
                                        ?>

                                        <td class="result_option_sno" width="32px">E.</td>
                                        <td class="result_option_content"><?php echo $question['option5']; ?></td>
                                        <td class="result_option_comment" width="200px">
                                            <?php
                                            if ($question['correctOption'] == 5 && $question['answer'] == 5) {
                                                echo '<span>YOUR ANSWER IS CORRECT</span>';
                                            } elseif ($question['answer'] == 5 && $question['answer'] != $question['correctOption']) {
                                                echo '<span>YOUR ANSWER</span>';
                                            } elseif ($question['correctOption'] == 5) {
                                                echo '<span>CORRECT OPTION</span>';
                                            } else {
                                                echo '&nbsp;';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>

                            <table class="result_pace_table" width="100%">
                                <tr>
                                    <td class="result_your_pace_icon"></td>
                                    <td> <p class="result_pace_main"><?php echo secondsToString($question['timeTaken']); ?></p><p class="result_pace_subhead">Your pace</p></td>
                                    <td class="result_avg_pace_icon"></td>
                                    <td> <p class="result_pace_main"><?php echo secondsToString($avgTime[$question['id']]); ?></p><p class="result_pace_subhead">Community pace</p></td>
                                    <td class="result_sub_icon"></td>
                                    <td >
                                        <?php
                                        if ($controller->subject == 1) {
                                            $href = str_replace(' ', '-', '/content/Quant-DI' . '/' . $controller->topicName);
                                        } else {
                                            $href = str_replace(' ', '-', '/content/Verbal' . '/' . $controller->topicName);
                                        }
                                        ?>
                                        <p class="result_pace_subhead" >Revise Topic</p><p class="result_subject_name">
                                            <a href="<?php echo $href; ?>">    <?php echo $controller->topicName; ?> </a>
                                        </p>
                                    </td>
                                </tr>


                            </table>
                            <div class="result_summary_head" style="margin-top:40px">solution</div>                            
                            <table class="result_sol_table" width="100%">
                                <tr class="queskey_anser">
                                    <td class="postSolnLeft" width="68px"><img class="queskey_image" src="http://behance.vo.llnwd.net/profiles23/2202141/projects/8097109/c8a850b9ac651bc025ac2b3aa1083cc7.jpg"/></td>
                                    <td class="postSolnText" ><p align="justify"><span class="resultActivityText">Queskey Solution</span>
                                            <br/> <?php echo nl2br($question['solution']); ?> </p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <?php
                        $i++;
                    }
                ?>
            </div>    
        </div>
    </div>
</div>
</body>
</html>