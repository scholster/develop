<?php

class RegisterController {

    public $isFB;
    public $email;
    public $alreadyRegistered;
    public $firstName;
    public $lastName;
    public $password;
    public $username;
    private $registerModel;
    public $fBId = -1;

    public function __construct($email) {
        $this->email = $email;
        $this->registerModel = new registerModel();
        $this->checkAlreadyExist();
    }

    private function checkAlreadyExist() {
        $detail = $this->registerModel->checkEmailExist($this->email);
        $x = $detail['num'];
        if ($x == false) {
            $this->alreadyRegistered = false;
        } else if ($x == 0) {
            $this->alreadyRegistered = false;
        } else {
            $this->alreadyRegistered = true;
            $this->fBId = $detail['fbId'];
        }
    }
    
    public function upDateFBId(){
        $newUser = new newUserModel();
        $newUser->setEmail($this->email);
        $newUser->setFBId($this->fBId);
        $newUser->FBUserUpdate();
    }

    public function saveDetailsIfNotExist() {
        $newUser = new newUserModel();
        $newUser->setFirstName($this->firstName);
        $newUser->setLastName($this->lastName);
        $newUser->setEmail($this->email);
        $newUser->setUsername($this->username);
        $newUser->setFBId($this->fBId);
        $return = $newUser->newFBUserPersist();
        if($return){
            $newUser->persistCategory($this->email, $_SESSION['userExam']);
        }
    }

}

?>