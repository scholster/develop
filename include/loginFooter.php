<div class="footer">
    <div class="wrapper">
        <div style="float:left"><p>© 2013 Scholster Studios</p></div><ul class="footer_right">
            <a href="http://www.facebook.com/onqueskey"><li class="social_fb" style="margin-left:10px;"></li></a>
            <a href="http://www.twitter.com/Queskey"><li class="social_twitter" style="margin-left:10px;"></li></a>
        </ul>
        <ul class="footer_right">
            <a href="/about" style="color: #b2b2b2;"><li class="footer_def">About </li></a>
            <a href="/contact" style="color: #b2b2b2;"><li>Contact</li></a>
            <a href="/disclaimer" style="color: #b2b2b2;"><li >Disclaimer</li></a></ul>
    </div>
</div>
<div class="love">Made with<img src="/assets/img/heart.png" />in New Delhi</div>


<?php
if (!$login->loggedIn) {
    ?>
    <div id="sign_in" class="login_box">
        <div class="login_box_inner">
            <div class="close_btn"><div class="close_btn_style"></div></div>
            <div class="facebook_login">
                <a href="/fbLogin.php"><div style="width: 100%; height: 56px;"></div></a>
            </div>
            <p class="dino"><span>or, the dinosaur`s way</span></p>
            <div class="email_field">
                <div class="email_icon"></div>
                <input type="text"  id="login_email" class="email_txt" onkeypress="enterLogin2(event)" placeholder="you@topoftheworld.com"/>
            </div>
            <div class="error_custom" id="email_format_login" style="opacity: 0;">Email Id not in correct format</div>
            <div class="pwd_field">
                <div class="pwd_icon"></div>
                <input type="password" id="login_password" placeholder="password" onkeypress="enterLogin2(event)" class="pwd_txt" />
            </div>
            <div class="error_custom" id="wrong_UserPassword" style="opacity: 0;">Wrong username and password combination</div>
            <button class="sign_in_box" onclick="login2()">Login</button>
            <a href="#" class="big-link" data-reveal-id="forgotPasswordBox" data-animation="fade">
                <div id="forgotPasswordBtn" class="close_btn" style="float: right;" onclick="">Forgot Password</div>
            </a>
        </div>
    </div>

    <div id="sign_up" class="login_box">
        <div class="login_box_inner">
            <div class="close_btn"><div class="close_btn_style"></div></div>
            <div id="registerReplace">
                <div class="facebook_register">
                    <a href="/fbLogin.php"><div style="width: 100%; height: 56px;"></div></a>
                </div>
                <p>* We would never post anything on your wall</p>
                <p class="dino"><span>or, the dinosaur`s way</span></p>
                <div class="email_field">
                    <div class="email_icon"></div>
                    <input type="text" class="email_txt" id="emailId" name="emailId" onkeypress="registerEmail(event)" placeholder="you@topoftheworld.com" />
                </div>
                <div class="error_custom" style="opacity: 0;" id="email_format">Email Id not in correct format.</div>
                <button class="sign_in_box" onclick="checkEmail();">Signup</button>
            </div>
        </div>
    </div>

    <div id="forgotPasswordBox" class="login_box">
        <div class="login_box_inner">
            <div class="close_btn"><div class="close_btn_style"></div></div>
            <div id="forgotPasswordInner1" style="padding-top: 50px;">
                <h2> Please enter your Email Id.</h2>
                <div class="email_field">
                    <div class="email_icon"></div>
                    <input type="text" class="email_txt" id="fp_email" placeholder="you@topoftheworld.com" />
                </div>
                <div class="error_custom" id="forgotPasswordError"></div>
                <button class="sign_in_box" onclick="forgotPasswordGo();">Submit</button>
            </div>
            <div id="forgotPasswordInner2" style="padding-top: 50px; display: none;">
                <form action="/resetPassword" method="get">
                    <h2> Please enter the code sent to your email address.</h2>
                    <input type="hidden" id="forgotPassword_u" name="u"/>
                    <div class="email_field">
                        <div class="pwd_icon"></div>
                        <input type="text" class="email_txt" id="forgotPassword_n" name="n" placeholder="XXXXXX" maxlength="6" />
                    </div>
                    <button class="sign_in_box" type="submit">Submit</button>
            </div>
        </div>
    </div>  
    <?php
}
?>