<div id="nav">
    <div id="nav_line"></div>
    <div id="queskey_logo"><img src="img/queskey_logo.png" alt="queskey" /></div>
    <div id="user_pic" style="background-image:url(<?php echo $userInfo['userImage']; ?>)"></div>
    <div id="navBtn_content"></div>
    <div id="navBtn_practice"></div>
    <div id="navBtn_analytics"></div>
    <div id="navBtn_doubt"></div>
</div>
<div id="quiz_content2">
    <div id="mini_prof_quiz">
        <div id="user_name_quiz">
            <?php
            if ($userInfo['firstName'] != '' || $userInfo['lastName'] != '') {
                echo $userInfo['firstName'] . ' ' . $userInfo['lastName'];
            } else {
                echo $userInfo['username'];
            }
            ?>
        </div>
    </div>
</div>