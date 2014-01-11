<body class="quiz_body">
    <?php
    if (!$controller->checkDailyQuizUserStatus()) {
        include 'dailyQuizResultNew.php';
        exit();
    }

    if (isset($_SESSION['quiz' . $controller->quizId])) {
        $time = $_SESSION['quiz' . $controller->quizId];
        $now = time();
        $diff = $now - $time;
    } else {
        $diff = 0;
    }

    $_SESSION['quiz' . $controller->quizId] = time();
    $questions = $controller->getDailyQuizQuestions();
    $controller->createDailyQuizActivity();
    $controller->createDailyQuizUserEntry();
    $size = count($questions);
    $quesNo = 1;
    ?>
    <script type="text/javascript">
        $(document).ready(function() {

            window.onresize = function(event) {

                var wrap_width = $('#quiz_content').css("width");
                var wrap_width_int = parseInt(wrap_width);
                $('#quiz_footer_wrapper').css('width', wrap_width_int - 20);
                $('#quiz_navlist').css('width', wrap_width_int - 220);


                var window_height = $(window).height();
                var window_height_int = parseInt(window_height);
                $('.inner_wrapper_quiz').css('height', window_height_int - 200);
                $('.quiz_ques_container').css('height', window_height_int - 270);


            };

            var wrap_width = $('#quiz_content').css("width");
            var wrap_width_int = parseInt(wrap_width);
            $('#quiz_footer_wrapper').css('width', wrap_width_int - 20);
            $('#quiz_navlist').css('width', wrap_width_int - 220);


            var window_height = $(window).height();
            var window_height_int = parseInt(window_height);
            $('.inner_wrapper_quiz').css('height', window_height_int - 200);
            $('.quiz_ques_container').css('height', window_height_int - 270);

        });

        var time = 0;
        var intervalVariable;
        var currentQuestion = 1;
        var previousTime = 0;
        var totalQuestions = <?php echo $size; ?>;

        function timer() {
            time++;
            timeLeft = 1200 - time;
            min = Math.floor(timeLeft / 60);
            sec = timeLeft % 60;
            var displayTime = min + ":" + sec;
            if (timeLeft < 0) {
                stopTimer();
                $("#quizForm").submit();
            } else {
                $("#timer").html(displayTime);
            }
        }

        function startTimer() {
            time = 0;
            intervalVariable = setInterval(function() {
                timer();
            }, 1000);
        }

        function stopTimer() {
            clearInterval(intervalVariable);
        }

        $(window).bind("load", function() {
            $("#quizStartButton").removeAttr("disabled");
        });

        function nextQuestion() {
            quesNo = currentQuestion;
            if (quesNo < totalQuestions) {
                changeNavClass();
                $("#quizQuesDiv" + quesNo).hide();
                $("#quizQuesDiv" + (quesNo + 1)).show();
                currentQuestion = quesNo + 1;
                questionTime = parseInt($("#questionTime" + quesNo).val());
                questionTime = questionTime + (time - previousTime);
                $("#questionTime" + quesNo).val(questionTime);
                previousTime = time;
                $("#navigateNo" + currentQuestion).attr("class", "current_ques");
                setPrevNext();
            }
        }

        function prevQuestion() {
            quesNo = currentQuestion;
            if (quesNo > 1) {
                changeNavClass();
                $("#quizQuesDiv" + quesNo).hide();
                $("#quizQuesDiv" + (quesNo - 1)).show();
                currentQuestion = quesNo - 1;
                questionTime = parseInt($("#questionTime" + quesNo).val());
                questionTime = questionTime + (time - previousTime);
                $("#questionTime" + quesNo).val(questionTime);
                previousTime = time;
                $("#navigateNo" + currentQuestion).attr("class", "current_ques");
                setPrevNext();
            }
        }

        function changeNavClass() {
            var selected = $("#quizQuesDiv" + currentQuestion + " input[type='radio']:checked");
            if (selected.length > 0) {
                $("#navigateNo" + currentQuestion).attr("class", "attempted");
            } else {
                $("#navigateNo" + currentQuestion).attr("class", "");
            }
        }
        
        function setPrevNext(){
            if(currentQuestion == 1){
                $("#quiz_prev").css("background-color","#BBB");
            }else{
                $("#quiz_prev").css("background-color","#ffb400");
            }
            
            if(currentQuestion == totalQuestions){
                $("#quiz_next").css("background-color","#BBB");
            }else{
                $("#quiz_next").css("background-color","#ffb400");
            }
        }

        function navigateToQuestion(quesNo) {
            if (0 < quesNo && quesNo <= totalQuestions) {
                changeNavClass();
                $("#quizQuesDiv" + currentQuestion).hide();
                $("#quizQuesDiv" + quesNo).show();
                questionTime = parseInt($("#questionTime" + currentQuestion).val());
                questionTime = questionTime + (time - previousTime);
                $("#questionTime" + currentQuestion).val(questionTime);
                previousTime = time;
                currentQuestion = quesNo;
                $("#navigateNo" + currentQuestion).attr("class", "current_ques");
                setPrevNext();
            }
        }

        function beforeSubmit() {
            questionTime = parseInt($("#questionTime" + currentQuestion).val());
            questionTime = questionTime + (time - previousTime);
            $("#questionTime" + currentQuestion).val(questionTime);
            previousTime = time;
            resetBeforeUnload();
            return true;
        }

        function startTest() {
            $("#startTest").hide();
            $("#quizQuesDiv1").show();
            $("#quiz_footer").show();
            $("#quiz_submit").show();
            setBeforeUnload("Quiz is still running.");
            startTimer();
        }

    </script>
    <?php include_once 'quizInclude.php'; ?>
    <div id="quiz_content">
        <div class="inner_wrapper_quiz">
            <form id="quizForm" action="/action/checkQuiz.php" method="POST" onsubmit="beforeSubmit();">
                <div class="page_header_back_quiz">
                    <?php echo ($controller->subject == 1 ? "Quant & DI" : "Verbal & LR"); ?> Quiz 
                    <div id="timer">0:0</div>
                    <input class="queskey_btn" type="submit" value="Submit Test" id="quiz_submit" style="display: none;"/>
                </div>
                <div id="startTest" class="quiz_ques_container">
                	<ul style="width:500px; margin:auto; margin-top: 30px;list-style-type:none; font-family:Century Gothic,Century_Gothic; font-size:16px;background-color: #f2f2f2;
padding: 20px;">
                	<li style="min-height:30px">1. This is the 20 min practice session</li>
                	<li style="min-height:30px">2. There are 10 questions in this session</li>
                	<li style="min-height:30px">3. Press 'NEXT'  or 'PREV' to toggle between questions</li>
                	<li style="min-height:30px">4. You can directly jump on any question from the list given below</li>
                	<li style="min-height:30px">5. The unattempted questions are highlighted</li>
                	<li style="min-height:30px">6.  Press Submit after finishing the test</li>
                	</ul>
                	
                    <div id="quizStartButton" onclick="startTest()" disabled="disabled">Start Session</div>
                </div>
                <input type="hidden" name="quizId" value="<?php echo $controller->quizId; ?>"/>
                <?php
                if($questions)
                foreach ($questions as $question) {
                    ?>
                    <input type="hidden" name="questionId<?php echo $quesNo; ?>" value="<?php echo $question['id'] ?>"/>
                    <div id="quizQuesDiv<?php echo $quesNo ?>" style="display: none;">
                        <?php
                        if (!($question['text'] == NULL || $question['text'] == '')) {
                            ?>
                            <div class="quiz_ques_container" style="width: 50%; float: left;">
                                <p class="quiz_ques" align="justify"><?php echo nl2br($question['text']); ?></p>
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
                                <p class="quiz_ques" align="justify"> 
                                    <?php echo nl2br($question['question']); ?>
                                </p>
                            </div>
                            <div id="quiz_ques_options">
                                <input type="radio" id="quizQuesRadio1<?php echo $quesNo; ?>" value="1" name="quizQuesRadio<?php echo $quesNo; ?>" />
                                <label for="quizQuesRadio1<?php echo $quesNo; ?>">
                                    <span class="quiz_option_icon"></span>
                                    <p class="quiz_option_para"><?php echo $question['option1']; ?></p>
                                </label>
                                <input type="radio" id="quizQuesRadio2<?php echo $quesNo; ?>" value="2" name="quizQuesRadio<?php echo $quesNo; ?>" />
                                <label for="quizQuesRadio2<?php echo $quesNo; ?>">
                                    <span class="quiz_option_icon"></span>
                                    <p class="quiz_option_para"><?php echo $question['option2']; ?></p>
                                </label>
                                <input type="radio" id="quizQuesRadio3<?php echo $quesNo; ?>" value="3" name="quizQuesRadio<?php echo $quesNo; ?>" />
                                <label for="quizQuesRadio3<?php echo $quesNo; ?>">
                                    <span class="quiz_option_icon"></span>
                                    <p class="quiz_option_para"><?php echo $question['option3']; ?></p>
                                </label>
                                <input type="radio" id="quizQuesRadio4<?php echo $quesNo; ?>" value="4" name="quizQuesRadio<?php echo $quesNo; ?>" />
                                <label for="quizQuesRadio4<?php echo $quesNo; ?>">
                                    <span class="quiz_option_icon"></span>
                                    <p class="quiz_option_para"><?php echo $question['option4']; ?></p>
                                </label>
                                <?php if ($question['option5'] != NULL && $question['option5'] != "") { ?>
                                    <input type="radio" id="quizQuesRadio5<?php echo $quesNo; ?>" value="5" name="quizQuesRadio<?php echo $quesNo; ?>" />
                                    <label for="quizQuesRadio5<?php echo $quesNo; ?>">
                                        <span class="quiz_option_icon"></span>
                                        <p class="quiz_option_para"><?php echo $question['option5']; ?></p>
                                    </label>
                                <?php } ?>
                            </div>
                        </div>    
                    </div>
                    <input type="hidden" name="questionTime<?php echo $quesNo; ?>" id="questionTime<?php echo $quesNo; ?>" value="0" />
                    <?php
                    $quesNo++;
                }
                ?>
            </form>
        </div>
    </div>
    <div id="quiz_footer" style="display: none;">
        <div id="quiz_footer_wrapper">
            <div id="quiz_prev" onclick="prevQuestion()" style="background-color: #BBB;">PREV</div>
            <div id="quiz_question_no">
                <ul id="quiz_navlist">
                    <li class="current_ques" id="navigateNo1"
                        style="cursor: pointer;" 
                        onclick="navigateToQuestion(1)">1</li>
                        <?php for ($i = 2; $i <= $size; $i++) { ?>
                        <li id="navigateNo<?php echo $i; ?>"
                            style="cursor: pointer;" 
                            onclick="navigateToQuestion(<?php echo $i; ?>)">
                            <?php echo $i; ?></li>
                    <?php } ?>
                </ul>
            </div>
            <div id="quiz_next" onclick="nextQuestion()">NEXT</div>
        </div>
    </div>
</body>