<?php

class newUserModel {

    private $firstName;
    private $lastName;
    private $email;
    private $username;
    private $password;
    private $fbId;
    private $conPassword;
    private $userExam;

    public function newUser() {
        if (NULL != $this->username && NULL != $this->email && NULL != $this->password) {
            return $this->newUserPersist($this->username, $this->email, sha1($this->password));
        }
    }

    public function newUserPersist($username, $email, $password) {
        mysql_query("SET AUTOCOMMIT=0");
        mysql_query("START TRANSACTION");

        $sql = "INSERT INTO `user` (`user_username` ,`user_emailId`,`user_password`) VALUES (
        '$username','$email','$password');";

        $result = mysql_query($sql);

        $id = mysql_insert_id();

        $message = "Hello " . $username . "!<br>  I&apos;m one of the founders of queskey and we all are very excited to have you on board.<br>
        We are in BETA, and would love to have your feedback. Please let me know your suggestions or ideas. Enjoy preparing :)";

        mysql_query("INSERT INTO message (`from`,`to`,`messagetext`) VALUES ('1','$id','$message'); ");

        if ($result) {
            mysql_query("COMMIT");
            return TRUE;
        } else {
            mysql_query("ROLLBACK");
            return False;
        }
    }

    public function newFBUserPersist() {
        mysql_query("SET AUTOCOMMIT=0");
        mysql_query("START TRANSACTION");

        $sql = "INSERT INTO `user` (`user_firstName`,`user_lastName`,`user_emailId`,`user_fbId`,user_username) VALUES (
        '$this->firstName','$this->lastName','$this->email','$this->fbId', '$this->username');";

        $result = mysql_query($sql);

        $id = mysql_insert_id();

        $message = "Hello " . $this->firstName . "!<br>  I&apos;m one of the founders of queskey and we all are very excited to have you on board.<br>
        We are in BETA, and would love to have your feedback. Please let me know your suggestions or ideas. Enjoy preparing :)";

        mysql_query("INSERT INTO message (`from`,`to`,`messagetext`) VALUES ('1','$id','$message'); ");

        if ($result) {
            mysql_query("COMMIT");
            return TRUE;
        } else {
            mysql_query("ROLLBACK");
            return FALSE;
        }
    }

    public function FBUserUpdate() {
        $sql = "UPDATE `user` SET `user_fbId` = '$this->fbId' WHERE `user_emailId` = '$this->email'";
        if (mysql_query($sql)) {
            return TRUE;
        }
        else
            return FALSE;
    }

    public function persistCategory($userEmail, $categoryArray) {
        $sql = "SELECT user_id FROM `user` where `user_emailId`='$userEmail'";
        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);
        $userId = $row[0];
        for ($i = 0; $i < sizeof($categoryArray); $i++) {
            if ($categoryArray[$i] != 0) {
                $query = "INSERT INTO usercategories (`categoryId`,`userId`) VALUES ('$categoryArray[$i]','$userId')";
                mysql_query($query);
            }
        }
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    public function getFBId() {
        return $this->fbId;
    }

    public function setFBId($fbId) {
        $this->fbId = $fbId;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getConPassword() {
        return $this->conPassword;
    }

    public function setConPassword($conPassword) {
        $this->conPassword = $conPassword;
    }

    public function setUserExam($userExam) {
        $this->userExam = $userExam;
    }

}

?>