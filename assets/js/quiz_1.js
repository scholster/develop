var time = 0;
var intervalVariable;
var currentQuestion = 1;
var totalQuestions = 0;

function setTotalQuestions(t){
    totalQuestions = t;
}

function checkSubTopicQuizAnswer() {
    var quesNo = currentQuestion;
    var quesId = $("#questionId" + quesNo).val();
    var selectedVal = "-1";
    var selected = $("#quizQuesDiv" + quesNo + " input[type='radio']:checked");
    if (selected.length > 0) {
        selectedVal = selected.val();
        $("#questionAnswered" + quesNo).val(2);
        $("#timer").hide();
        $("#quiz_submit").hide();
        $('input[name=quizQuesRadio' + currentQuestion + ']').attr("disabled", true);
        $.post("/ajax/checkSubQuizAnswer.php", {
            quesId: quesId,
            answer: selectedVal,
            time: time
        }, function(data) {
            if (data.data == 'valid') {
                $("#userAnswer" + quesNo).html("<b>" + data.answer + data.iscorrect + "</b>");
                $("#correctOption" + quesNo).html("<b>" + data.correctAnswer + "</b>");
                $("#userPace" + quesNo).html("<b>" + data.time + "</b>");
                $("#communityPace" + quesNo).html("<b>" + data.average + "</b>");
                $("#quizSolDiv" + quesNo).show();
                $("#prevButton").show();
                if (currentQuestion != totalQuestions)
                {
                    $("#nextButton").show();
                }
                else {
                    $("#goBackToIndex").show();
                }
                if (data.iscorrect == " (Incorrect)") {
                    $("#userAnswer" + quesNo).css("color", "#cf5a63");
                } else {
                    $("#userAnswer" + quesNo).css("color", "#61983b");
                }
                var scrollTo = $("#quizSolDiv"+quesNo).offset().top;
                $('.quiz_ques_container').animate({
                    scrollTop: (scrollTo-85)
                },400);
            }
            else {
                $("#timer").show();
                $("#quiz_submit").show();
                $("#prevButton").hide();
                $("#nextButton").hide();
                $('input[name=quizQuesRadio' + currentQuestion + ']').attr("disabled", false);
                alert("Error");
            }
        }, "json");
    } else {
        alert("Please select an answer.");
    }
}

function checkCustomQuizAnswer() {
    var quesNo = currentQuestion;
    var quesId = $("#questionId" + quesNo).val();
    var selectedVal = "-1";
    var selected = $("#quizQuesDiv" + quesNo + " input[type='radio']:checked");
    if (selected.length > 0) {
        selectedVal = selected.val();
        $("#questionAnswered" + quesNo).val(2);
        $("#timer").hide();
        $("#quiz_submit").hide();
        $('input[name=quizQuesRadio' + currentQuestion + ']').attr("disabled", true);
        $.post("/ajax/checkCustomQuizAnswer.php", {
            quesId: quesId,
            answer: selectedVal,
            time: time
        }, function(data) {
            if (data.data == 'valid') {
                $("#userAnswer" + quesNo).html("<b>" + data.answer + data.iscorrect + "</b>");
                $("#correctOption" + quesNo).html("<b>" + data.correctAnswer + "</b>");
                $("#userPace" + quesNo).html("<b>" + data.time + "</b>");
                $("#communityPace" + quesNo).html("<b>" + data.average + "</b>");
                $("#quizSolDiv" + quesNo).show();
                $("#prevButton").show();
                if (currentQuestion != totalQuestions)
                {
                    $("#nextButton").show();
                }
                else {
                    $("#goBackToIndex").show();
                }
                if (data.iscorrect == " (Incorrect)") {
                    $("#userAnswer" + quesNo).css("color", "#cf5a63");
                } else {
                    $("#userAnswer" + quesNo).css("color", "#61983b");
                }
                var scrollTo = $("#quizSolDiv"+quesNo).offset().top;
                $('.quiz_ques_container').animate({
                    scrollTop: (scrollTo-85)
                },400);
            }
            else {
                $("#timer").show();
                $("#quiz_submit").show();
                $("#prevButton").hide();
                $("#nextButton").hide();
                $('input[name=quizQuesRadio' + currentQuestion + ']').attr("disabled", false);
                alert("Error");
            }
        }, "json");
    } else {
        alert("Please select an answer.");
    }
}

function timer() {
    time++;
    min = Math.floor(time / 60);
    sec = time % 60;
    var displayTime = min + ":" + sec;
    $("#timer").html(displayTime);
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
    startTimer();
    showTimer();
});

function showTimer() {
    var property = $("#questionAnswered" + currentQuestion).val();
    if (property == 1) {
        $("#timer").show();
        $("#quiz_submit").show();
        $("#prevButton").hide();
        $("#nextButton").hide();
        $('input[name=quizQuesRadio' + currentQuestion + ']').attr("disabled", false);
    } else {
        $("#timer").hide();
        $("#quiz_submit").hide();
        if (currentQuestion != 1)
            $("#prevButton").show();
        if (currentQuestion != totalQuestions)
            $("#nextButton").show();
        else {
            $("#nextButton").hide();
            $("#goBackToIndex").show();
        }
        $('input[name=quizQuesRadio' + currentQuestion + ']').attr("disabled", true);
    }
}

function nextQuestion() {
    if (currentQuestion < totalQuestions) {
        quesNo = currentQuestion;
        $("#quizQuesDiv" + quesNo).hide();
        $("#quizQuesDiv" + (quesNo + 1)).show();
        currentQuestion = quesNo + 1;
        stopTimer();
        showTimer();
        startTimer();
    }
}

function prevQuestion() {
    if (currentQuestion > 1) {
        quesNo = currentQuestion;
        $("#quizQuesDiv" + quesNo).hide();
        $("#quizQuesDiv" + (quesNo - 1)).show();
        currentQuestion = quesNo - 1;
        $("#nextButton").show();
        $("#goBackToIndex").hide();
    }
    if (currentQuestion == 1) {
        $("#prevButton").hide();
    }
}