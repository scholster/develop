<?php

require_once 'Model/createDataBaseConnection.php';
require_once 'facebook/src/facebook.php';
require_once 'Model/registerModel.php';
require_once 'Controller/RegisterController.php';
require_once 'Model/NewUserModel.php';
require_once 'Util/functions.php';

$config = array();
$config['appId'] = '280929712039126';
$config['secret'] = 'ba425fcf7e467f6e6c0d28f2d1fedced';
$config['fileUpload'] = false; // optional

$facebook = new Facebook($config);

// Get User ID
$user = $facebook->getUser();

if ($user) {
    try {
        // Proceed knowing you have a logged in user who's authenticated.
        $user_profile = $facebook->api('/me');
        $userEmail = $user_profile['email'];
        $registerController = new RegisterController($userEmail);
        if ($registerController->alreadyRegistered) {
            if ($registerController->fBId == -1) {
                $registerController->fBId = $user_profile['id'];
                $registerController->email = $userEmail;
                $registerController->upDateFBId();
            }
        } else {
            $registerController->firstName = $user_profile['first_name'];
            $registerController->lastName = $user_profile['last_name'];
            $registerController->fBId = $user_profile['id'];
            $registerController->email = $userEmail;
            $registerController->username = $user_profile['username'];
            $registerController->saveDetailsIfNotExist();
            sendIntroMail($userEmail, $user_profile['first_name'] . " " . $user_profile['last_name']);
        }
        $_SESSION['email'] = $userEmail;
        header("Location:/");
        exit();
    } catch (FacebookApiException $e) {
        error_log($e);
        $user = null;
    }
} else {
    $loginUrl = $facebook->getLoginUrl(array(
        'scope' => 'email'
            ));
    header("Location:" . $loginUrl);
    exit();
}
?>