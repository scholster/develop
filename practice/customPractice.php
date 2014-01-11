<?php

$userId = $_SESSION['userId'];

$questions = $quizModel->getCustomQuizQuestions($quizId,$userId);
$avgTime = $quizModel->getCustomQuizQuestionAvgTime($quizId);

$size = count($questions);
$quesNo = 1;
?>
<body class="quiz_body">
    <script type="text/javascript" src="/assets/js/quiz_1.js"></script>
    <script>
        $(document).ready(function() {
            
            setTotalQuestions(<?php echo $size; ?>);
            
            window.onresize = function(event) {

                var wrap_width = $('#quiz_content').css("width");
                var wrap_width_int = parseInt(wrap_width);
                $('#quiz_footer_wrapper').css('width', wrap_width_int - 20);
                $('#quiz_navlist').css('width', wrap_width_int - 220);


                var window_height = $(window).height();
                var window_height_int = parseInt(window_height);
                $('.inner_wrapper_quiz').css('height', window_height_int - 130);
                $('.quiz_ques_container').css('height', window_height_int - 200);


            };

            var wrap_width = $('#quiz_content').css("width");
            var wrap_width_int = parseInt(wrap_width);
            $('#quiz_footer_wrapper').css('width', wrap_width_int - 20);
            $('#quiz_navlist').css('width', wrap_width_int - 220);


            var window_height = $(window).height();
            var window_height_int = parseInt(window_height);
            $('.inner_wrapper_quiz').css('height', window_height_int - 130);
            $('.quiz_ques_container').css('height', window_height_int - 200);
        });
    </script>
    <?php include_once 'quizInclude.php'; ?>
    <div id="quiz_content">
        <div class="inner_wrapper_quiz">
            <div class="page_header_back_quiz" style="background-image:url(/assets/img/subtopic_quiz.png); 
                 background-repeat: no-repeat; padding-left: 50px; background-position: 15px 15px;">
                 Custom Quiz
                <div id="timer" style="display: none;">0:0</div>
                <input type="button" class="queskey_btn" id="quiz_submit" value="Submit Answer" onclick="checkCustomQuizAnswer()" style="display: none;"/>
                <input type="button" class="queskey_btn" value="NEXT" id="nextButton" onclick="nextQuestion()"  style="display: none; "/>
                <a class="queskey_btn" id="goBackToIndex" class="queskey_btn"
                   href="/practice">
                    End Quiz
                </a>
                <input type="button" class="queskey_btn" value="PREV" id="prevButton" onclick="prevQuestion()"  style="display: none; "/>
            </div>
            <?php
            if ($questions)
                foreach ($questions as $question) {
                    ?>
                    <input type="hidden" id="questionId<?php echo $quesNo; ?>" value="<?php echo $question['id'] ?>"/>
                    <input type="hidden" id="questionAnswered<?php echo $quesNo; ?>" value="<?php
            if ($question['answer'] == NULL)
                echo '1';
            else
                echo '2';
                    ?>"/>
                    <div id="quizQuesDiv<?php echo $quesNo ?>" style="height:100%; <?php
                   if ($quesNo != 1) {
                       echo 'display:none';
                   }
                    ?>">
                             <?php
                             if (!($question['text'] == NULL || $question['text'] == '')) {
                                 ?>
                            <div class="quiz_ques_container" style="width: 50%; float: left;">
                                <p align="justify"><?php echo nl2br($question['text']); ?></p>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="quiz_ques_container" <?php
                if (!($question['text'] == NULL || $question['text'] == '')) {
                    echo 'style="width: 50%; float: left;"';
                }
                        ?>>
                            <div id="ques_question"> <b></b>
                                <p class="quiz_ques "align="justify">
                                    <?php echo nl2br($question['question']); ?>
                                </p>
                            </div>
                            <div id="quiz_ques_options">
                                <input type="radio" id="quizQuesRadio1<?php echo $quesNo; ?>" value="1" name="quizQuesRadio<?php echo $quesNo; ?>"
                                       <?php if ($question['answer'] != NULL && $question['answer'] == 1) echo 'checked' ?>/>
                                <label for="quizQuesRadio1<?php echo $quesNo; ?>">
                                    <span class="quiz_option_icon"></span>
                                    <p class="quiz_option_para"><?php echo $question['option1']; ?></p>
                                </label>
                                <input type="radio" id="quizQuesRadio2<?php echo $quesNo; ?>" value="2" name="quizQuesRadio<?php echo $quesNo; ?>" 
                                       <?php if ($question['answer'] != NULL && $question['answer'] == 2) echo 'checked' ?>/>
                                <label for="quizQuesRadio2<?php echo $quesNo; ?>">
                                    <span class="quiz_option_icon"></span>
                                    <p class="quiz_option_para"><?php echo $question['option2']; ?></p>
                                </label>
                                <input type="radio" id="quizQuesRadio3<?php echo $quesNo; ?>" value="3" name="quizQuesRadio<?php echo $quesNo; ?>" 
                                       <?php if ($question['answer'] != NULL && $question['answer'] == 3) echo 'checked' ?>/>
                                <label for="quizQuesRadio3<?php echo $quesNo; ?>">
                                    <span class="quiz_option_icon"></span>
                                    <p class="quiz_option_para"><?php echo $question['option3']; ?></p>
                                </label>
                                <input type="radio" id="quizQuesRadio4<?php echo $quesNo; ?>" value="4" name="quizQuesRadio<?php echo $quesNo; ?>" 
                                       <?php if ($question['answer'] != NULL && $question['answer'] == 4) echo 'checked' ?>/>
                                <label for="quizQuesRadio4<?php echo $quesNo; ?>">
                                    <span class="quiz_option_icon"></span>
                                    <p class="quiz_option_para"><?php echo $question['option4']; ?></p>
                                </label>
                                <?php if ($question['option5'] != NULL && $question['option5'] != "") { ?>
                                    <input type="radio" id="quizQuesRadio5<?php echo $quesNo; ?>" value="5" name="quizQuesRadio<?php echo $quesNo; ?>" 
                                           <?php if ($question['answer'] != NULL && $question['answer'] == 5) echo 'checked' ?>/>
                                    <label for="quizQuesRadio5<?php echo $quesNo; ?>">
                                        <span class="quiz_option_icon"></span>
                                        <p class="quiz_option_para"><?php echo $question['option5']; ?></p>
                                    </label>
                                <?php } ?>
                            </div>
                            <div id="quizSolDiv<?php echo $quesNo; ?>" <?php if ($question['answer'] == NULL) { ?> style="display:none;" <?php } ?>>
                                <div class="mini_quiz_soln_part">
                                    <table width="100%">
                                        <tr>
                                            <td width="25%">
                                                <?php
                                                if ($question['answer'] != NULL && $question['answer'] == $question['correctOption']) {
                                                    $answer = "(Correct)";
                                                    $colorCode = "#61983b";
                                                } else {
                                                    $answer = "(Incorrect)";
                                                    $colorCode = "#cf5a63";
                                                }
                                                ?>
                                                <p>Your Answer<br/>
                                                    <span class="min_quiz_century" id="userAnswer<?php echo $quesNo; ?>" style="color:<?php echo $colorCode; ?> ; ">
                                                        <b> <?php echo quizNumbertoLetters($question['answer']) . " " . $answer; ?>  </b>
                                                    </span>
                                                </p>
                                            </td>
                                            <td width="25%" >
                                                <p>Correct Options<br/>
                                                    <span class="min_quiz_century" id="correctOption<?php echo $quesNo; ?>" >
                                                        <b> <?php echo quizNumbertoLetters($question['correctOption']); ?> </b>
                                                    </span>
                                                </p>
                                            </td>
                                            <td width="25%"><p>Your Pace<br/> <span class="min_quiz_century" id="userPace<?php echo $quesNo; ?>" ><b>
                                                            <?php echo secondsToString($question['timeTaken']); ?>
                                                        </b></span></p></td>
                                            <td width="25%">
                                                <p>Community Pace<br/> <span class="min_quiz_century" id="communityPace<?php echo $quesNo; ?>"><b> 
                                                            <?php echo secondsToString($avgTime[$question['id']]); ?>
                                                        </b></span></p></td>
                                        </tr>
                                    </table>

                                </div>
                                <div id="ques_question"> <b></b>
                                    <p align="justify"><h3> Solution</h3><br>
                                    <div id="questionSolution<?php echo $quesNo; ?>" style="text-align: justify; line-height: 28px;">
                                        <?php echo nl2br($question['solution']); ?>
                                    </div>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $quesNo++;
                }
            ?>
        </div>
    </div>
    <div class="min_quiz_button"></div>
</body>