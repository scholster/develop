<?php
function createCookie($login1, $login2, $login3) {
    $sql = "SELECT * FROM user_cookie WHERE cookie_login1='$login1'";
    $query = mysql_query($sql);
    $n = mysql_num_rows($query);
    if ($n == 0) {
        $sql = "INSERT INTO user_cookie values ('$login1','$login2','$login3')";
        $result = mysql_query($sql) or die(mysql_error());
        return $result;
    } elseif ($n == 1) {
        $sql = "Update user_cookie SET cookie_login2 = '$login2', cookie_login3='$login3' WHERE cookie_login1='$login1'";
        $result = mysql_query($sql) or die(mysql_error());
        return $result;
    }
    return FALSE;
}

function readCookie($login1, $login2, $login3) {
    $sql = "SELECT cookie.*,u.user_id FROM user_cookie as cookie, user as u
            WHERE cookie_login1='$login1' AND cookie.cookie_login1 = u.user_emailId";
    $query = mysql_query($sql);
    $n = mysql_num_rows($query);
    if ($n == 1) {
        while ($row = mysql_fetch_assoc($query)) {
            $db_login2 = $row['cookie_login2'];
            $db_login3 = $row['cookie_login3'];
            if ($db_login2 == $login2 && $db_login3 == $login3) {
                $_SESSION['userId'] = $row['user_id'];
                return TRUE;
            }
        }
    }
    else
        return FALSE;
    return FALSE;
}

?>