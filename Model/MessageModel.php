<?php

class MessageModel {

    public function getSenders($userId) {
        $senders = NULL;
        $query = "SELECT DISTINCT(`from`), `user_firstName`, `user_lastName`,user_username, `user_fbId`,`user_picId` ,`messagetext`,`status`, `time`, flag  FROM 
                    (SELECT DISTINCT(`from`) ,`messagetext`,`status`,`time`, 1 as flag FROM
                        (SELECT * FROM message WHERE `to` = '$userId'  ORDER BY `time` DESC) x GROUP BY (`from`)
                    UNION
                    SELECT DISTINCT(`to`), `messagetext`,`status`,`time`, 0 as flag FROM
                        (SELECT * FROM message WHERE `from` = '$userId'  ORDER BY `time` DESC) y
                    GROUP BY (`to`) ORDER BY `time` DESC) r, `user` u WHERE u.user_id = r.`from`
                  GROUP BY (`from`) ORDER BY `time` desc;";

        $result = mysql_query($query);
        $i = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $senders[$i]['from'] = $row['from'];
            $senders[$i]['messagetext'] = $row['messagetext'];
            $senders[$i]['status'] = $row['status'];
            $senders[$i]['time'] = $row['time'];
            $senders[$i]['flag'] = $row['flag'];
            
            if ($row['user_fbId'] > 0) {
                $senders[$i]['img'] = "https://graph.facebook.com/" . $row['user_fbId'] . "/picture?width=137&height=137";
            } elseif ($row['user_picId'] != '0') {
                $senders[$i]['img'] = "/assets/userPic/user_" . $row['from'] . "_c." . $row['user_picId'];
            } else {
                $senders[$i]['img'] = "/assets/userPic/default.png";
            }

            if ($row['user_firstName'] != '' || $row['user_lastName'] != '') {
                $senders[$i]['name'] = $row['user_firstName'] . ' ' . $row['user_lastName'];
            } else {
                $senders[$i]['name'] = $row['user_username'];
            }
            $i++;
        }
        return $senders;
    }

}

?>