<?php

header('Content-Type: application/json');
require_once '../Model/createDataBaseConnection.php';

require_once '../Model/LoginModel.php';
require_once '../Controller/LoginController.php';

require_once '../Model/UserDetailsModel.php';
require_once '../Controller/UserDetailsController.php';

require_once '../Model/AnalyticsModel.php';
require_once '../Controller/AnalyticsController.php';

$login = new LoginController();

if (!$login->loggedIn) {
    echo 'INVALID';
    exit();
}

$userObject = new UserDetailsController($_SESSION['userId']);

$message = $userObject->getNewMessage();
$alert = $userObject->getNewRelations();

$data = array(
    'message' => $message,
    'alert' => $alert
);

echo json_encode($data);
?>