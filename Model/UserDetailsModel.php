<?php

class UserDetailsModel {

    public function loadUserData($userId) {
        $info = NULL;
        $sql = "SELECT u.user_username, u.`user_fbId`, u.user_college,u.`user_firstName`,u.`user_picId`,u.`demoFlag`,u.`demoFlag2`,u.`demoFlag3`,u.`timestamp`,
                u.`user_lastName`,u.user_work,u.user_location, u.passwordtime, (CURRENT_DATE-u.passwordtime) as currentDate
                FROM `user` u WHERE u.user_id = '$userId'";
        $result = mysql_query($sql);
        $row = mysql_fetch_assoc($result);
        if ($row) {
            $info['username'] = $row['user_username'];
            if ($row['user_fbId'] > 0) {
                $info['userImage'] = "https://graph.facebook.com/" . $row['user_fbId'] . "/picture?width=137&height=137";
            } elseif ($row['user_picId'] != '0') {
                $info['userImage'] = "/assets/userPic/user_" . $userId . "_c." . $row['user_picId'];
            } else {
                $info['userImage'] = "/assets/userPic/default.png";
            }
            $info['firstName'] = $row['user_firstName'];
            $info['lastName'] = $row['user_lastName'];
            $info['work'] = $row['user_work'];
            $info['education'] = $row['user_college'];
            $info['location'] = $row['user_location'];
            $info['passwordTime'] = $row['passwordtime'];
            $info['currentDate'] = $row['currentDate'];
            $info['fbId'] = $row['user_fbId'];
            $info['demoFlag'] = $row['demoFlag'];
            $info['demoFlag2'] = $row['demoFlag2'];
            $info['demoFlag3'] = $row['demoFlag3'];
//            $info['memberType'] = $row['membershipType'];
//            $info['validity'] = ceil($row['membershipexpire'] - (time() - strtotime($row['timestamp']))/86400);
        }
        return $info;
    }

    public function getMessages($user1, $user2) {
        $messages = NULL;
        $sql = "SELECT `from`,`to`,messagetext,`time` FROM message where `from` IN ('$user1','$user2') AND `to` IN ('$user1','$user2') ORDER BY `time` desc";
        $result = mysql_query($sql);
        $i = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $messages[$i]['from'] = $row['from'];
            $messages[$i]['to'] = $row['to'];
            $messages[$i]['message'] = $row['messagetext'];
            $messages[$i]['time'] = $row['time'];
            if ($i == 0) {
                $_SESSION['messageRefresh'] = $row['time'];
            }
            $i++;
        }

        $query = "UPDATE message SET status = '1' WHERE `to`='$user1' AND `from`='$user2'";
        mysql_query($query);

        return $messages;
    }

    public function getMessageNo($user) {
        $sql = "SELECT COUNT(DISTINCT(`from`)) FROM message WHERE `to` = '$user' AND status='0'";
        $result = mysql_fetch_array(mysql_query($sql));
        return $result[0];
    }

    public function getRelationNo($user) {
        $query = "SELECT COUNT(*) FROM (SELECT id FROM user_alert WHERE `userId` = '$user' AND seen = '0'
                   GROUP BY `commentId`, `type`) alert";
        $result = mysql_query($query);
        $row = mysql_fetch_array($result);
        return $row[0];
    }

    public function getRelation($meId, $youId) {
        $query = "SELECT `userId`,`heroId` FROM follower 
                    where (`userId`='$meId' AND `heroId`='$youId') ||  (`userId`='$youId' AND `heroId`='$meId')";
        $result = mysql_query($query);
        $num = mysql_num_rows($result);
        switch ($num) {
            case 0 : return 4;
                break;

            case 1 : $row = mysql_fetch_assoc($result);
                if ($row['heroId'] == $youId) {
                    return 2;
                } else {
                    return 3;
                }
                break;

            case 2 : return 1;
                break;
        }
    }

    public function getActivity($userId, $lastId) {
        if ($userId != -1) {
            $query = "SELECT id,`userId`,`type`,`relationId`, COUNT(*), `user_firstName`, `user_lastName`,user_username, `user_picId`, `user_fbId`
                  FROM user_activity ua, `user` u 
                  WHERE u.user_id = ua.`userId`  AND ua.`userId` = '$userId'
                  GROUP BY `type` ,`relationId` 
                  ORDER BY ua.`timestamp` desc LIMIT 0,10;";
        } elseif ($lastId != NULL) {
            $query = "SELECT id,`userId`,`type`,`relationId`, COUNT(*), `user_firstName`, `user_lastName`,user_username, `user_picId`, `user_fbId`
                  FROM (SELECT * FROM user_activity ORDER BY `timestamp` DESC) ua, `user` u 
                  WHERE u.user_id = ua.`userId` AND ua.id > '$lastId'  
                  GROUP BY ua.`userId` 
                  ORDER BY ua.`timestamp` desc LIMIT 0,10;";
        } else {
            $query = "SELECT id,`userId`,`type`,`relationId`, COUNT(*), `user_firstName`, `user_lastName`,user_username, `user_picId`, `user_fbId`
                  FROM (SELECT * FROM user_activity ORDER BY `timestamp` DESC) ua, `user` u 
                  WHERE u.user_id = ua.`userId`
                  GROUP BY ua.`userId` 
                  ORDER BY ua.`timestamp` desc LIMIT 0,10;";
        }
        $result = mysql_query($query);
        echo mysql_error();
        $return = NULL;
        $i = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $return[$i] = $row;
            $i++;
        }
        return $return;
    }

    public function getTopicName($topicId) {
        $result = mysql_query("SELECT topic,subject FROM content_topic where id = '$topicId'");
        $row = mysql_fetch_array($result);
        return $row;
    }

    public function getSubTopicName($subTopicId) {
        $result = mysql_query("SELECT st.subtopic, t.subject,t.topic FROM content_subtopic st, content_topic t
            WHERE st.id = '$subTopicId' AND t.id = st.`topicId`");
        $row = mysql_fetch_array($result);
        return $row;
    }

    public function getUserPost($id) {
        $result = mysql_query("SELECT post FROM user_posts WHERE id='$id'");
        $row = mysql_fetch_array($result);
        return $row[0];
    }

    public function getBestSubjects($userId) {
        $query = "SELECT COUNT(ua.id) as total, SUM(ua.`isCorrect`) as correct ,((SUM(ua.`isCorrect`)*100)/COUNT(ua.id)) as percent,  t.topic as topic, t.image, t.subject
                FROM user_contentanswer ua, content_question q, content_topic t
                WHERE `userId` = '$userId' AND ua.`quesId`=q.`questionId` AND q.`topicId` = t.id  GROUP BY t.id ORDER BY percent desc LIMIT 0,3";
        $result = mysql_query($query);
        $analytics = NULL;
        $i = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $analytics[$i]['topic'] = $row['topic'];
            $analytics[$i]['image'] = $row['image'];
            $analytics[$i]['percent'] = $row['percent'];
            $i++;
        }
        return $analytics;
    }

    public function getJourneyStats($userId) {
        $query = "SELECT COUNT(DISTINCT t.id) as done, t.subject FROM user_contentdone ucd, content_subtopic st, content_topic t 
                    WHERE ucd.`userId` = '$userId' AND ucd.`subTopicId` = st.id AND st.`topicId` = t.id GROUP BY t.subject";

        $result = mysql_query($query);
        $stats = NULL;
        while ($row = mysql_fetch_assoc($result)) {
            $stats[$row['subject']]['done'] = $row['done'];
        }
        return $stats;
    }

    public function getDashboardBarText() {
        $query = "SELECT count(id) as count from dashboardBar";
        $result = mysql_query($query);
        $row = mysql_fetch_array($result);
        $rand = rand(0, $row[0] - 1);

        $result2 = mysql_query("SELECT text from dashboardBar LIMIT $rand,1");
        echo mysql_error();
        $fetchedRow = mysql_fetch_array($result2);
        return $fetchedRow[0];
    }

    public function updateDemoFlag($userId) {
        mysql_query("SET AUTOCOMMIT=0");
        mysql_query("START TRANSACTION");
        $query = "UPDATE `user` SET `demoFlag` = 1 WHERE user_id = '$userId'";
        $result = mysql_query($query);
        $affectedRows = mysql_affected_rows();
        if ($result && $affectedRows == 1) {
            mysql_query("COMMIT");
        } else {
            mysql_query("ROLLBACK");
        }
    }

    public function updateDemoFlag2($userId) {
        mysql_query("SET AUTOCOMMIT=0");
        mysql_query("START TRANSACTION");
        $query = "UPDATE `user` SET `demoFlag2` = 1 WHERE user_id = '$userId'";
        $result = mysql_query($query);
        $affectedRows = mysql_affected_rows();
        if ($result && $affectedRows == 1) {
            mysql_query("COMMIT");
        } else {
            mysql_query("ROLLBACK");
        }
    }

    public function updateDemoFlag3($userId) {
        mysql_query("SET AUTOCOMMIT=0");
        mysql_query("START TRANSACTION");
        $query = "UPDATE `user` SET `demoFlag3` = 1 WHERE user_id = '$userId'";
        $result = mysql_query($query);
        $affectedRows = mysql_affected_rows();
        if ($result && $affectedRows == 1) {
            mysql_query("COMMIT");
        } else {
            mysql_query("ROLLBACK");
        }
    }

    public function quizArchive($userId, $subject) {
//        $query = "SELECT date_taken as date,quizid FROM user_dailyquizresult uqr, content_dailyquiz cdq WHERE 
//                    uqr.quizid=cdq.id AND cdq.subject='$subject' AND uqr.status = '1' AND uqr.userid = '$userId' ORDER BY uqr.date_taken DESC";
        $query = "SELECT doneOn as date,id FROM user_customquiz WHERE userId = '$userId' AND subject = '$subject' AND (status=1 OR mode = 0)";
        $result = mysql_query($query);
        $return = NULL;
        $i = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $return[$i]['date'] = $row['date'];
            $return[$i]['quizId'] = $row['id'];
            $i++;
        }
        return $return;
    }

}

?>