<!-- styles needed by jScrollPane - include in your own sites -->
<link type="text/css" href="/assets/css/jquery.jscrollpane.css" rel="stylesheet" media="all" />

<!-- the mousewheel plugin -->
<script type="text/javascript" src="/assets/js/jquery.mousewheel.js"></script>
<!-- the jScrollPane script -->
<script type="text/javascript" src="/assets/js/jquery.jscrollpane.min.js"></script>
<!-- scripts specific to this demo site -->

<div id="nav">
    <div id="nav_line"></div>
    <a href="/"><div id="queskey_logo"><img src="/assets/img/queskey_logo.png" alt="queskey" /></div></a>
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
    <div class="quiz_footer"><p><span style="color:#999">© 2013 Scholster Studios</span><br /><a>Disclaimer</a></p></div>

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