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
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="shortcut icon" href="queskey.ico" />
        <title>queskey | Contact Us</title>
        <script type='text/javascript' src='http://code.jquery.com/jquery-1.7.js'></script>
        <script type="text/javascript" src="assets/js/jquery.reveal.js"></script>
        <script type="text/javascript" src="assets/js/loginjs.js"></script>
    </head>

    <body>
        <?php require_once 'include/loginHeader.php'; ?>
        <div class="wrapper" id="highlight" >
            <div class="opening_inner" style="width:1010px">
                <div class="opening_inner_head" style="width:997px">Contact Us</div>
                <p style="text-align:center; margin-top:40px; width:100% "><br />
                    <br />
                    <br />
                    <span style="font-size:46px; font-family:Century Gothic,Century_Gothic; color:#666 "> For all the chit-chat:</span><br /><br />
                    <span style="font-size:36px; font-family:Century Gothic,Century_Gothic_Bold; color:#444 ">team@queskey.com</span>
            </div>
        </div>
        <?php require_once 'include/loginFooter.php'; ?>
    </body>
</html>