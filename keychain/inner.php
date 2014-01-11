<?php
require_once '../Model/createDataBaseConnection.php';

require_once '../Model/LoginModel.php';
require_once '../Controller/LoginController.php';

require_once '../Model/KeyChainModel.php';
require_once '../Controller/KeyChainController.php';

$login = new LoginController();

if (!$login->loggedIn) {
    $_SESSION['naviageTo'] = $_SERVER[REQUEST_URI];
    include_once '../login.php';
    exit();
}

$keyChainObject = new KeyChainController($_SESSION['userId']);
?>
<div class="page_header_back" ></div>

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
if ($keyChainObject->following) {
    ?>
    <h3>
        My Keychain
    </h3>
    <?php
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
}
?>