<?php

include_once 'Model/createDataBaseConnection.php';
if (isset($_SESSION['userId']) && $_SESSION['userId'] == 86) {
    echo 'Hi';
} else {
    include_once 'notfound.html';
    exit();
}

function sendMailToPreviousMembers($to, $name) {
    $message = '
        <p style="text-align:justify">
        Hi ' . $name . ' <br/><br/>
        Greetings from queskey. We are very excited to inform you that queskey is now live. You signed up for queskey even before you knew what we were building, and trusted us to create something useful for the CAT aspirants. We have put in our best, to stand by our promise.<br><br>
        Queskey gives you everything that you need to be better prepared for the CAT. We provide you with a  user-friendly and interactive learning system that is especially designed to enhance your overall learning experience.<br/><br/>
        Move along to
        <a href="http://queskey.com">www.queskey.com</a> and we hope you enjoy preparing.
        
<br>
<br>


        Cheers<br/>
        Team queskey<br><br>
        PS - We are currently running in BETA and constantly evolving. We would love your feedback on our product.';

    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
    $headers .= 'From: Team-Queskey <team@queskey.com>' . "\r\n";



// Send
    mail($to, 'Queskey is live', $message, $headers, '-fdump@queskey.com');
}

$query = "SELECT user_id,`user_firstName`,user_username,`user_emailId` FROM `user` where user_id";
$result = mysql_query($query);

while ($row = mysql_fetch_array($result)) {
    if ($row[0] != 1) {
        print_r($row);
        echo '<br>';
        $name = $row[1] != NULL ? $row[1] : $row[2];
        $toId = $row[0];

        $message = "Hi " . $name . "

It has been awesome for our team to help you prepare for CAT exam. We have been working continuously to enhance the exam preparation content and are building some really cool features to make the platform smarter and richer. You&apos;ll see a lot of new stuff coming your way, pretty soon.

It would be great if you could spread the word about “Queskey” on Facebook, Twitter, Linkedin or just giving a shout to your buddies.

The more Queskey spreads out, the better the community learning experience gets.

And yes we are always open to your suggestions and feedabck. It makes Queskey stronger.";

        $sql = "INSERT INTO `message` (`from`,`to`,messagetext) VALUES ('1','$toId','$message')";
        if (mysql_query($sql))
            echo 'Notification to ' . $name . "(" . $toId . ")";
        else {
            echo mysql_error();
        }
    }
}
?>