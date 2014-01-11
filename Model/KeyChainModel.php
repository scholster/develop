<?php

class KeyChainModel {

    public function getFollowing($userId) {

        $followerArray = "";

        $query = "SELECT f.`heroId`, u.`user_firstName`,u.`user_lastName`,u.user_username, u.`user_picId`, u.user_college, u.`user_fbId`
                  FROM follower f, `user` u WHERE 
                  f.`heroId` = u.user_id AND f.`userId` = '$userId' ";
        $result = mysql_query($query);
        $i = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $followerArray[$i]['id'] = $row['heroId'];
            $followerArray[$i]['name'] = (($row['user_firstName'] != NULL || $row['user_lastName'] != NULL) ? $row['user_firstName'] . " " . $row['user_lastName'] : $row['user_username']);
            if ($row['user_fbId'] > 0) {
                $followerArray[$i]['picId'] = "https://graph.facebook.com/" . $row['user_fbId'] . "/picture?width=137&height=137";
            } elseif ($row['user_picId'] != '0') {
                $followerArray[$i]['picId'] = "/assets/userPic/user_" . $row['heroId'] . "_c." . $row['user_picId'];
            } else {
                $followerArray[$i]['picId'] = "/assets/userPic/default.png";
            }
            $followerArray[$i]['education'] = $row['user_college'];
            $i++;
        }

        return $followerArray;
    }

    public function getFollower($userId) {

        $followerArray = "";

        $query = "SELECT f.`userId`, u.`user_firstName`,u.user_username,u.`user_lastName`, u.`user_picId`, u.user_college, u.`user_fbId`
                  FROM follower f, `user` u WHERE 
                  f.`userId` = u.user_id AND f.`heroId` = '$userId' AND f.`userId` NOT IN (SELECT fi.`heroId` as userId FROM follower fi WHERE fi.`userId` = '$userId' ) ";
        $result = mysql_query($query);
        echo mysql_error();
        $i = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $followerArray[$i]['id'] = $row['userId'];
            $followerArray[$i]['name'] = (($row['user_firstName'] != NULL || $row['user_lastName'] != NULL) ? $row['user_firstName'] . " " . $row['user_lastName'] : $row['user_username']);            
            if ($row['user_fbId'] > 0) {
                $followerArray[$i]['picId'] = "https://graph.facebook.com/" . $row['user_fbId'] . "/picture?width=137&height=137";
            } elseif ($row['user_picId'] != '0') {
                $followerArray[$i]['picId'] = "/assets/userPic/user_" . $row['userId'] . "_c." . $row['user_picId'];
            } else {
                $followerArray[$i]['picId'] = "/assets/userPic/default.png";
            }
            $followerArray[$i]['education'] = $row['user_college'];
            $i++;
        }

        return $followerArray;
    }

}

?>
