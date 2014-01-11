
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

function sendMessage(scrollApi,event, userId, src1, src2) {
    if (event.keyCode == 13 && !event.shiftKey) {
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
}

function loadMoreMessages(user, src1, src2,scrollApi) {
    $.post("/ajax/loadMoreMessages.php", {
        user: user,
        src1: src1,
        src2: src2
    }, function(data, status) {
        if (data != "INVALID") {
            scrollApi.getContentPane().prepend(data);
            scrollApi.reinitialise();
            //            $("#message_thread").prepend(data);
            
            console.log("Hello");
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
        }else{
            $("#alertHeader").attr("class","min_profile_circle");
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
    $subject = $("#subject_dropdown").val();
    if($subject==1){
        $("#quant_list").show();
        $("#verbal_list").hide();
    }else{
        $("#quant_list").hide();
        $("#verbal_list").show();
    }
}

// contentInner

function showInnerContent(topicNo, total) {
    var id = "#content_inner_" + topicNo;
    var property = $(id).css('display');
    hideOtherInnerContent(topicNo, total);
    if (property == 'none') {
        $(id).show(0,function(){
            });
        $("#content_dropdown_arrow_" + topicNo).attr("class", "content_dropdown_arrow_open");
        $("#content_dropdown_box_" + topicNo).css("background-color", "#8dbf6a");
        $("#content_dropdown_box_" + topicNo + " h2").css("color", "#ffffff");
    } else {
        $(id).hide(0);
        $("#content_dropdown_arrow_" + topicNo).attr("class", "content_dropdown_arrow");
        $("#content_dropdown_box_" + topicNo).css("background-color", "#f2f2f2");
        $("#content_dropdown_box_" + topicNo + " h2").css("color", "#959595");
    }
    
    var scrollTo = $("#content_dropdown_box_"+topicNo).offset().top
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
var totalSteps = 7;

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
}

function closeDemo(){
    $("#dashboard_demo").fadeTo(500,0,function(){
        $("#dashboard_demo").hide();
    });
}

function nextDemoStep(){
    demoStepNo++;
    if(demoStepNo<=totalSteps){
        $("#demo").fadeTo(300,0,function(){
            loadDemoStep(demoStepNo);
            $("#demo").fadeTo(300,1);
        });
    }else{
        closeDemo();
    }
}

function loadDemoStep(stepNo){
    switch(stepNo){
        case 1 :
            $("#demo_content_heading").html("Content");
            $("#demo_content_para").html("Content para Content para Content para Content para Content para Content para Content para Content para");
            $("#demo").css("left","116px");
            $("#demo").css("top","213px");
            $(".demo_bg_overlay").css("position","fixed");
            break;
            
        case 2 :
            $("#demo_content_heading").html("Practice");
            $("#demo_content_para").html("Practice para Practice para Practice para Practice para Practice para Practice para Practice para Practice para");
            $("#demo").css("left","116px");
            $("#demo").css("top","303px");
            $(".demo_bg_overlay").css("position","fixed");
            break;
            
        case 3 :
            $("#demo_content_heading").html("Analytics");
            $("#demo_content_para").html("Practice para Practice para Practice para Practice para Practice para Practice para Practice para Practice para");
            $("#demo").css("left","116px");
            $("#demo").css("top","393px");
            $(".demo_bg_overlay").css("position","fixed");
            break;
            
        case 4 :
            $("#demo_content_heading").html("Doubt");
            $("#demo_content_para").html("Practice para Practice para Practice para Practice para Practice para Practice para Practice para Practice para");
            $("#demo").css("left","116px");
            $("#demo").css("top","483px");
            $(".demo_bg_overlay").css("position","fixed");
            break;
            
        case 5 :
            $("#demo_content_heading").html("Lesson Journey");
            $("#demo_content_para").html("Practice para Practice para Practice para Practice para Practice para Practice para Practice para Practice para");
            $("#demo").css("left","540px");
            $("#demo").css("top","111px");
            $(".demo_bg_overlay").css("position","absolute");
            break;
            
        case 6 :
            $("#demo_content_heading").html("Basic Analytics");
            $("#demo_content_para").html("Practice para Practice para Practice para Practice para Practice para Practice para Practice para Practice para");
            $("#demo").css("left","540px");
            $("#demo").css("top","233px");
            $(".demo_bg_overlay").css("position","absolute");
            break;
            
        case 7 :
            $("#demo_content_heading").html("User Activity");
            $("#demo_content_para").html("Practice para Practice para Practice para Practice para Practice para Practice para Practice para Practice para");
            $("#demo").css("left","570px");
            $("#demo").css("top","651px");
            $(".demo_bg_overlay").css("position","absolute");
            $('html,body').animate({
                scrollTop: (660)
            },400);
            break;
            
            
            
    }
}