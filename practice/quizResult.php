<?php
$questions = $controller->getQuestions();
$avgTime = $controller->getQuestionAvgTime();
$resultInfo = $controller->getReviewQuizResult();
?>
<div class="page_header_back"></div>
<div style="padding-top: 40px;">
<div class="quiz_score_label">Your Score</div>
<div id="quiz_result_ribbon">
    <div class="quiz_score"><?php echo $resultInfo['correct']; ?>/<?php echo $resultInfo['total']; ?></div>
</div>
<ul id="quiz_ansers">
    <?php
    $i = 1;
    if($questions)
    foreach ($questions as $question) {
        ?>
        <li class="quiz_list_question">
            <?php
            if ($question['answer'] != NULL && $question['answer'] != '') {
                if ($question['answer'] == $question['correctOption']) {
                    ?>
                    <div class="ques_right_icon"></div>
                <?php } else {
                    ?>
                    <div class="ques_wrong_icon"></div>
                    <?php
                }
            } else {
                echo '<div class="ques_notAttempted_icon"></div>';
            }
            ?>
            <div class="quiz_list_ques_no"> Q<?php echo $i; ?></div>
            <div class="quiz_list_ques_text">
                <p align="justify"><?php echo $question['question'] ?></p>
                <ul>
                    <?php
                    for ($j = 1; $j <= 4; $j++) {
                        ?>
                        <li class="quiz_ques_list_optns">
                            <?php
                            if ($question['correctOption'] == $j) {
                                echo '<div class="quiz_list_option_icon_right"></div>';
                            } elseif ($question['answer'] == $j && $question['answer'] != $question['correctOption']) {
                                echo '<div class="quiz_list_option_icon_wrong"></div>';
                            } else {
                                echo '<div class="quiz_list_option_icon_default"></div>';
                            }
                            ?>
                            <div class="quiz_list_option_name"><?php echo $question['option' . $j]; ?></div>
                        </li>
                        <?php
                    }
                    if ($question['option5'] != NULL && $question['option5'] != '') {
                        ?>
                        <li class="quiz_ques_list_optns">
                            <?php
                            if ($question['correctOption'] == 5) {
                                echo '<div class="quiz_list_option_icon_right"></div>';
                            } elseif ($question['answer'] == 5 && $question['answer'] != $question['correctOption']) {
                                echo '<div class="quiz_list_option_icon_wrong"></div>';
                            } else {
                                echo '<div class="quiz_list_option_icon_default"></div>';
                            }
                            ?>
                            <div class="quiz_list_option_name"><?php echo $question['option5']; ?></div>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
            <div class="quiz_result_right">
                <div class="queskey_btn" id="check_soln_btn" ></div>
                <div class="result_clock"></div>
                Your Pace
                <div class="result_right_no"> <?php echo $question['timeTaken'] ?></div>
                Average pace
                <div class="result_right_no"> <?php echo $avgTime[$question['id']] ?></div>
            </div>
        </li>
        <?php
        $i++;
    }
    ?>

</ul>
</div>