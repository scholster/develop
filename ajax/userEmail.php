<?php
if (isset($_POST['email'])) {
    require_once '../Model/createDataBaseConnection.php';
    require_once '../Model/registerModel.php';
    require_once '../Controller/RegisterController.php';
    $userEmail = $_POST['email'];
    $registerController = new RegisterController($userEmail);
    if ($registerController->alreadyRegistered) {
        if ($registerController->fBId > 0) {
            ?>
            <div style="width: 446px; margin: auto;">
                <p>This email is registered with Facebook. Please sign in through Facebook.</p>
                <div class="facebook_login">
                    <a href="fbLogin.php"><div style="width: 100%; height: 56px;"></div></a>
                </div>
                <p>* We would never post anything on your wall</p>
            </div>
            <?php
        } else {
            ?>
            <div class="email_field">
                <div class="email_icon"></div>
                <input type="text"  id="loginEmail" class="email_txt" placeholder="you@topoftheworld.com" onkeypress="enterLogin(event)" value="<?php echo $registerController->email; ?>"/>
            </div>
            <div class="error_custom" id="email_format_signUp" style="opacity: 0;">Email Id not in correct format</div>
            <div class="pwd_field">
                <div class="pwd_icon"></div>
                <input type="password" id="loginPassword" placeholder="password" onkeypress="enterLogin(event)" class="pwd_txt" autofocus="autofocus" />
            </div>
            <div class="error_custom" id="wrong_UserPassword_signUp" style="opacity: 0;">Wrong username and password combination</div>
            <button class="sign_in_box" onclick="login();">Login</button>
            <a href="#" class="big-link" data-reveal-id="forgotPasswordBox" data-animation="fade">
                <div id="forgotPasswordBtn" class="close_btn" style="float: right; top: 230px;" onclick="">Forgot Password</div>
            </a>
            <?php
        }
    } else {
        ?>
        <h2> We swear that this is the last step!</h2>
        <div class="email_field">
            <div class="email_icon"></div>
            <input  class="email_txt" type="text" id="register_email" name="email" value="<?php echo $registerController->email; ?>" 
                    onkeyup="checkEmailExist(1)" maxlength="80"  onblur="checkEmailExist(1)" tabindex="1" />
        </div>
        <div class="error_custom" id="email_register_error" style="opacity: 0;">Email Id Already Exists</div>
        <div class="pwd_field">
            <div class="usrname_icon"></div>
            <input  class="email_txt" type="text" id="register_username" name="username" autofocus="autofocus" maxlength="20"
                    placeholder="Username" tabindex="2" onkeyup="checkEmailExist(0)" onblur="checkEmailExist(0)"  />
        </div>
        <div class="error_custom" id="username_register_error" style="opacity: 0;">Username Already Exists</div>

        <div class="pwd_field">
            <div class="pwd_icon"></div>
            <input  class="pwd_txt" type="password" id ="register_password" name="password" maxlength="20"
                    placeholder="Password" tabindex="3"  />
        </div>
        <div class="error_custom" id="password_register_error" style="opacity: 0;">Password must be 6 characters long.</div>
        <button class="sign_in_box" onclick="validateRegisterForm()">DONE</button>
        <?php
    }
} else {
    echo 'INVALID';
    exit();
}
?>