<?php
require_once '../Model/createDataBaseConnection.php';

require_once '../Model/LoginModel.php';
require_once '../Controller/LoginController.php';

require_once '../Model/UserDetailsModel.php';
require_once '../Controller/UserDetailsController.php';

require_once '../Model/MessageModel.php';
require_once '../Controller/MessageController.php';

require_once '../Model/AnalyticsModel.php';
require_once '../Controller/AnalyticsController.php';

require_once '../Util/DateTime.php';

$login = new LoginController();

if (!$login->loggedIn) {
    $_SESSION['naviageTo'] = $_SERVER[REQUEST_URI];
    include_once '../login.php';
    exit();
}

$userObject = new UserDetailsController($_SESSION['userId']);
$userInfo = $userObject->info;

$messageObject = new MessageController();
$messages = $messageObject->getSenders();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php include_once '../include/headInclude.php'; ?>
        <title>queskey</title>
        <script src="http://code.jquery.com/jquery-latest.min.js"></script>
        <script>
            $(document).ready(function() {
                var height = $(document).height();
                var intheight = parseInt(height)-200;
                $(".top_wrapper").css("height",intheight+"px");
            });
        </script>
    </head>

    <body>
        <div id="body_wrapper">
            <div id="headerAndNav">
                <?php include_once '../include/header.php'; ?>
            </div>
            <div class="inner_wrapper">
                <div class="top_wrapper">
                    <div class="page_header_back"><div class="page_header_back_text">Messages</div></div>
                    <ul id="inner_message_List">
                        <?php
                        if ($messages){
                            foreach ($messages as $message) {
                                ?>
                                <a href="/user/<?php echo $message['from'] ?>">
                                    <li <?php
                        if ($message['status'] == '0' && $message['flag'] == 1) {
                            echo "style='background-color:#FFF0CD;'";
                        }
                                ?>>
                                        <div class="inner_message_Left"> <img class="other_user_image" src="<?php echo $message['img']; ?>"/>
                                            <div style="float: left;background-color: inherit;">
                                                <div class="inner_message_sender"><?php echo $message['name']; ?></div>
                                                <div class="inner_message_text "> 
                                                    <?php if ($message['flag'] == 0) { ?>
                                                        <div style="float: left; height: 16px; width: 16px; background: url(/assets/img/sent_arrow.png) no-repeat 0 0;"></div>
                                                    <?php } ?>
                                                    <p><?php echo $message['messagetext']; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="inner_message_Right">
                                            <div id="inner_message_Time" ><?php echo agoIndia($message['time'], time()); ?></div>
                                        </div>
                                    </li>
                                </a>
                                <?php
                            }
                            
                            }else{
                                                        echo '<div style="width: 100%;height: 47px;background-color: #f2f2f2;margin-top: 30px;padding-top: 24px;font-size: 18px;color: #666;text-align: center;">You have no Message</div>';
                            }
                        ?>
                    </ul>
                </div>
                <?php include_once '../include/footer.php'; ?>
            </div>
        </div>
    </body>
</html>