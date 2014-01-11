<?php

class AnalyticsController {

    private $subject;
    private $userId;
    private $modelObject;
    public $accuracy;
    public $attempted;
    public $correct;
    public $avgTime;
    public $communityAvgTime;
    public $communityAccuracy;
    public $detailedAnalytics;

    public function __construct($subject, $userId) {
        $this->subject = $subject;
        $this->userId = $userId;
        $this->detailedAnalytics = NULL;
        $this->modelObject = new AnalyticsModel();
    }

    function getBasicAnalytics() {
        $result = $this->modelObject->getBasicAnalytics($this->userId, $this->subject);
        if ($result['total'] != 0) {
            $this->attempted = $result['total'];
            $this->correct = $result['correct'];
            $this->accuracy = floor(($this->correct * 100) / $this->attempted);
            $this->avgTime = ceil($result['totalTime'] / $this->attempted);
        } else {
            $this->attempted = 0;
            $this->correct = 0;
            $this->accuracy = 0;
            $this->avgTime = 0;
        }

        $result2 = $this->modelObject->getCommunityBasicAnalytics($this->subject);
        if ($result2['total'] != 0) {
            $this->communityAvgTime = floor($result2['totalTime'] / $result2['total']);
            $this->communityAccuracy = floor(($result2['correct'] * 100) / $result2['total']);
        } else {
            $this->communityAvgTime = 0;
            $this->communityAccuracy = 0;
        }
    }

    public function getBasicAnalyticsByTime() {
        $result = $this->modelObject->getBasicAnalyticsByTime($this->userId, $this->subject);
        if ($result['total'] != 0) {
            $this->attempted = $result['total'];
            $this->correct = $result['correct'];
            $this->accuracy = floor(($this->correct * 100) / $this->attempted);
            $this->avgTime = ceil($result['totalTime'] / $this->attempted);
        } else {
            $this->attempted = 0;
            $this->correct = 0;
            $this->accuracy = 0;
            $this->avgTime = 0;
        }

        $result2 = $this->modelObject->getCommunityBasicAnalytics($this->subject);
        if ($result2['total'] != 0) {
            $this->communityAvgTime = floor($result2['totalTime'] / $result2['total']);
            $this->communityAccuracy = floor(($result2['correct'] * 100) / $result2['total']);
        } else {
            $this->communityAvgTime = 0;
            $this->communityAccuracy = 0;
        }
        return $result;
    }

    public function getBasicAnalyticsByCorrect() {
        $result = $this->modelObject->getBasicAnalyticsByCorrect($this->userId, $this->subject);
        if ($result['total'] != 0) {
            $this->attempted = $result['total'];
            $this->correct = $result['correct'];
            $this->accuracy = floor(($this->correct * 100) / $this->attempted);
            $this->avgTime = ceil($result['totalTime'] / $this->attempted);
        } else {
            $this->attempted = 0;
            $this->correct = 0;
            $this->accuracy = 0;
            $this->avgTime = 0;
        }

        $result2 = $this->modelObject->getCommunityBasicAnalyticsByCorrect($this->subject,  $this->userId);
        if ($result2['total'] != 0) {
            $this->communityAvgTime = floor($result2['totalTime'] / $result2['total']);
            $this->communityAccuracy = floor(($result2['correct'] * 100) / $result2['total']);
        } else {
            $this->communityAvgTime = 0;
            $this->communityAccuracy = 0;
        }
    }
    
    public function getBasicAnalyticsByInCorrect() {
        $result = $this->modelObject->getBasicAnalyticsByInCorrect($this->userId, $this->subject);
        if ($result['total'] != 0) {
            $this->attempted = $result['total'];
            $this->correct = $result['correct'];
            $this->accuracy = floor(($this->correct * 100) / $this->attempted);
            $this->avgTime = ceil($result['totalTime'] / $this->attempted);
        } else {
            $this->attempted = 0;
            $this->correct = 0;
            $this->accuracy = 0;
            $this->avgTime = 0;
        }

        $result2 = $this->modelObject->getCommunityBasicAnalyticsByInCorrect($this->subject,  $this->userId);
        if ($result2['total'] != 0) {
            $this->communityAvgTime = floor($result2['totalTime'] / $result2['total']);
            $this->communityAccuracy = floor(($result2['correct'] * 100) / $result2['total']);
        } else {
            $this->communityAvgTime = 0;
            $this->communityAccuracy = 0;
        }
    }

    function getDetailedAnalytics() {
        $analytics = $this->modelObject->getTopicWiseAnalytics($this->userId, $this->subject);
        $communityAnalytics = $this->modelObject->getTopicWiseCommunityAnalytics($this->subject);
        $i = 0;
        if ($this->attempted > 0) {
            if ($analytics)
                foreach ($analytics as $analytic) {
                    $topicId = $analytic['topicId'];
                    $communityAnalytic = $communityAnalytics[$topicId];
                    $this->detailedAnalytics[$i]['topic'] = $analytic['topic'];
                    $this->detailedAnalytics[$i]['accuracy'] = floor(($analytic['correct'] * 100) / $analytic['total']);
                    $this->detailedAnalytics[$i]['total'] = $analytic['total'];
                    $this->detailedAnalytics[$i]['correct'] = $analytic['correct'];
                    $this->detailedAnalytics[$i]['communityAccuracy'] = floor(($communityAnalytic['correct'] * 100) / $communityAnalytic['total']);
                    $this->detailedAnalytics[$i]['avgTime'] = $analytic['totalTime'] / $analytic['total'];
                    $this->detailedAnalytics[$i]['commAvgTime'] = $communityAnalytic['totalTime'] / $communityAnalytic['total'];
                    $i++;
                }
        }
    }
    
    function getDetailedAnalyticsByCorrect() {
        $analytics = $this->modelObject->getTopicWiseAnalyticsByCorrect($this->userId, $this->subject);
        $communityAnalytics = $this->modelObject->getTopicWiseCommunityAnalyticsByCorrect($this->subject,  $this->userId);
        $i = 0;
        if ($this->attempted > 0) {
            if ($analytics)
                foreach ($analytics as $analytic) {
                    $topicId = $analytic['topicId'];
                    $communityAnalytic = $communityAnalytics[$topicId];
                    $this->detailedAnalytics[$i]['topic'] = $analytic['topic'];
                    $this->detailedAnalytics[$i]['accuracy'] = floor(($analytic['correct'] * 100) / $analytic['total']);
                    $this->detailedAnalytics[$i]['total'] = $analytic['total'];
                    $this->detailedAnalytics[$i]['correct'] = $analytic['correct'];
                    $this->detailedAnalytics[$i]['communityAccuracy'] = floor(($communityAnalytic['correct'] * 100) / $communityAnalytic['total']);
                    $this->detailedAnalytics[$i]['avgTime'] = $analytic['totalTime'] / $analytic['total'];
                    $this->detailedAnalytics[$i]['commAvgTime'] = $communityAnalytic['totalTime'] / $communityAnalytic['total'];
                    $i++;
                }
        }
    }
    
    function getDetailedAnalyticsByInCorrect() {
        $analytics = $this->modelObject->getTopicWiseAnalyticsByInCorrect($this->userId, $this->subject);
        $communityAnalytics = $this->modelObject->getTopicWiseCommunityAnalyticsByInCorrect($this->subject,  $this->userId);
        $i = 0;
        if ($this->attempted > 0) {
            if ($analytics)
                foreach ($analytics as $analytic) {
                    $topicId = $analytic['topicId'];
                    $communityAnalytic = $communityAnalytics[$topicId];
                    $this->detailedAnalytics[$i]['topic'] = $analytic['topic'];
                    $this->detailedAnalytics[$i]['accuracy'] = floor(($analytic['correct'] * 100) / $analytic['total']);
                    $this->detailedAnalytics[$i]['total'] = $analytic['total'];
                    $this->detailedAnalytics[$i]['correct'] = $analytic['correct'];
                    $this->detailedAnalytics[$i]['communityAccuracy'] = floor(($communityAnalytic['correct'] * 100) / $communityAnalytic['total']);
                    $this->detailedAnalytics[$i]['avgTime'] = $analytic['totalTime'] / $analytic['total'];
                    $this->detailedAnalytics[$i]['commAvgTime'] = $communityAnalytic['totalTime'] / $communityAnalytic['total'];
                    $i++;
                }
        }
    }

}

?>
