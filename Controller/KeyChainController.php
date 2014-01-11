<?php

class KeyChainController {

    private $modelObject;
    private $userId;
    public $follower;
    public $following;
    public $noFollowers;
    public $noFollowing;

    public function __construct($userId) {
        $this->modelObject = new KeyChainModel();
        $this->userId = $userId;
        $this->callOnLoad();
    }

    private function callOnLoad() {
        $this->follower = $this->modelObject->getFollower($this->userId);
        $this->following = $this->modelObject->getFollowing($this->userId);
        if ($this->follower == "") {
            $this->noFollowers = 0;
        } else {
            $this->noFollowers = sizeof($this->follower);
        }

        if ($this->following == "") {
            $this->noFollowing = 0;
        } else {
            $this->noFollowing = sizeof($this->following);
        }
    }

}

?>