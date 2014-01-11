<?php

class registerModel {
    
    public function checkEmailExist($email){
        $query = "SELECT user_id, `user_fbId` FROM `user` where `user_emailId` = '$email'";
        $result = mysql_query($query);
        echo mysql_error();
        $rowNum['num'] = mysql_num_rows($result);
        if($rowNum['num'] == 1){
            $row = mysql_fetch_array($result);
            $rowNum['fbId'] = $row[1];
        } 
        return $rowNum;
    }
}

?>
