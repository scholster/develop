<?php

class MessageController {

    private $modelObject;

    public function __construct() {
        $this->modelObject = new MessageModel();
    }

    public function getSenders() {
        return $this->modelObject->getSenders($_SESSION['userId']);
    }

}

?>
