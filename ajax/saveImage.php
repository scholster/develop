<?php

require_once '../Model/createDataBaseConnection.php';
require_once '../Model/LoginModel.php';
require_once '../Controller/LoginController.php';

$login = new LoginController();

if (!$login->loggedIn) {
    echo 'INVALID';
    exit();
}

$userId = $_SESSION['userId'];

$extension = $_SESSION['extension'];

//unset($_SESSION['extention']);

if (isset($_POST['x1']) && isset($_POST['y1']) && isset($_POST['width']) && isset($_POST['imgHeight']) && $_SESSION['extension']) {

    list($width, $height) = getimagesize("../assets/userPic/temp_" . $userId . '_f.' . $extension);
    $imgDimensions = floor(($_POST['width'] * $width) / 300);

    $src_x = floor(($_POST['x1'] * $width) / 300);
    $src_y = floor(($_POST['y1'] * $height) / $_POST['imgHeight']);

    $picture = new Imagick("../assets/userPic/temp_" . $userId . '_f.' . $extension);

    $bool1 = $picture->cropImage($imgDimensions, $imgDimensions, $src_x, $src_y);
    
    $picture->setimageresolution(72, 72);
    $picture->resizeimage(137, 137, Imagick::FILTER_LANCZOS, 1);
    
    $bool2 = $picture->writeimage("../assets/userPic/user_" . $userId . '_c.' . $extension);
    
    $picture->destroy();

    if ($bool1 && $bool2) {
        $query = "UPDATE `user` SET `user_picId` = '$extension' WHERE user_id = '$userId'";
        $bool3 = mysql_query($query);
        if ($bool3) {
            echo '1';
        } else {
            echo '2';
        }
    } else {
        echo '2';
    }
} else {
    echo 'INVALID';
}
?>