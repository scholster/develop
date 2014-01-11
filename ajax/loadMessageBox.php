<?php
require_once '../Model/createDataBaseConnection.php';
require_once '../Model/LoginModel.php';
require_once '../Controller/LoginController.php';
require_once '../Util/DateTime.php';

$login = new LoginController();

if (!$login->loggedIn) {
    echo 'INVALID';
    exit();
}

$userId = $_SESSION['userId'];

$query = "SELECT DISTINCT(`from`), `user_firstName`, `user_lastName`,user_username, `user_fbId`,`user_picId` ,`messagetext`,`status`, `time`, flag  FROM 
                    (SELECT DISTINCT(`from`) ,`messagetext`,`status`,`time`, 1 as flag FROM
                        (SELECT * FROM message WHERE `to` = '$userId'  ORDER BY `time` DESC) x GROUP BY (`from`)
                    UNION
                    SELECT DISTINCT(`to`), `messagetext`,`status`,`time`, 0 as flag FROM
                        (SELECT * FROM message WHERE `from` = '$userId'  ORDER BY `time` DESC) y
                    GROUP BY (`to`) ORDER BY `time` DESC) r, `user` u WHERE u.user_id = r.`from`
                  GROUP BY (`from`) ORDER BY `time` desc LIMIT 0,5;";

$result = mysql_query($query);
?>
<script>
    $(document).ready(function(){
        $('#message_scroll').jScrollPane();
    });
</script>
<div id="message_pop_kink"></div>
<div id="message_scroll" style="overflow-y: auto; height: 270px; margin-bottom: 25px;">
    <ul id="message_pop_List">
        <?php
        if (mysql_num_rows($result)) {
            while ($row = mysql_fetch_assoc($result)) {
                if ($row['user_fbId'] > 0) {
                    $img = "https://graph.facebook.com/" . $row['user_fbId'] . "/picture?width=137&height=137";
                } elseif ($row['user_picId'] != '0') {
                    $img = "/assets/userPic/user_" . $row['from'] . "_c." . $row['user_picId'];
                } else {
                    $img = "/assets/userPic/default.png";
                }

                if ($row['user_firstName'] != '' || $row['user_lastName'] != '') {
                    $name = $row['user_firstName'] . ' ' . $row['user_lastName'];
                } else {
                    $name = $row['user_username'];
                }
                ?>
                <a href="/user/<?php echo $row['from'] ?>">
                    <li <?php
        if ($row['status'] == '0' && $row['flag'] == 1) {
            echo "style='background-color:#FFF0CD;'";
        }
                ?>>
                        <div class="message_pop_Left">
                            <img class="message_pop_image" src="<?php echo $img; ?>">

                            <div class="message_pop_sender"><?php echo $name; ?></div>
                            <div class="message_pop_text ">
                                <?php if ($row['flag'] == 0) { ?>
                                    <div style="float: left; height: 16px; width: 16px; background: url(/assets/img/sent_arrow.png) no-repeat 0 0;"></div>
                                <?php } ?>
                                <p><?php echo $row['messagetext']; ?></p>
                            </div>
                        </div>
                        <div id="message_pop_Time" ><?php echo agoIndia($row['time'], time()); ?></div>
                    </li>
                </a>
                <?php
            }
        } else {
            echo '<div style="width: 100%;text-align: center;margin-top: 20px;color: #666;">You have no Message</div>';
        }
        ?>

    </ul>
</div>
<div style="position: absolute; top: 270px;">
    <a href="/message/"><div class="message_pop_view_all" style="height:20px; background-color:#FFF">view all messages</div></a>
</div>