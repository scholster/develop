<?php

class QuizController {

    public $quizId;
    public $topicName;
    public $subTopicName;
    private $subTopicId;
    private $topicId;
    public $subject;
    private $modelObject;

    function __construct($quizId) {
        $this->quizId = $quizId;
        $this->modelObject = new QuizModel();
    }

    public function getSubTopicQuizInfo() {
        $info = $this->modelObject->getSubTopicQuizInfo($this->quizId);
        if ($info != NULL) {
            $this->topicName = $info['topic'];
            $this->subject = $info['subject'];
            $this->subTopicName = $info['subtopic'];
            $this->subTopicId = $info['subTopicId'];
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getReviewQuizInfo() {
        $info = $this->modelObject->getReviewQuizInfo($this->quizId);
        if ($info != NULL) {
            $this->topicName = $info['topic'];
            $this->subject = $info['subject'];
            $this->topicId = $info['topicId'];
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getDailyQuizInfo() {
        $info = $this->modelObject->getDailyQuizInfo($this->quizId);
        if ($info != NULL) {
            $this->subject = $info['subject'];
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function checkReviewQuizUserStatus() {
        $num = $this->modelObject->checkReviewQuizUserStatus($this->quizId, $_SESSION['userId']);
        if ($num == 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function checkDailyQuizUserStatus() {
        $num = $this->modelObject->checkDailyQuizUserStatus($this->quizId, $_SESSION['userId']);
        if ($num == 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getQuestions($type) {
        return $this->modelObject->getQuestions($this->quizId, $_SESSION['userId'], $type);
    }

    public function getDailyQuizQuestions() {
        return $this->modelObject->getDailyQuizQuestions($this->quizId, $_SESSION['userId']);
    }

    public function getQuestionAvgTime($type) {
        return $this->modelObject->getQuestionAvgTime($this->quizId,$type);
    }

    public function getDailyQuizQuestionAvgTime() {
        return $this->modelObject->getDailyQuizQuestionAvgTime($this->quizId);
    }

    public function getReviewQuizResult() {
        return $this->modelObject->getReviewQuizResult($this->quizId, $_SESSION['userId']);
    }

    public function getDailyQuizResult() {
        return $this->modelObject->getDailyQuizResult($this->quizId, $_SESSION['userId']);
    }

    public function createSubTopicQuizActivity() {
        $this->modelObject->createSubTopicQuizActivity($_SESSION['userId'], $this->subTopicId);
    }

    public function createReviewQuizActivity() {
        $this->modelObject->createReviewQuizActivity($_SESSION['userId'], $this->topicId);
    }

    public function createDailyQuizActivity() {
        $this->modelObject->createDailyQuizActivity($_SESSION['userId'], $this->subject);
    }

    public function createDailyQuizUserEntry() {
        $this->modelObject->createDailyQuizUserEntry($_SESSION['userId'], $this->quizId);
    }

    public function getNextQuizId() {
        return $this->modelObject->getNextQuizId($_SESSION['userId'], $this->subject);
    }
}

?>