<?php

class UserDetailsController {

    private $modelObject;
    private $userId;
    public $info;
    private $stats;
    public $journeyStats;
    public $quantAnalytics;
    public $verbalAnalytics;
    public $smartScore;

    function __construct($id) {
        $this->userId = $id;
        $this->modelObject = new UserDetailsModel;
        $this->info = $this->modelObject->loadUserData($id);
        $this->quantAnalytics = new AnalyticsController(1, $this->userId);
        $this->verbalAnalytics = new AnalyticsController(3, $this->userId);
        $this->quantAnalytics->getBasicAnalytics();
        $this->verbalAnalytics->getBasicAnalytics();
        $this->journeyStats = $this->getjourneyStats();
        $this->calculateSmartScore();
    }

    public function getMessages($user2) {
        return $this->modelObject->getMessages($this->userId, $user2);
    }

    public function getNewMessage() {
        return $this->modelObject->getMessageNo($this->userId);
    }

    public function getNewRelations() {
        return $this->modelObject->getRelationNo($this->userId);
    }

    public function getRelation($youId) {
        return $this->modelObject->getRelation($this->userId, $youId);
    }
    
    public function getTopicInfo($topicId){
        return $this->modelObject->getTopicName($topicId);
    }

    public function getActivity($userId, $lastId) {
        $activities = $this->modelObject->getActivity($userId, $lastId);
        $feed = NULL;
        $i = 0;
        if ($activities)
            foreach ($activities as $activity) {
                if ($i == 0) {
                    $_SESSION['lastActivityId'] = $activity['id'];
                }
                $feed[$i]['name'] = (($activity['user_firstName'] != NULL || $activity['user_lastName'] != NULL) ? $activity['user_firstName'] . " " . $activity['user_lastName'] : $activity['user_username']);
                $feed[$i]['userId'] = $activity['userId'];                
                if ($activity['user_fbId'] > 0) {
                    $feed[$i]['image'] = "https://graph.facebook.com/" . $activity['user_fbId'] . "/picture?width=68&height=68";
                } elseif ($activity['user_picId'] != '0') {
                    $feed[$i]['image'] = "/assets/userPic/user_" . $activity['userId'] . "_c." . $activity['user_picId'];
                } else {
                    $feed[$i]['image'] = "/assets/userPic/default.png";
                }
                switch ($activity['type']) {
                    case 1:
                        $feed[$i]['type'] = 1;
                        $feed[$i]['line'] = "says";
                        $feed[$i]['post'] = $this->modelObject->getUserPost($activity['relationId']);
                        break;

                    case 2:
                        $feed[$i]['type'] = 2;
                        $feed[$i]['line'] = "took a quiz";
                        $feed[$i]['post'] = ($activity['relationId'] == 1 ? "Quant and Data Interpretation" : "Verbal and Logical Reasoning");
                        $feed[$i]['link'] = "/practice/" . $activity['relationId'];
                        $feed[$i]['button'] = "Practice";
                        $feed[$i]['subject'] = $activity['relationId'];
                        break;

                    case 3:
                        $feed[$i]['type'] = 3;
                        $feed[$i]['line'] = "was practicing";
                        $topicInfo = $this->modelObject->getTopicName($activity['relationId']);
                        $feed[$i]['post'] = $topicInfo[0];
                        $temp = ($topicInfo[1] == 1 ? "Quant-DI" : "Verbal");
                        $feed[$i]['link'] = str_replace(' ', '-', '/content/' . $temp . '/' . $feed[$i]['post']);
                        $feed[$i]['button'] = "Practice";
                        $feed[$i]['subject'] = $topicInfo[1];
                        break;

                    case 4:
                        $feed[$i]['type'] = 4;
                        $feed[$i]['line'] = "was practicing";
                        $topicInfo = $this->modelObject->getSubTopicName($activity['relationId']);
                        $feed[$i]['post'] = $topicInfo[0];
                        $temp = ($topicInfo[1] == 1 ? "Quant-DI" : "Verbal");
                        $feed[$i]['link'] = str_replace(' ', '-', '/content/' . $temp . '/' . $topicInfo[2]);
                        $feed[$i]['button'] = "Practice";
                        $feed[$i]['subject'] = $topicInfo[1];
                        break;

                    case 6:
                        $feed[$i]['type'] = 6;
                        $feed[$i]['line'] = "was studying";
                        $topicInfo = $this->modelObject->getTopicName($activity['relationId']);
                        $feed[$i]['post'] = $topicInfo[0];
                        $temp = ($topicInfo[1] == 1 ? "Quant-DI" : "Verbal");
                        $feed[$i]['link'] = str_replace(' ', '-', '/content/' . $temp . '/' . $feed[$i]['post']);
                        $feed[$i]['button'] = "Study Lesson";
                        $feed[$i]['subject'] = $topicInfo[1];
                        break;
                }
                $i++;
            }

        return $feed;
    }

    public function getBestInTopics($id) {
        return $this->modelObject->getBestSubjects($id);
    }

    public function getjourneyStats() {
        $stats = $this->modelObject->getJourneyStats($this->userId);
        $this->stats = $stats;
        $return = NULL;
        if (isset($stats['1'])) {
            if (isset($stats['1']['done'])) {
                $return[1]['done'] = (271 / 14) * ($stats['1']['done']);
                if ($return[1]['done'] > 271) {
                    $return[1]['done'] = 271;
                }
            } else {
                $return[1]['done'] = 0;
            }
        } else {
            $return[1]['done'] = 0;
        }
        if (isset($stats['3'])) {
            if (isset($stats['3']['done'])) {
                $return[3]['done'] = (191 / 10) * ($stats['3']['done']);
                if ($return[3]['done'] > 191) {
                    $return[3]['done'] = 191;
                }
            } else {
                $return[3]['done'] = 0;
            }
        } else {
            $return[3]['done'] = 0;
        }

        return $return;
    }

    public function getDashboardBarText() {
        return $this->modelObject->getDashboardBarText();
    }

    public function updateDemoFlag() {
        return $this->modelObject->updateDemoFlag($this->userId);
    }
    
    public function updateDemoFlag2() {
        return $this->modelObject->updateDemoFlag2($this->userId);
    }
    
    public function updateDemoFlag3() {
        return $this->modelObject->updateDemoFlag3($this->userId);
    }

    public function getQuizArchive() {
        $return[1] = $this->modelObject->quizArchive($this->userId, 1);
        $return[3] = $this->modelObject->quizArchive($this->userId, 3);
        return $return;
    }

    public function calculateSmartScore() {
        $smartScore = 0;
        if ($this->stats['1']) {
            $smartScore = $smartScore + (($this->stats['1']['done'] / 14) * 10);
        }
        if ($this->stats['3']) {
            $smartScore = $smartScore + $this->stats['3']['done'];
        }
        if ($this->quantAnalytics->attempted == 1000) {
            $smartScore = $smartScore + 10;
        } else {
            $smartScore = $smartScore + ($this->quantAnalytics->attempted / 100);
        }
        if ($this->verbalAnalytics->attempted == 1000) {
            $smartScore = $smartScore + 10;
        } else {
            $smartScore = $smartScore + ($this->verbalAnalytics->attempted / 100);
        }
        if ($this->quantAnalytics->accuracy > 80 && $this->quantAnalytics->attempted > 100) {
            $smartScore = $smartScore + 10;
        } elseif ($this->quantAnalytics->attempted > 100) {
            $smartScore = $smartScore + ($this->quantAnalytics->accuracy / 8);
        }
        if ($this->verbalAnalytics->accuracy > 80 && $this->verbalAnalytics->attempted > 100) {
            $smartScore = $smartScore + 10;
        } elseif ($this->verbalAnalytics->attempted > 100) {
            $smartScore = $smartScore + ($this->verbalAnalytics->accuracy / 8);
        }
        if ($this->quantAnalytics->avgTime != 0)
            if ($this->quantAnalytics->avgTime < $this->quantAnalytics->communityAvgTime) {
                $smartScore = $smartScore + 10;
            } else {
                $smartScore = $smartScore + ($this->quantAnalytics->communityAvgTime / $this->quantAnalytics->avgTime) * 10;
            }
        if ($this->verbalAnalytics->avgTime != 0)
            if ($this->verbalAnalytics->avgTime < $this->verbalAnalytics->communityAvgTime) {
                $smartScore = $smartScore + 10;
            } else {
                $smartScore = $smartScore + ($this->verbalAnalytics->communityAvgTime / $this->verbalAnalytics->avgTime) * 10;
            }
        $quantLastWeekAnalytics = $this->quantAnalytics->getBasicAnalyticsByTime();
        if ($quantLastWeekAnalytics['total'] > 30) {
            $smartScore = $smartScore + 10;
        } else {
            $smartScore = $smartScore + ($quantLastWeekAnalytics['total'] / 30) * 10;
        }
        $verbalLastWeekAnalytics = $this->verbalAnalytics->getBasicAnalyticsByTime();
        if ($verbalLastWeekAnalytics['total'] > 30) {
            $smartScore = $smartScore + 10;
        } else {
            $smartScore = $smartScore + ($verbalLastWeekAnalytics['total'] / 30) * 10;
        }
        $this->smartScore = ceil($smartScore);
    }

}

?>