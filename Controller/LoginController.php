<?php

class LoginController {

    public $loggedIn = false;
    public $name;
    public $subject;
    public $picId;
    public $info = NULL;

    public function __construct() {
        $this->loggedIn = $this->loggedin();
        
        if($this->loggedIn){
            $this->setUserId();
        }
    }

    public function Login($email, $password) {
        if (null != $email && null != $password) {
            $sql = "SELECT * FROM user WHERE user_emailId ='$email'";
            $login = mysql_query($sql) or die(mysql_error());
            $n = mysql_num_rows($login);
            if ($n == 0)
                return "Wrong username password combination";
            else {
                while ($row = mysql_fetch_assoc($login)) {
                    $db_password = $row['user_password'];
                    if (sha1($password) == $db_password) {
                        $_SESSION['email'] = $email;
                        $_SESSION['userId'] = $row['user_id'];
                        $this->loggedIn = TRUE;
                    }
                    else
                        return "Wrong username password combination";
                }
            }
        }
    }

    public function checkFBLogin() {
        $config = array();
        $config['appId'] = '454793921261900';
        $config['secret'] = '175dcd53ba0c7dbabe5f346c17f70196';
        $config['fileUpload'] = false; // optional

        $facebook = new Facebook($config);
        $user = $facebook->getUser();
        if ($user) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function insertCookie($email) {
        $rand1 = rand(10000000, 99999999);
        $rand2 = rand(10000000, 99999999) * rand(10000000, 99999999);
        if (createCookie($email, $rand1, $rand2)) {
            setcookie("login1", $email, time() + 2592000, NULL, NULL, FALSE, TRUE);
            setcookie("login2", $rand1, time() + 2592000, NULL, NULL, FALSE, TRUE);
            setcookie("login3", $rand2, time() + 2592000, NULL, NULL, FALSE, TRUE);
        }
    }

    public function loggedin() {
        $loggedin = false;
        if (isset($_SESSION['email'])) {
            $loggedin = true;
        } else {
            return $this->checkCookie();
        }
        return $loggedin;
    }
    
    public function setUserId(){
        if(!isset($_SESSION['userId'])){
            $email = $_SESSION['email'];
            $sql = "SELECT user_id FROM user WHERE user_emailId ='$email'";
            $result = mysql_query($sql);
            $info = mysql_fetch_array($result);
            $_SESSION['userId'] = $info[0];
        }
    }

    public function checkCookie() {
        if (isset($_COOKIE['login1']) && isset($_COOKIE['login2']) && isset($_COOKIE['login3'])) {
            $login1 = $_COOKIE['login1'];
            $login2 = $_COOKIE['login2'];
            $login3 = $_COOKIE['login3'];
            if (readCookie($login1, $login2, $login3)) {
                $_SESSION['email'] = $login1;
                $this->insertCookie($login1);
                return TRUE;
            }
        }
        return FALSE;
    }

}

?>