<?php
require_once '../Model/createDataBaseConnection.php';
require_once '../Model/LoginModel.php';
require_once '../Controller/LoginController.php';

require_once '../Model/UserDetailsModel.php';
require_once '../Controller/UserDetailsController.php';

$login = new LoginController();

if (!$login->loggedIn) {
    echo 'INVALID';
    exit();
}

$userObject = new UserDetailsController($_SESSION['userId']);

$activity = $userObject->getActivity(-1, $_SESSION['lastActivityId']);
if($activity)
foreach ($activity as $feed) {
    ?>
    <li>
        <div class="postActivityLeft"> <a href="/user/<?php echo $feed['userId']; ?>"><img class="other_user_image" src="<?php echo $feed['image']; ?>"></a>
            <div style="float: left;background-color: inherit;">
                <div class="postActivityText"><?php echo $feed['name']; ?> <?php echo $feed['line']; ?></div>
                <div class="tideActivityFooter"> <?php echo $feed['post']; ?> </div>
            </div>
        </div>
        <div class="postActivityRight">
            <?php
            if ($feed['type'] != 1) {
                ?>
                <a href="<?php echo $feed['link']; ?>"><div class="queskey_btn" id="dashboard_activity_btn" ><?php echo $feed['button']; ?></div></a>
                <div id="activity_other_users">
        <!--                                        <img src="assets/img/activity_user.jpg" class="activity_user" />
                    <img src="assets/img/activity_user.jpg" class="activity_user" />
                    <img src="assets/img/activity_user.jpg" class="activity_user" />
                    <div class="activity_user">+28</div>-->
                </div>
                <?php
            }
            ?>
        </div>
    </li>
    <?php
}
?>