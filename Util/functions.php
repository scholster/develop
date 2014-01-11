<?php

function parseInputString($string) {
    return mysql_real_escape_string(htmlspecialchars($string));
}

function getAnalyticsColorCode($userAccuracy, $communityAccuracy) {
    if ($userAccuracy < 60) {
        return "#cd5a64";
    } elseif ($userAccuracy > 90) {
        return "#8cbf69";
    } elseif (($userAccuracy + 20) < $communityAccuracy) {
        return "#cd5a64";
    } elseif ($userAccuracy < $communityAccuracy) {
        return "#ffb400";
    } elseif ($userAccuracy > $communityAccuracy + 20) {
        return "#8cbf69";
    } else {
        return "#ffb400";
    }
}

function getCircleData($correct, $total, $radius) {
    if ($total == 0) {
        $total = 1;
        $correct = 0;
    }

    $correctAngle = ($correct / $total) * 2 * pi();
    $return = NULL;
    $return['diffX'] = $radius * sin($correctAngle);
    $return['diffY'] = $radius - $radius * cos($correctAngle);
    if ($correctAngle > pi()) {
        $return['flag1'] = 1;
        $return['flag2'] = 0;
    } else {
        $return['flag1'] = 0;
        $return['flag2'] = 1;
    }
    if ($correct == $total) {
        $return['diffX'] = $return['diffX'] - 1;
    } elseif ($correct == 0) {
        $return['diffX'] = $return['diffX'] + 1;
    }
    return $return;
}

function secondsToString($seconds) {
    $seconds = floor($seconds);
    $min = floor($seconds / 60);
    $sec = $seconds % 60;
    if ($min > 0) {
        if ($sec > 0) {
            return $min . 'm ' . $sec . 's';
        } else {
            return $min . 'm';
        }
    } else {
        return $sec . 's';
    }
}

function sendIntroMail($to, $name) {
    $message = '
        <p style="text-align:justify">
        Hi ' . $name . ' <br/><br/>
        Greetings from Queskey . We are excited to have you on board. Queskey is an adaptive test preparation platform for CAT.  We aim to give you everything that you need to be better prepared.<br><br>
        Queskey provides you with a  user-friendly and interactive learning system that is especially designed to enhance your overall learning experience.<br/><br/>
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
    mail($to, 'Welcome to queskey', $message, $headers,'-fdump@queskey.com');
}

function quizNumbertoLetters($number){
    if($number==1){
        return 'A';
    }elseif ($number==2) {
        return 'B';
    }elseif ($number==3) {
        return 'C';
    }elseif ($number==4) {
        return 'D';
    }elseif ($number==5) {
        return 'E';
    }else{
        echo 'Else'.$number;
        return '';
    }
}

function quizIsCorrectToString($isCorreect){
    if($isCorreect==1){
        return " (Correct)";
    }else{
        return " (Incorrect)";
    }
}
?>
