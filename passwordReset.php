<?php
$message = NULL;
if (isset($_GET['u']) && isset($_GET['n']) && is_numeric($_GET['u']) && is_numeric($_GET['n']) && strlen($_GET['n']) == 6) {
    include_once 'Model/createDataBaseConnection.php';

    $userId = $_GET['u'];
    
    if(isset($_SESSION['userId'])){
        $message = "Please <a href='/logout.php'>Logout</a> to view this page.";
    }

    $result = mysql_query("SELECT random1,time FROM user_forgotPasswords WHERE `userId` = '$userId'");
    $row = mysql_fetch_array($result);
    if ($row) {
        $code = $_GET['n'];
        $time = time();
        if ($time - strtotime($row[1]) < 86400 && $code == $row[0]) {
            $_SESSION['passwordChange'] = $userId;
        } else {
            $message = "Invalid code. Please Check your email.";
        }
    } else {
        $message = "Invalid link. Please Check.";
    }
} else {
    include_once 'notfound.html';
    exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <link rel="stylesheet" href="/assets/css/login.css" media="screen" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>queskey</title>
        <script type='text/javascript' src='http://code.jquery.com/jquery-1.7.js'></script>
        <script type="text/javascript" src="/assets/js/jquery.reveal.js"></script>
        <script type="text/javascript" src="/assets/js/loginjs.js"></script>
        <meta property="og:title" content="queskey"/>
        <meta property="og:image" content="http://sphotos-a.ak.fbcdn.net/hphotos-ak-prn1/72671_554366534608562_503161730_n.jpg"/>
        <meta property="og:site_name" content="queskey"/>
        <meta property="og:description" content="Begin your CAT preparation."/>
        <meta property="og:type" content="website"/>
        <meta property="og:url" content="http://queskey.com"/>
        <link rel="shortcut icon" href="queskey.ico" />
    </head>

    <body>
        <?php include_once 'include/loginHeader.php'; ?>
        <div class="wrapper" id="highlight">
            <div class="forgot_pwd_box">
                <div id="replace">
                    <?php
                    if ($message == NULL) {
                        ?>
                        <div class="email_field" style="text-align:center; color:#939393; font-family:Century Gothic Bold,Century_Gothic_Bold; line-height:100px">Please enter your New password</div>

                        <div class="email_field">
                            <div style="float:left; line-height:55px; color:#939393; font-family:Candara,Candara_Reg; width:200px; text-align:right">New Password</div>
                            <input type="password" id="newPassword"  class="email_txt" />
                        </div>
                        <div class="email_field" style="margin-top:20px">
                            <div style="float:left; line-height:55px; color:#939393; font-family:Candara,Candara_Reg; width:200px;text-align:right">Confirm New Password</div>
                            <input type="password"  id="confirmPassword" class="email_txt" >
                        </div>
                        <div id="errorDiv" style="height: 20px; width: 100%;"></div>
                        <button type="button" id="reset_Pass_btn" onclick="changepassword();">Reset Password</button>
                        <?php
                    } else {
                        ?>
                        <div class="email_field" style="text-align:center; color:#939393; font-family:Century Gothic Bold,Century_Gothic_Bold; line-height:100px">
                            <?php echo $message; ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php include_once 'include/loginFooter.php'; ?>
    </body>
</html>