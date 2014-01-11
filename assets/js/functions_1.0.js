/* Copyright 2013 : Scholster Studios  */
function postActivity() {
    var activity = $("#postActivityBox").val();
    $.post("/ajax/postActivity.php", {
        activity: activity
    }, function(data) {
        if (data.data == 'valid') {
            $('#postActivityBox').val("");
            loadNewFeed();
        }
    }, 'json');
}

function loadNewFeed() {
    $.post("/ajax/loadNewFeed.php", {}, function(data) {
        if (data != 'INVALID') {
            $("#postActivityList").prepend(data);
        }
    });
}


function highlightDiv(paraId, i, j, type) {
    if (type == 1) {
        $("#content_para_" + i + "_" + j).attr('class', 'content_para_highlight');
    } else {
        $("#content_para_" + i + "_" + j).attr('class', 'content_para_unhighlight');
    }

    $.post("/ajax/highlightContent.php", {
        paraId: paraId,
        type: type
    }, function(data, status) {
        if (data.data == 'valid') {
            if (type == 1) {
                //                $("#highlight"+paraId).hide();
                //                $("#unhighlight"+paraId).show();
                $("#content_para_" + i + "_" + j).attr("onclick", "highlightDiv(" + paraId + "," + i + "," + j + ",0)");
            } else {
                //                $("#highlight"+paraId).show();
                //                $("#unhighlight"+paraId).hide();
                $("#content_para_" + i + "_" + j).attr("onclick", "highlightDiv(" + paraId + "," + i + "," + j + ",1)");
            }
        }
        else {
            alert("Some error occured. Please retry");
        }
    }, 'json');
}

function saveNotes(subTopicId) {
    var notes = $("#subTopicNotes").val();
    $.post("/ajax/saveNotes.php", {
        subTopicId: subTopicId,
        notes: notes
    }, function(data, status) {
        if (data.data == 'valid') {
        }
        else {
            alert("Some error occured. Please retry");
        }
    }, 'json');
}

function showAddNotes() {
    var property = $("#addNotesDiv").css('display');
    if (property == 'none') {
        $("#addNotesDiv").show(500);
        $("#addNotesSign").html("-");
    } else {
        $("#addNotesDiv").hide(500);
        $("#addNotesSign").html("+");
    }
}

function sendMessage(scrollApi, userId, src1, src2) {
    messageText = $('#messageBox').val();
    if (messageText != '') {
        $('#messageBox').val(null);
        $.post("/ajax/sendMessage.php", {
            toId: userId,
            message: messageText
        }, function(data, status) {
            loadMoreMessages(userId, src1, src2,scrollApi);
        });
    }
}

function loadMoreMessages(user, src1, src2,scrollApi) {
    $.post("/ajax/loadMoreMessages.php", {
        user: user,
        src1: src1,
        src2: src2
    }, function(data, status) {
        
        if(data !=""){
            if($("#user_chat_else").length){
                $("#user_chat_else").hide();
            }
        }
        
        if (data != "INVALID") {
            scrollApi.getContentPane().prepend(data);
            scrollApi.reinitialise();
        }
    });
}

function addtoKeychain(userId, proType) {
    $.post("/ajax/addtokeychain.php", {
        heroId: userId,
        type: proType
    }, function(data, status) {
        if (data.message == "success") {
            if (proType == 1) {
                $("#profile_add_keychain").hide();
                $("#profile_remove_keychain").show();
            //                $("#user_profile_relation").html(data.relation);
            } else {
                $("#profile_add_keychain").show();
                $("#profile_remove_keychain").hide();
            //                $("#user_profile_relation").html(data.relation);
            }
        } else {
            alert(data.message);
        }
    }, 'json');
}

function addtoKeychain2(userId) {
    $.post("/ajax/addtokeychain.php", {
        heroId: userId,
        type: 1
    }, function(data, status) {
        if (data.message == "success") {
            $("#keychain_wrap").load("/keychain/inner.php");
        }
    }, 'json');
}

function refreshBar() {
    $("#dashboard_bar").fadeTo(200, 0);
    $("#dashboard_bar").load("ajax/loadNewDashboardText.php", function() {
        $("#dashboard_bar").fadeTo(200, 1);
    });
}

var flagMessageBox = 1;
var flagAlertBox = 1;

function showMessagePopUp() {
    if (flagMessageBox == 1) {
        $("#message_pop_up").load("/ajax/loadMessageBox.php", {}, function() {
            flagMessageBox = 0;
        });
    }
    $("#message_pop_up").show();
    $("#message_pop_up_else").css('height', $(document).height());
    $("#message_pop_up_else").css('width', $(document).width());
    $("#message_pop_up_else").css('z-index', 99);
}

function showAlertPopUp() {
    if (flagAlertBox == 1) {
        $("#alert_pop_up").load("/ajax/loadAlertBox.php", {}, function() {
            flagAlertBox = 0;
        });
    }
    $("#alert_pop_up").show();
    $("#message_pop_up_else").css('height', $(document).height());
    $("#message_pop_up_else").css('width', $(document).width());
    $("#message_pop_up_else").css('z-index', 99);
    headerPooling();
}

function hideMessagePopUp() {
    $("#message_pop_up").hide();
    $("#alert_pop_up").hide();
    $("#message_pop_up_else").css('height', 0);
    $("#message_pop_up_else").css('width', 0);
    $("#message_pop_up_else").css('z-index', 0);
}

function headerPooling() {
    $.post("/ajax/headerPooling.php", {}, function(data) {
        if(data.alert==0){
            $("#alertHeader").attr("class","min_profile_circle_alert");
            $("#alertHeader").html("");
        }else{
            $("#alertHeader").attr("class","min_profile_circle");
            $("#alertHeader").html("<span style='position: relative; top: 8px;'>"+data.alert+"</span>");
        }
    }, 'json');
}

function openContentSub(){
    var property = $("#contentRing").css("display");
    if(property == 'none'){    
        $("#contentRing").show();
        $("#content_btn").css("z-index", 1002);
        $("#practice_btn").css("z-index", 999);
        $("#analytics_btn").css("z-index", 999);
        $("#doubt_btn").css("z-index", 999);
        $("#ring_outer").show();
    }else{
        closeSubMenu();
    }
}

function openPracticeSub(){
    var property = $("#practiceRing").css("display");
    if(property == 'none'){    
        $("#practiceRing").show();
        $("#content_btn").css("z-index", 999);
        $("#practice_btn").css("z-index", 1002);
        $("#analytics_btn").css("z-index", 999);
        $("#doubt_btn").css("z-index", 999);
        $("#ring_outer").show();
    }else{
        closeSubMenu();
    }
}

function openAnalyticsSub(){
    var property = $("#analyticsRing").css("display");
    if(property == 'none'){
        $("#analyticsRing").show();
        $("#content_btn").css("z-index", 999);
        $("#practice_btn").css("z-index", 999);
        $("#analytics_btn").css("z-index", 1002);
        $("#doubt_btn").css("z-index", 999);
        $("#ring_outer").show();
    }else{
        closeSubMenu();
    }
}

function closeSubMenu(){
    $("#contentRing").hide();
    $("#practiceRing").hide();
    $("#analyticsRing").hide();
    $("#ring_outer").hide();
}

function practiceOnChangeSubject(){
    var subject = $('input[name="subject"]:checked').val();
    if(subject==1){
        $("#quant_list").hide();
        $("#verbal_topic_list").show();
        $("#verbal_list").show();
        $("#quant_topic_list").hide();
    }else{
        $("#quant_list").show();
        $("#quant_topic_list").show();
        $("#verbal_list").hide();
        $("#verbal_topic_list").hide();
    }
}

function practiceOnChangeType(){
    console.log("Hello");
    var type = $('input[name="practiceType"]:checked').val();
    if(type==1){
        $("#practice_topic_list").hide();
    }else{
        $("#practice_topic_list").show();
    }
}

// contentInner

var topWrapperheight = 0;

function showInnerContent(topicNo, total) {
    var id = "#content_inner_" + topicNo;
    var property = $(id).css('display');
    hideOtherInnerContent(topicNo, total);
    if (property == 'none') {
        topWrapperheight = $(document).height();
        $(id).show(0,function(){
            var height = $(document).height();
            var intheight = parseInt(height) - 200;
            $(".top_wrapper").css("height", intheight + "px");
        });
        $("#content_dropdown_arrow_" + topicNo).attr("class", "content_dropdown_arrow_open");
        $("#content_dropdown_box_" + topicNo).css("background-color", "#8dbf6a");
        $("#content_dropdown_box_" + topicNo + " h2").css("color", "#ffffff");
    } else {
        $(id).hide(0,function(){
            var height = topWrapperheight;
            var intheight = parseInt(height) - 200;
            $(".top_wrapper").css("height", intheight + "px");
        });
        $("#content_dropdown_arrow_" + topicNo).attr("class", "content_dropdown_arrow");
        $("#content_dropdown_box_" + topicNo).css("background-color", "#f2f2f2");
        $("#content_dropdown_box_" + topicNo + " h2").css("color", "#959595");
    }
    
    var scrollTo = $("#content_dropdown_box_"+topicNo).offset().top;
    $('html,body').animate({
        scrollTop: (scrollTo - 20)
    },600);
}

function showfirstContent(){
    var topicNo = 0;
    var id = "#content_inner_" + topicNo;
    $(id).show(0,function(){
        });
    $("#content_dropdown_arrow_" + topicNo).attr("class", "content_dropdown_arrow_open");
    $("#content_dropdown_box_" + topicNo).css("background-color", "#8dbf6a");
    $("#content_dropdown_box_" + topicNo + " h2").css("color", "#ffffff");
}
            
function hideOtherInnerContent(topicNo,total){
    for(var i=0;i<total;i++){
        if(i==topicNo) continue;
        $("#content_inner_"+i).hide(0);
        $("#content_dropdown_arrow_" + i).attr("class", "content_dropdown_arrow");
        $("#content_dropdown_box_" + i).css("background-color", "#f2f2f2");
        $("#content_dropdown_box_" + i + " h2").css("color", "#959595");
    }
}


function setBeforeUnload(message){
    window.onbeforeunload = function(){
        return message;
    }
}
        
function resetBeforeUnload(){
    window.onbeforeunload = null;
}

// demo Script

var demoStepNo = 1;
var totalSteps = 6;

function openDemo(){
    $("#dashboard_demo").show();
    $("#dashboard_demo").fadeTo(500,1);
}


function startDemo(){
    $("#demo_start").fadeTo(300,0,function(){
        $("#demo_start").hide();
        $("#demo").show();
        loadDemoStep(1);
        $("#demo").fadeTo(300,1);
    });
    $("#hideIt").hide();
}

function closeDemo(){
    $("#dashboard_demo").fadeTo(500,0,function(){
        $("#dashboard_demo").hide();
    });
}

function nextDemoStep(){
    demoStepNo++;
    if(demoStepNo<=totalSteps){
        $("#demo_img").fadeTo(300,0);
        $("#demo").fadeTo(300,0,function(){
            loadDemoStep(demoStepNo);
            $("#demo").fadeTo(300,1);
            $("#demo_img").fadeTo(300,1);
        });
    }else{
        $("#demo_img").fadeTo(300,0);
        $("#demo").fadeTo(300,0,function(){
            $("#demo_end").fadeTo(300,1,function(){
                $('html,body').animate({
                    scrollTop: (0)
                },300); 
            });
        });
    }
}

function loadDemoStep(stepNo){
    switch(stepNo){
        case 1 :
            $("#demo_content_heading").html("Content");
            $("#demo_content_h3").html("Lets get you ready !!");
            $("#demo_content_heading").css("color","#8dbf6a");
            $("#demo_content_para").html("Brush up theoretical concepts before you start practicing on CAT problems.<br><br>When in doubt, scan through the organized notes, right here.");
            $("#demo").css("left","116px");
            $("#demo").css("top","169px");
            $(".demo_bg_overlay").css("position","fixed");
            $("#demo_img").attr("class","navBtn_content_demo");
            break;
            
        case 2 :
            $("#demo_content_heading").html("Practice");
            $("#demo_content_h3").html("The drill mode !!");
            $("#demo_content_heading").css("color","#cf5a63");
            $("#demo_content_para").html("20 minute tests both on Quant and Verbal sections, especially designed for your daily practice.");
            $("#demo").css("left","116px");
            $("#demo").css("top","284px");
            $(".demo_bg_overlay").css("position","fixed");
            $("#demo_img").attr("class","navBtn_practice_demo");
            break;
            
        case 3 :
            $("#demo_content_heading").html("Analytics");
            $("#demo_content_h3").html("Your performance roundup !!");
            $("#demo_content_heading").css("color","#47a0ae");
            $("#demo_content_para").html("After every practice session, queskey dynamically calculates your average time, and efficiency on various CAT Topics.");
            $("#demo").css("left","116px");
            $("#demo").css("top","366px");
            $(".demo_bg_overlay").css("position","fixed");
            $("#demo_img").attr("class","navBtn_analytics_demo");
            break;                    
            
        case 4 :
            $("#demo_content_heading").html("");
            $("#demo_content_h3").html("Content progress");
            $("#demo_content_heading").css("color","#000");
            $("#demo_content_para").html("These milestones tell you how many topics you have read in the content section.");
            $("#demo").css("left","540px");
            $("#demo").css("top","110px");
            $(".demo_bg_overlay").css("position","absolute");
            $("#demo_img").attr("class","navBtn_journey_demo");
            $('html,body').animate({
                scrollTop: (0)
            },400);
            break;
            
        case 5 :
            $("#demo_content_h3").html("Basic Analytics");
            $("#demo_content_para").html("This section sums up your overall performance, showing your vital stats such as accuracy levels and average time. ");
            $("#demo").css("left","540px");
            $("#demo").css("top","236px");
            $(".demo_bg_overlay").css("position","absolute");
            $("#demo_img").attr("class","navBtn_analytics_summary_demo");
            break;
            
        case 6 :
            $("#demo_content_h3").html("Activity Feed");
            $("#demo_content_para").html("Activity feed tells you what others are doing on the platform.");
            $("#demo").css("left","545px");
            $("#demo").css("top","508px");
            $(".demo_kink").css("left","97px");
            $(".demo_kink").css("top","99%");
            $(".demo_kink").css("background-position","15px 0px");
            $(".demo_bg_overlay").css("position","absolute");
            $("#demo_img").attr("class","navBtn_activity_demo");
            $('html,body').animate({
                scrollTop: (600)
            },400);
            break;
    }
}


// practice page

function practice_pagination_next(){
    $("#practice_step1").fadeOut(300,function(){
        $("#practice_step1").hide(0,function(){
            $("#practice_step2").show(0,function(){
                $("#practice_step2").fadeTo(300,1);
            });
        });
    });
    
}

function practice_pagination_prev(){
    $("#practice_step2").fadeOut(300,function(){
        $("#practice_step2").hide(0,function(){
            $("#practice_step1").show(0,function(){
                $("#practice_step1").fadeTo(300,1);
            });
        });
    });
    
}

function changeAnalyticsType(subject){
    var value = $("#change_analytics_type").val();
    $("#analytics_replace").load("/ajax/loadAnalyticsByType.php", {
        subject:subject ,
        type:value
    });
}


// custom quiz

//function checkCustomQuizAnswer() {
//    var quesNo = currentQuestion;
//    var quesId = $("#questionId").val();
//    var selectedVal = "-1";
//    var selected = $("#quizQuesDiv input[type='radio']:checked");
//    if (selected.length > 0) {
//        selectedVal = selected.val();
//        $("#questionAnswered" + quesNo).val(2);
//        $("#timer").hide();
//        $("#quiz_submit").hide();
//        $('input[name=quizQuesRadio' + currentQuestion + ']').attr("disabled", true);
//        $.post("/ajax/checkSubQuizAnswer.php", {
//            quesId: quesId,
//            answer: selectedVal,
//            time: time
//        }, function(data) {
//            if (data.data == 'valid') {
//                $("#userAnswer" + quesNo).html("<b>" + data.answer + data.iscorrect + "</b>");
//                $("#correctOption" + quesNo).html("<b>" + data.correctAnswer + "</b>");
//                $("#userPace" + quesNo).html("<b>" + data.time + "</b>");
//                $("#communityPace" + quesNo).html("<b>" + data.average + "</b>");
//                $("#quizSolDiv" + quesNo).show();
//                $("#prevButton").show();
//                if (currentQuestion != totalQuestions)
//                {
//                    $("#nextButton").show();
//                }
//                else {
//                    $("#goBackToIndex").show();
//                }
//                if (data.iscorrect == " (Incorrect)") {
//                    $("#userAnswer" + quesNo).css("color", "#cf5a63");
//                } else {
//                    $("#userAnswer" + quesNo).css("color", "#61983b");
//                }
//                var scrollTo = $("#quizSolDiv"+quesNo).offset().top;
//                $('.quiz_ques_container').animate({
//                    scrollTop: (scrollTo-85)
//                },400);
//            }
//            else {
//                $("#timer").show();
//                $("#quiz_submit").show();
//                $("#prevButton").hide();
//                $("#nextButton").hide();
//                $('input[name=quizQuesRadio' + currentQuestion + ']').attr("disabled", false);
//                alert("Error");
//            }
//        }, "json");
//    } else {
//        alert("Please select an answer.");
//    }
//}

//function loadCustomPracticeQuestion(topicId){
//    console.log("Hello");
//    $.post("/ajax/getCustomPracticeQuestion.php",
//    {
//       topicId:8
//    }, function(data){
//        console.log(data);
//    });
//}