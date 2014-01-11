<?php
require_once 'Model/createDataBaseConnection.php';
require_once 'Model/LoginModel.php';
require_once 'Controller/LoginController.php';


$login = new LoginController();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <link rel="stylesheet" href="/assets/css/login.css" media="screen" />
        <link rel="shortcut icon" href="queskey.ico" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>queskey | About Us</title>
        <script type='text/javascript' src='http://code.jquery.com/jquery-1.7.js'></script>
        <script type="text/javascript" src="assets/js/jquery.reveal.js"></script>
        <script type="text/javascript" src="assets/js/loginjs.js"></script>
    </head>

    <body>
        <?php require_once 'include/loginHeader.php'; ?>
        <div class="wrapper" id="highlight">
            <div class="opening_inner">
                <div class="opening_inner_head">About queskey</div>
                <p style="padding: 50px;
text-align: justify;
float: left;
font-family: Century Gothic,Century_Gothic;
font-size: 17px;">
We are rethinking test preparation.<br/> <br/>

Having been through the process ourselves we realized that preparing for a test is as much a collaborative process as it is about individual focus. <br/><br/>
We decided to take the best from traditional coaching and social platforms to build a product. A social, collaborative test preparation platform driven by adaptive algorithms. After many days of hard work, Queskey was born.
<br/><br/>In India we see a huge opportunity in online test preparation. Our team is committed to our goal - To help our users successfully prepare for tests from anywhere.
</p>
                <div class="team" style="margin-top:-10px;">
                    <div class="team_member" style="width:805px ; height:170px">
                        <div class="team_pic_inner" style="background-image:url(/assets/img/team_pic_jas.jpg);  background-position:-75px -29px; width:132px;height:132px "></div>
                        <div class="team_info">
                            <h1>Jas Karan Singh</h1>
                            <h2 style="">#cofounder&nbsp; #Product</h2>
                        </div>
                        <a href="https://twitter.com/@Jaskaran_w" target="_blank"><div class="team_contact_button">@Jaskaran_w</div></a>
                    </div>

                    <div class="team_member" style="width:805px ; height:170px">
                        <div class="team_pic_inner" style="background-image:url(/assets/img/team_pic_tapan.jpg);  background-position:-84px -24px; width:132px;height:132px "></div>
                        <div class="team_info">
                            <h1>Tapan Babbar</h1>
                            <h2 style="">#cofounder&nbsp; #UIDesign</h2>
                        </div>
                        <a href="https://twitter.com/@tapanbabbar" target="_blank"><div class="team_contact_button">@tapanbabbar</div></a>
                    </div>
                    <div class="team_member" style="width:805px ; height:170px; padding-bottom:30px">
                        <div class="team_pic_inner" style="background-image:url(/assets/img/team_pic_ritesh.jpg);  background-position:-82px -30px; width:132px;height:132px "></div>
                        <div class="team_info">
                            <h1>Ritesh Arora</h1>
                            <h2 style="">#cofounder&nbsp; #SystemDesign</h2>
                        </div>
                        <div class="team_contact_button">@ritesharora</div>
                    </div>
                    <div class="team_member" style="width:805px ; height:170px">
                        <div class="team_pic_inner" style="background-image:url(/assets/img/team_pic_hitten.jpg);  background-position:-75px 0; width:132px;height:132px "></div>
                        <div class="team_info">
                            <h1>Hitten Dubey</h1>
                            <h2 style="">#cofounder&nbsp; #Content</h2>
                        </div>
                        <a href="https://twitter.com/@hitten101" target="_blank"><div class="team_contact_button">@hitten101</div></a>
                    </div>

                </div>
            </div>
            <div class="contact_opeing">
                <h3>Contact Us</h3>
                <hr width="193" height="2"  />
                <p >For all the chit-chat
                    <strong>team@queskey.com</strong></p>
            </div>
        </div>
        <?php require_once 'include/loginFooter.php'; ?>
    </body>
</html>