<?php

require_once '../Model/createDataBaseConnection.php';
require_once '../Controller/ContentController.php';

require_once '../Model/LoginModel.php';
require_once '../Controller/LoginController.php';

require_once '../Model/UserDetailsModel.php';
require_once '../Controller/UserDetailsController.php';

require_once '../Controller/AnalyticsController.php';
require_once '../Model/AnalyticsModel.php';

$userObject = new UserDetailsController($_SESSION['userId']);
$userInfo = $userObject->info;

$login = new LoginController();

if (!$login->loggedIn) {
    $_SESSION['naviageTo'] = $_SERVER[REQUEST_URI];
    include_once '../login.php';
    exit();
}

$userId = $_SESSION['userId'];
$controller = new ContentController();

if (isset($_GET['subject'])) {
    $controller->subject = $_GET['subject'];
    $controller->type = 1;
}

if (isset($_GET['topic'])) {
    $controller->topic = str_replace('-', ' ', $_GET['topic']);
    $controller->type = 2;
}

if (isset($_GET['subTopic'])) {
    $controller->subTopic = str_replace('-', ' ', $_GET['subTopic']);
    $controller->type = 3;
}

if ($controller->type == 0) {
    header("Location:/");
    exit();
}

$innerContentId = NULL;

if (strcasecmp($controller->subject, "Verbal") == 0) {
    $controller->subjectId = 2;
    $controller->subjectLabel = "Verbal & Logical Reasoning";
    $innerContentId = "verbal_content";
} elseif (strcasecmp($controller->subject, "Quant-DI") == 0) {
    $controller->subjectId = 1;
    $controller->subjectLabel = "Quant & DI";
    $innerContentId = "maths_content";
} else {
    include_once '../notfound.html';
    exit();
}

if ($controller->type == 1) {
    include_once 'contentIndex.php';
    exit();
} elseif ($controller->type == 2) {
    include_once 'contentSubIndex.php';
} elseif ($controller->type == 3) {
    include_once 'contentInner.php';
    exit();
}
?>