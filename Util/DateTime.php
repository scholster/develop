<?php

function agoIndia($datefrom, $dateto) {

    $datefrom = strtotime($datefrom);
    $difference = $dateto - $datefrom;


    if ($difference < 60)
        return "Few seconds ago";
    elseif ($difference < 120) {
        return "A minute ago";
    } elseif ($difference < 3600) {
        $difference = floor($difference / 60);
        return $difference . " minutes ago";
    } elseif ($difference < 7200) {
        return "about an hour ago";
    } elseif ($difference < 86400) {
        $difference = floor($difference / 3600);
        return "about $difference hours ago";
    } else {
        $days = $difference / 86400;
        if ($days < 1.3)
            return "Yesterday";
        else {
            $diff = $datefrom + 28800;
            return date('l, d F Y', $diff);
        }
    }
}

function dateIndia($datefrom) {

    $datefrom = strtotime($datefrom);

    $diff = $datefrom + 28800;
    return date('d F y', $diff);
}

?>