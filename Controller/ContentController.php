<?php

class ContentController {

    public $subject = "";
    public $subjectLabel = "";
    public $topic = "";
    public $subTopic = "";
    public $type = 0;
    public $subjectId = -1;

    public function __construct() {
        
    }

    public function getTopics($subject) {
        $sql = "SELECT t.id as topicId ,t.topic , t.`introLine`,t.publish,t.image
                FROM content_topic as t
                where t.subject = '$subject' ORDER BY t.`order` desc";

        $result = mysql_query($sql);

        $list = NULL;
        $i = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $list[$i]['topicId'] = $row['topicId'];
            $list[$i]['topic'] = $row['topic'];
            $list[$i]['intro'] = $row['introLine'];
            $list[$i]['publish'] = $row['publish'];
            $list[$i]['image'] = $row['image'];
            $i++;
        }

        return $list;
    }

    public function getSubTopics($topic, $userId) {
        $sql = "SELECT id,subtopic,`introLine`,image,ucd.`subTopicId` as readflag FROM content_subtopic st LEFT JOIN user_contentdone ucd 
                ON st.id = ucd.`subTopicId` AND ucd.`userId` = '$userId'
                where st.`topicId`='$topic' ORDER BY st.`order` asc ";
        $result = mysql_query($sql);
        $list = NULL;
        $i = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $list[$i]['id'] = $row['id'];
            $list[$i]['subTopic'] = $row['subtopic'];
            $list[$i]['intro'] = $row['introLine'];
            $list[$i]['image'] = $row['image'];
            $list[$i]['readflag'] = $row['readflag'];
            $i++;
        }
        return $list;
    }

    public function getReviewQuiz($topic, $userId) {
        $sql = "SELECT rq.id,rqr.quizid as doneflag FROM content_reviewquiz rq LEFT JOIN user_reviewquizresult rqr ON rqr.quizid = rq.id AND rqr.userid = '$userId'
                WHERE rq.`topicId` = '$topic' AND rq.publish = '0' ORDER BY rq.id DESC";
        $result = mysql_query($sql);
        $quizIds = NULL;
        $i = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $quizIds[$i]['id'] = $row['id'];
            $quizIds[$i]['doneflag'] = $row['doneflag'];
            $i++;
        }
        return $quizIds;
    }

    public function getSubTopicInfo() {
        $sql = "SELECT st.subtopic,st.`introLine`,st.image,st.id, t.id as topicId FROM content_subtopic st , content_topic t
                WHERE st.subtopic = '$this->subTopic' AND st.`topicId` = t.id AND t.topic = '$this->topic' ORDER BY st.`order` asc ";
        $result = mysql_query($sql);
        $list = NULL;
        while ($row = mysql_fetch_assoc($result)) {
            $list['id'] = $row['id'];
            $list['topicId'] = $row['topicId'];
            $list['subTopic'] = $row['subtopic'];
            $list['intro'] = $row['introLine'];
            $list['image'] = $row['image'];
        }
        return $list;
    }

    public function getTopicInfo($topic) {
        $sql = "SELECT t.id as topicId ,t.topic , t.`introLine`,t.publish,t.image
                FROM content_topic as t
                where t.topic = '$topic'";

        $result = mysql_query($sql);

        $list = NULL;
        while ($row = mysql_fetch_assoc($result)) {
            $list['topicId'] = $row['topicId'];
            $list['topic'] = $row['topic'];
            $list['intro'] = $row['introLine'];
            $list['publish'] = $row['publish'];
            $list['image'] = $row['image'];
        }
        return $list;
    }

    public function getUserTopicProgress($topicId, $userId) {
        $sql = "SELECT count(DISTINCT st.id) as contentTotal, count(DISTINCT ucd.`subTopicId`) as contentDone, 
                count(DISTINCT cq.`questionId`) as  conceptQuestions, count(DISTINCT uca.`quesId`) as  conceptDone,
                count(DISTINCT rq.id) as reviewTotal, count(DISTINCT urqr.quizid) as reviewDone
                FROM content_subtopic st LEFT JOIN user_contentdone ucd ON ucd.`subTopicId` = st.id AND ucd.`userId` = '$userId'
                LEFT JOIN content_subtopicquiz stq ON stq.`subTopicId` = st.id
                LEFT JOIN content_question cq ON cq.`type` = 1 AND cq.`relationId` = stq.id 
                LEFT JOIN user_contentanswer uca ON uca.`quesId` = cq.`questionId` AND uca.`userId` = '$userId'
                LEFT JOIN content_reviewquiz rq ON rq.`topicId` = st.`topicId`
                LEFT JOIN user_reviewquizresult as urqr ON urqr.quizid = rq.id AND urqr.userid = '$userId'
                where st.`topicId` = '$topicId'";
        $result = mysql_query($sql);
        $row = mysql_fetch_assoc($result);
        $percent = 0;
        $percent = $percent + ($row['contentDone'] / $row['contentTotal']) * 34;
        $percent = $percent + ($row['conceptDone'] / $row['conceptQuestions']) * 33;
        $percent = $percent + ($row['reviewDone'] / $row['reviewTotal']) * 33;

        return $percent;
    }

    public function getUserTopics($userId) {
        $sql = "SELECT st.`topicId` as topicId ,count(DISTINCT st.id) as contentTotal, count(DISTINCT ucd.`subTopicId`) as contentDone, 
                count(DISTINCT cq.`questionId`) as  conceptQuestions, count(DISTINCT uca.`quesId`) as  conceptDone,
                count(DISTINCT rq.id) as reviewTotal, count(DISTINCT urqr.quizid) as reviewDone
                FROM content_subtopic st LEFT JOIN user_contentdone ucd ON ucd.`subTopicId` = st.id AND ucd.`userId` = '$userId'
                LEFT JOIN content_subtopicquiz stq ON stq.`subTopicId` = st.id
                LEFT JOIN content_question cq ON cq.`type` = 1 AND cq.`relationId` = stq.id 
                LEFT JOIN user_contentanswer uca ON uca.`quesId` = cq.`questionId` AND uca.`userId` = '$userId'
                LEFT JOIN content_reviewquiz rq ON rq.`topicId` = st.`topicId`
                LEFT JOIN user_reviewquizresult as urqr ON urqr.quizid = rq.id AND urqr.userid = '$userId'
                GROUP BY st.`topicId`;
                ";
        $result = mysql_query($sql);
        
        $topicList = NULL;
        
        while ($row = mysql_fetch_assoc($result)) {
            $percent = 0;
            $percent = $percent + ($row['contentDone'] / $row['contentTotal']) * 34;
            $percent = $percent + ($row['conceptDone'] / $row['conceptQuestions']) * 33;
            $percent = $percent + ($row['reviewDone'] / $row['reviewTotal']) * 33;
            $topicList[$row['topicId']] = $percent;
        }
        
        return $topicList;
    }

    public function getInnerTopics($subTopicId) {
        $sql = "SELECT id,heading FROM content_innerTopic WHERE `subTopic` = '$subTopicId' ORDER BY id";
        $result = mysql_query($sql);
        $list = NULL;
        $i = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $list[$i]['id'] = $row['id'];
            $list[$i]['heading'] = $row['heading'];
            $i++;
        }
        return $list;
    }

    public function getInnerContent($innerTopicId, $userId) {
        $sql = "SELECT c.id,c.content,c.type,ch.userid FROM content_subtopiccontent c LEFT JOIN user_contenthighlight ch ON c.id = ch.`paraId` AND ch.userid = '$userId' 
                WHERE c.`innerTopicId`='$innerTopicId' ORDER BY c.id asc";
        $result = mysql_query($sql);
        $content = NULL;
        $i = 0;
        while ($row = mysql_fetch_assoc($result)) {
            if (isset($row['userid'])) {
                $content[$i]['highlight'] = $row['userid'];
            } else {
                $content[$i]['highlight'] = NULL;
            }
            $content[$i]['id'] = $row['id'];
            $content[$i]['type'] = $row['type'];
            $content[$i]['content'] = $row['content'];
            $i++;
        }

        return $content;
    }

    public function getSubTopicQuiz($subTopic, $userId) {
        $sql = "SELECT stq.id,count(cq.`questionId`) as totalQuestions, count(uca.`quesId`) as done FROM content_subtopicquiz stq, content_question cq LEFT JOIN user_contentanswer uca
                ON uca.`quesId` = cq.`questionId` AND uca.`userId` = '$userId'
                WHERE stq.`subTopicId` = '$subTopic' AND stq.publish = '0' AND cq.`relationId` = stq.id AND cq.`type`=1 
                GROUP BY cq.`relationId` ORDER BY stq.id DESC";
        $result = mysql_query($sql);
        $quizIds = NULL;
        $i = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $quizIds[$i]['id'] = $row['id'];
            $quizIds[$i]['total'] = $row['totalQuestions'];
            $quizIds[$i]['done'] = $row['done'];
            $i++;
        }
        return $quizIds;
    }

    public function getSubTopicNotes($userId, $subTopic) {
        $sql = "SELECT notes FROM user_contentnotes WHERE userid = '$userId' AND subtopicid='$subTopic'";
        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);
        if (isset($row[0])) {
            return $row[0];
        } else {
            return NULL;
        }
    }

    public function markUserReadContent($userId, $subtopicId) {
        mysql_query("SET AUTOCOMMIT=0");
        mysql_query("START TRANSACTION");
        $query = "INSERT INTO user_contentdone (`userId`,`subTopicId`) VALUES ('$userId','$subtopicId')";
        $result = mysql_query($query);
        if ($result) {
            mysql_query("COMMIT");
            return TRUE;
        } else {
            mysql_query("ROLLBACK");
            return FALSE;
        }
    }

    public function setUserContentActivity($userId, $topicId) {
        mysql_query("SET AUTOCOMMIT=0");
        mysql_query("START TRANSACTION");
        $sql = "SELECT id FROM user_activity where `userId`='$userId' AND `relationId`='$topicId' AND `type`='6'";
        $num = mysql_num_rows(mysql_query($sql));
        echo mysql_error();
        if ($num == 0) {
            $query = "INSERT INTO user_activity (`userId`,`type`,`relationId`) VALUES ('$userId','6','$topicId')";
        } else {
            $query = "UPDATE user_activity SET `timestamp` = CURRENT_TIMESTAMP where `userId`='$userId' AND `relationId`='$topicId' AND `type`='6'";
        }
        $result = mysql_query($query);
        echo mysql_error();
        if ($result) {
            mysql_query("COMMIT");
            return TRUE;
        } else {
            mysql_query("ROLLBACK");
            return FALSE;
        }
    }

}

?>