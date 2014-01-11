<?php
require_once '../Model/createDataBaseConnection.php';

require_once '../Model/LoginModel.php';
require_once '../Controller/LoginController.php';

require_once '../Model/UserDetailsModel.php';
require_once '../Controller/UserDetailsController.php';

require_once '../Model/KeyChainModel.php';
require_once '../Controller/KeyChainController.php';

require_once '../Model/AnalyticsModel.php';
require_once '../Controller/AnalyticsController.php';

$login = new LoginController();

if (!$login->loggedIn) {
    $_SESSION['naviageTo'] = $_SERVER[REQUEST_URI];
    include_once '../login.php';
    exit();
}

$userObject = new UserDetailsController($_SESSION['userId']);
$userInfo = $userObject->info;

$keyChainObject = new KeyChainController($_SESSION['userId']);
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
                <div id="keychain_wrap" class="top_wrapper">
                    <div class="page_header_back" ><div class="page_header_back_text">Keychain</div></div>
                    <?php
                    $i = 1;
                    if ($keyChainObject->follower) {
                        ?>
                        <h3>
                            New Request
                        </h3>
                        <?php
                        foreach ($keyChainObject->follower as $followers) {
                            ?>
                            <div class="keychain_user_container" <?php if ($i % 2 == 0) echo 'style="margin-left:17px;"'; ?>>
                                <div class="keychain_left"> <a href="/user/<?php echo $followers['id']; ?>"><img class="other_user_image" src="<?php echo $followers['picId']; ?>"></a>
                                    <a href="/user/<?php echo $followers['id']; ?>"><div class="keychain_user_name"><?php echo $followers['name']; ?></div></a>
                                    <div class="keychain_user_info"><?php echo $followers['education']; ?></div>
                                </div>
                                <div class="keychain_right">
                                    <div class="queskey_btn" id="keychain_add_btn"><div style="margin-top:4px" onclick="addtoKeychain2(<?php echo $followers['id']; ?>)">Add</div></div>
                                </div>
                            </div>
                            <?php
                            $i++;
                        }
                    }
                    ?>

                    <?php
                    $i = 1;
                        ?>
                        <h3>
                            My Keychain
                        </h3>
                        <?php
                        if ($keyChainObject->following) {
                        foreach ($keyChainObject->following as $followers) {
                            ?>
                            <div class="keychain_user_container" <?php if ($i % 2 == 0) echo 'style="margin-left:17px;"'; ?>>
                                <div class="keychain_left"> <a href="/user/<?php echo $followers['id']; ?>"><img class="other_user_image" src="<?php echo $followers['picId']; ?>"></a>
                                    <a href="/user/<?php echo $followers['id']; ?>"><div class="keychain_user_name"><?php echo $followers['name']; ?></div></a>
                                    <div class="keychain_user_info"><?php echo $followers['education']; ?></div>
                                </div>
                                <div class="keychain_right">
                                </div>
                            </div>
                            <?php
                            $i++;
                        }
                    }else{
                                                                                echo '<div style="width: 100%;height: 47px;background-color: #f2f2f2;margin-top: 20px;padding-top: 24px;font-size: 18px;color: #666;text-align: center;">You haven`t added anyone in Keychain</div>';
                    }
                    ?>
                </div>
                <?php include_once '../include/footer.php'; ?>
            </div>
        </div>
    </body>
</html>