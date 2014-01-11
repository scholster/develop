<div id="nav">
    <div id="nav_line"></div>
    <a href="/"><div id="queskey_logo"><img src="/assets/img/queskey_logo.png" alt="queskey" width="144" height="60" /></div></a>
    <div id="user_pic" style="background-image:url(<?php echo $userInfo['userImage']; ?>)"></div>
    <div onclick="openContentSub()" id="content_btn" style="position: relative; cursor: pointer;">
        <div id="navBtn_content"></div>
        <div id="nav_name" style="margin-left:51px; top:310px">content</div>
    </div>
    <div id="practice_btn" onclick="openPracticeSub()" style="position: relative; cursor: pointer;">
        <div id="navBtn_practice"></div>
        <div id="nav_name" style="margin-left:51px; top:401px">practice</div>
    </div>
    <div id="analytics_btn" onclick="openAnalyticsSub()" style="position: relative; cursor: pointer;">
        <div id="navBtn_analytics"></div>
        <div id="nav_name" style="margin-left:47px; top:491px">analytics</div>
    </div>

    <div id="contentRing" class="nav_ring" style="display: none;">
        <div class="ring_container" style="top:197px;left:60px;">
            <div class="ring" ></div>
            <a href="/content/Quant-DI/"><div class="quant_ring"></div></a>
            <a href="/content/Verbal/"><div class="verbal_ring"></div></a>
        </div>
    </div>
    <div id="practiceRing" class="nav_ring" style="display: none;">
        <div class="ring_container" style="top:277px;left:60px;">
            <div class="ring" ></div>
            <a href="/practice/Quant-DI/"><div class="quant_ring"></div></a>
            <a href="/practice/Verbal/"><div class="verbal_ring"></div></a>
        </div>
    </div>
    <div id="analyticsRing" class="nav_ring" style="display: none;">
        <div class="ring_container" style="top:377px;left:60px;">
            <div class="ring" ></div>
            <a href="/analytics/Quant-DI/"><div class="quant_ring"></div></a>
            <a href="/analytics/Verbal/"><div class="verbal_ring"></div></a>
        </div>
    </div>
    <div class="rings_bg" id="ring_outer" style="display: none;" onclick="closeSubMenu()"> </div>


</div>
<div id="mini_prof">
    <div id="user_name">
        <?php
        if ($userInfo['firstName'] != '' || $userInfo['lastName'] != '') {
            echo $userInfo['firstName'] . ' ' . $userInfo['lastName'];
        } else {
            echo $userInfo['username'];
        }
        ?>
    </div>
    <div id="user_college">
        <?php
        if ($userInfo['education'] != '') {
            echo $userInfo['education'];
        }
        ?>
    </div>
    <div id="user_location">
        <?php
        if ($userInfo['location'] != '') {
            echo $userInfo['location'];
        }
        ?></div>
    <div id="message_box" onclick="showMessagePopUp()" style="cursor: pointer;">
        <?php
        $message = $userObject->getNewMessage();
        if ($message != 0) {
            ?>
            <div class="min_profile_circle">
                <span style="position: relative; top: 8px;"><?php echo $message; ?></span>
            </div>
            <?php
        } else {
            ?>
            <div class="min_profile_circle_msg">
            </div>
            <?php
        }
        ?>
        <div class="min_profile_box_name">Messages</div>
    </div>
    <div id="message_pop_up" style="display:none;">
        <div id="message_pop_kink"></div>
    </div>
    <div id="alert_pop_up" style="display:none;">
        <div id="message_pop_kink" style="left: 16px;"></div>
    </div>
    <div id="message_pop_up_else" onclick="hideMessagePopUp()">

    </div>
    <div id="follow_box" onclick="showAlertPopUp()" style="cursor: pointer;">
        <?php
        $relations =  $userObject->getNewRelations();
        if ($relations != 0) {
            ?>
            <div id="alertHeader" class="min_profile_circle">
                <span style="position: relative; top: 8px;"><?php echo $relations; ?></span>
            </div>
            <?php
        } else {
            ?>
            <div class="min_profile_circle_alert" id="alertHeader">
            </div>
            <?php
        }
        ?>
        <div class="min_profile_box_name">Alert</div>
    </div>
    <div class="progress_percent" style="background-image:url(/assets/img/score_up_arrow.png)">smart Score</div>
    <div id="progBar">
        <div class="overlay"></div>
        <div class="progress" style="width: <?php echo $userObject->smartScore . "%"; ?>;"></div>
        <div class="score_bg" style="margin-left:<?php echo ($userObject->smartScore - 7.5) . "%"; ?> ; margin-top:-47px;"><?php echo $userObject->smartScore; ?></div>
    </div>

    <div style="position: absolute; right: 0px;top: -18px; color: #f08223; font-size: 11px; font-family: Century Gothic,Century_Gothic;">
        <a href="/keychain" style="padding-right: 10px; color: #f08223;">Keychain</a>
        <a href="/settings" style="padding-right: 10px; color: #f08223;">Settings</a>
        <a href="/logout.php" style="color: #f08223;">Logout</a>
    </div>
</div>