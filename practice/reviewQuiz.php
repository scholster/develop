<?php
$controller = new QuizController($_GET['quizId']);

if (!$controller->getReviewQuizInfo()) {
    include_once '../notfound.html';
    exit();
}

if (!$controller->checkReviewQuizUserStatus()) {
    include 'quizResult.php';
    exit();
}

$_SESSION['quiz' . $controller->quizId] = time();
$questions = $controller->getQuestions();
$controller->createReviewQuizActivity();
$size = count($questions);
$quesNo = 1;
?>
<script>
    var time = 0;
    var intervalVariable;
    var currentQuestion = 1;
    var previousTime = 0;
    var totalQuestions = <?php echo $size; ?>;
    
    function timer(){
        time++;
        min = Math.floor(time/60);
        sec = time%60;
        var displayTime = min+":"+sec;
        $("#timer").html(displayTime);
    }
    
    function startTimer(){
        time = 0;
        intervalVariable = setInterval(function(){
            timer();
        },1000);
    }
    
    function stopTimer(){
        clearInterval(intervalVariable);     
    }
    
    $(window).bind("load", function() {
        startTimer();
    });
    
    function nextQuestion(){
        quesNo = currentQuestion;
        if(quesNo<totalQuestions){
            changeNavClass();
            $("#quizQuesDiv"+quesNo).hide();
            $("#quizQuesDiv"+(quesNo+1)).show();
            currentQuestion = quesNo+1;
            questionTime = parseInt($("#questionTime"+quesNo).val());
            questionTime = questionTime + (time - previousTime);
            $("#questionTime"+quesNo).val(questionTime);
            previousTime = time;
        }
    }
    
    function prevQuestion(){
        quesNo = currentQuestion;
        if(quesNo>1){
            changeNavClass();
            $("#quizQuesDiv"+quesNo).hide();
            $("#quizQuesDiv"+(quesNo-1)).show();
            currentQuestion = quesNo-1;
            questionTime = parseInt($("#questionTime"+quesNo).val());
            questionTime = questionTime + (time - previousTime);
            $("#questionTime"+quesNo).val(questionTime);
            previousTime = time;
        }
    }
    
    function changeNavClass(){
        var selected = $("#quizQuesDiv"+currentQuestion+" input[type='radio']:checked");
        if (selected.length > 0){
            $("#navigateNo"+currentQuestion).attr("class","attempted");
        }
    }
    
    function navigateToQuestion(quesNo){
        if(0<quesNo&&quesNo<=totalQuestions){
            changeNavClass();
            $("#quizQuesDiv"+currentQuestion).hide();
            $("#quizQuesDiv"+quesNo).show();
            questionTime = parseInt($("#questionTime"+currentQuestion).val());
            questionTime = questionTime + (time - previousTime);
            $("#questionTime"+currentQuestion).val(questionTime);
            previousTime = time;
            currentQuestion = quesNo;
        }
    }
    
    function beforeSubmit(){
        questionTime = parseInt($("#questionTime"+currentQuestion).val());
        questionTime = questionTime + (time - previousTime);
        $("#questionTime"+currentQuestion).val(questionTime);
        previousTime = time;
        return true;
    }
    
</script>

<div class="page_header_back"><div id="timer" style="width: 100%; text-align: right;">0:0</div></div>
<form action="/action/checkReviewQuiz.php" method="POST" onsubmit="beforeSubmit()">
    <input type="hidden" name="quizId" value="<?php echo $controller->quizId; ?>"/>
    <?php
    if($questions)
    foreach ($questions as $question) {
        ?>
        <input type="hidden" name="questionId<?php echo $quesNo; ?>" value="<?php echo $question['id'] ?>"/>
        <div id="quizQuesDiv<?php echo $quesNo ?>" style="height:100%; <?php
    if ($quesNo != 1) {
        echo 'display:none';
    }
        ?>">
            <div id="ques_question" style="
            <?php
            if ($question['text'] == NULL || $question['text'] == '') {
                echo 'width:0px;';
            }
            ?>
                 "><br/>
                <br />
                <p align="justify"><?php echo $question['text']; ?></p>
            </div>
            <div id="quiz_ques_options" 
            <?php
            if ($question['text'] == NULL || $question['text'] == '') {
                echo 'style="width:760px;"';
            }
            ?>
                 >
                <p>
                    <?php echo $question['question']; ?>
                </p>
                <br>
                <br>
                <input type="radio" id="quizQuesRadio1<?php echo $quesNo; ?>" value="1" name="quizQuesRadio<?php echo $quesNo; ?>" />
                <label for="quizQuesRadio1<?php echo $quesNo; ?>">
                    <span></span>
                    <p class="quiz_options"><?php echo $question['option1']; ?></p>
                </label>
                <br/>
                <br/>
                <input type="radio" id="quizQuesRadio2<?php echo $quesNo; ?>" value="2" name="quizQuesRadio<?php echo $quesNo; ?>" />
                <label for="quizQuesRadio2<?php echo $quesNo; ?>">
                    <span></span>
                    <p class="quiz_options"><?php echo $question['option2']; ?></p>
                </label>
                <br/>
                <br/>
                <input type="radio" id="quizQuesRadio3<?php echo $quesNo; ?>" value="3" name="quizQuesRadio<?php echo $quesNo; ?>" />
                <label for="quizQuesRadio3<?php echo $quesNo; ?>">
                    <span></span>
                    <p class="quiz_options"><?php echo $question['option3']; ?></p>
                </label>
                <br/>
                <br/>
                <input type="radio" id="quizQuesRadio4<?php echo $quesNo; ?>" value="4" name="quizQuesRadio<?php echo $quesNo; ?>" />
                <label for="quizQuesRadio4<?php echo $quesNo; ?>">
                    <span></span>
                    <p class="quiz_options"><?php echo $question['option4']; ?></p>
                </label>
                <?php if ($question['option5'] != NULL && $question['option5'] != "") { ?>
                    <br/>
                    <br/>
                    <input type="radio" id="quizQuesRadio5<?php echo $quesNo; ?>" value="5" name="quizQuesRadio<?php echo $quesNo; ?>" />
                    <label for="quizQuesRadio5<?php echo $quesNo; ?>">
                        <span></span>
                        <p class="quiz_options"><?php echo $question['option5']; ?></p>
                    </label>
                <?php } ?>
            </div>
        </div>
        <input type="hidden" name="questionTime<?php echo $quesNo; ?>" id="questionTime<?php echo $quesNo; ?>" value="0" />
        <?php
        $quesNo++;
    }
    ?>
    <div id="quiz_footer" style="float: left;">
        <input class="quiz_prev" id="prev_button" type="button" value="PREV" onclick="prevQuestion()"/>
        <div id="quiz_question_no">
            <ul id="quiz_navlist">
                <?php for ($i = 1; $i <= $size; $i++) { ?>
                    <li id="navigateNo<?php echo $i; ?>"
                        style="cursor: pointer;" 
                        onclick="navigateToQuestion(<?php echo $i; ?>)">
                        <?php echo $i; ?></li>
                <?php } ?>
            </ul>
        </div>
        <input class="quiz_next" id="next_button" type="button" value="NEXT Question" onclick="nextQuestion()" />
    </div>
    <input type="submit" value="Submit Test"/>
</form>