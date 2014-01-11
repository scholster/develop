<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <link rel="stylesheet" href="/assets/css/login.css" media="screen" />
        <!-- styles needed by jScrollPane - include in your own sites -->
        <link type="text/css" href="/assets/css/jquery.jscrollpane.css" rel="stylesheet" media="all" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>queskey</title>
        <meta property="og:title" content="queskey"/>
        <meta property="og:image" content="http://sphotos-a.ak.fbcdn.net/hphotos-ak-prn1/72671_554366534608562_503161730_n.jpg"/>
        <meta property="og:site_name" content="queskey"/>
        <meta property="og:description" content="Begin your CAT preparation."/>
        <meta property="og:type" content="website"/>
        <meta property="og:url" content="http://queskey.com"/>
        <meta name="description" content="Queskey is an online CAT preparation platform. With queskey access clean content, practice unlimited questions,  tests and get detailed analytics for free."/>
        <meta name="keywords" content="CAT,practice content,online test,free, doubt solve,MBA" />
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script> 
        <script type="text/javascript" src="/assets/js/jquery.reveal.js"></script>
        <script type="text/javascript" src="/assets/js/loginjs.js"></script>        
        <link rel="shortcut icon" href="queskey.ico" />
        <!-- the mousewheel plugin -->
        <script type="text/javascript" src="/assets/js/jquery.mousewheel.js"></script>
        <!-- the jScrollPane script -->
        <script type="text/javascript" src="/assets/js/jquery.jscrollpane.min.js"></script>
        <!-- scripts specific to this demo site -->
    </head>
    <body>
        <?php include_once 'google/analytics.php';?>
        <?php include_once 'include/loginHeader.php'; ?>
        <div class="wrapper" id="highlight">
            <div class="intro_line">
                <p>Begin Your</p>
                <div class="cat_highlight">CAT</div>
                <p>preparation online, for Free</p>
            </div>
            <div class="cat_desc"><span style="color: #f08223;">queskey</span> gives you everything that you to need to be better prepared for the CAT.</div>
            <div class="start_button">
                <a href="#" class="big-link" data-reveal-id="sign_up" data-animation="fade"  style="color:#ffffff;">
                    <div style="height: 54px; width: 100%">
                        <div style="padding-top:9px;">Start Preparing</div>
                    </div>
                </a>
            </div>
            <div id="queskey_icon_big_wrapper">
                <div id="queskey_icon_big"></div>
            </div>
        </div>
        <div class="grey_border"></div>
        <div class="grey_body"></div>
        <div class="wrapper" id="features">
            <div class="icon_line"></div>
            <div class="img_white_bg"></div>
            <div class="img_mask_cont">
                <div class="mask_top"></div>
                <div class="img_mask"></div>
                <div class="mask_bottom"></div>
            </div>
            <div id="ftr_content">
                <div class="ftr_content_img"><img src="/assets/img/ftr_content.jpg" /></div>
                <div class="ftr_text">
                    <h2>STRUCTURED CONTENT</h2>
                    <h3>Get a run through of the most relevant CAT concepts, before you start practicing on problems.</h3>
                </div>
                <div id="ftr_icon"><img src="/assets/img/ftr_content_icon.png" /></div>
            </div>
            <div id="ftr_content">
                <div class="ftr_content_img"><img src="/assets/img/ftr_quiz.jpg" /></div>
                <div class="ftr_text">
                    <h2>PRACTICE QUIZZES</h2>
                    <h3>Get access to scientifically designed practice sessions and see yourself improve every day.</h3>
                </div>
                <div id="ftr_icon"><img src="/assets/img/ftr_quiz_icon.png" /></div>
            </div>
            <div id="ftr_content">
                <div class="ftr_content_img"><img src="/assets/img/ftr_analytics.jpg" /></div>
                <div class="ftr_text">
                    <h2>TRACK PERFORMANCE</h2>
                    <h3>Get updated on your performance ,  act on your weak areas and see your curve go up.</h3>
                </div>
                <div id="ftr_icon"><img src="/assets/img/ftr_analytics_icon.png" /></div>
            </div>
            <!--            <div id="ftr_content_end" >
                            <div class="ftr_content_img"><img src="/assets/img/ftr_p2p.jpg" /></div>
                            <div class="ftr_text">
                                <h2>GET DOUBTS SOLVED</h2>
                                <h3>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</h3>
                            </div>
                            <div id="ftr_icon"><img src="/assets/img/ftr_p2p_icon.png" /></div>
                        </div>-->
            <div class="line_end"></div>
            <div class="experience">
                <div class="exp_left">
                    <h1>Learn the beautiful way</h1>
                    <p>Prepare on a user-friendly and interactive learning system that is especially designed to enhance your overall learning experience.</p>
                    <div class="start_button" style="float:left">
                        <a href="#" class="big-link" data-reveal-id="sign_up" data-animation="fade"  style="color:#ffffff;">
                            <div style="height: 54px; width: 100%">
                                <div style="padding-top:9px;">Start Preparing</div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="canvas"></div>
            </div>
        </div>
        <div class="feedback">
            <div class="wrapper">
                <div class="feedback_thumb">feedback</div>
                <div class="feedback_border">
                    <textarea class="feedback_txt" maxlength="160" id="feedback_txt" onkeydown="feedBackChange()" placeholder="Post your feedback" onfocus="$('#feedback_submit').show();"></textarea>
                    <div id="feedback_error" class="feedback_response"></div>
                    <input type="button" class="feedback_btn" value="Post" id="feedback_submit" onclick="submitFeedBack()"/>
                </div>
            </div>
        </div>
        <!--        <div class="yearbook" style="display: none;">
                    <div class="wrapper">
                        <div class="yearbook_banner"></div>
                        <div class="team">
                            <div class="team_member">
                                <div class="team_pic" style="background-image:url(/assets/img/team_pic.jpg); background-position:-35px 0"></div>
                                <h1>Hitten Dubey</h1>
                                <h2>#Product Design</h2>
                            </div>
                            <div class="team_member">
                                <div class="team_pic" style="background-image:url(/assets/img/team_pic.jpg); background-position:-35px 0"></div>
                                <h1>Hitten Dubey</h1>
                                <h2>#Product Design</h2>
                            </div>
                            <div class="team_member">
                                <div class="team_pic" style="background-image:url(/assets/img/team_pic.jpg); background-position:-35px 0"></div>
                                <h1>Hitten Dubey</h1>
                                <h2>#Product Design</h2>
                            </div>
                            <div class="team_member">
                                <div class="team_pic" style="background-image:url(/assets/img/team_pic.jpg); background-position:-35px 0"></div>
                                <h1>Hitten Dubey</h1>
                                <h2>#Product Design</h2>
                            </div>
                        </div>
                    </div>
                </div>-->

        <?php
        require_once 'include/loginFooter.php';
        ?>
    </body>
</html>