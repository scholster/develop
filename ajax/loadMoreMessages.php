<?php
require_once '../Model/createDataBaseConnection.php';

require_once '../Model/LoginModel.php';
require_once '../Controller/LoginController.php';
require_once '../Util/DateTime.php';

$login = new LoginController();

if (!$login->loggedIn || !isset($_POST['user']) || !is_numeric($_POST['user'])) {
    echo 'INVALID';
    exit();
}

$user1 = $_SESSION['userId'];
$user2 = $_POST['user'];
$src1 = $_POST['src1'];
$src2 = $_POST['src2'];
$time = $_SESSION['messageRefresh'];

$sql = "SELECT `from`,`to`,messagetext,`time` FROM message where `from` IN ('$user1','$user2') AND `to` IN ('$user1','$user2') AND `time` > '$time' ORDER BY `time` desc";
$result = mysql_query($sql);
$i = 0;
while ($row = mysql_fetch_assoc($result)) {
    if ($row['from'] == $user1) {
        ?>
        <div class="msg_thread_right">
            <div class="msg_text_container_right">
                <div id="msg_thread_text">
                    <p align="justify"> <?php echo nl2br($row['messagetext']); ?> </p>
                </div>
                <div class="msg_thread_stat"> <?php echo agoIndia($row['time'], time()); ?> </div>
            </div>
            <img class="msg_thread_asker_image_right" src="<?php echo $src1; ?>" alt="<?php echo $user1 ?>"></img>
        </div>
        <?php
    } else {
        ?>
        <div class="msg_thread_left">
            <img class="msg_thread_asker_image" src="<?php echo $src2; ?>" alt="<?php echo $user2 ?>"></img>
            <div class="msg_text_container_left">
                <div id="msg_thread_text">
                    <p align="justify"> <?php echo nl2br($row['messagetext']); ?> </p>
                </div>
                <div class="msg_thread_stat"><?php echo agoIndia($row['time'], time()); ?> </div>
            </div>
        </div>
        <?php
    }
    if ($i == 0) {
        $_SESSION['messageRefresh'] = $row['time'];
    }
    $i++;
}
?>