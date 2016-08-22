<?php

function getAllPosts (mysqli $conn){
    $sql = "SELECT posts.id AS post_id, posts.post_text, posts.creation_date AS post_date, post_author.id AS author_id,
        post_author.login AS author, comments.comment, comments.creation_date AS comment_date,
        comments.user_id AS comment_author_id, comment_author.login AS commnet_author
        FROM posts INNER JOIN users AS post_author ON posts.user_id=post_author.id
        LEFT JOIN comments ON posts.id = comments.post_id
        INNER JOIN users AS comment_author ON comments.user_id = comment_author.id";
    $result = $conn->query($sql);

    $toReturn = [];

    if($result != FALSE){
        while($row = $result->fetch_assoc()){
            $toReturn [] = $row;
        }
    }
    return $toReturn;
}

function timeElapsedString($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function lastSiteUrl(){
    $folder_name = 'twitter/'; // enter folder name

    $lastSiteUrlWithGet = substr($_SERVER['HTTP_REFERER'],(strpos($_SERVER['HTTP_REFERER'],
            $folder_name) + strlen($folder_name))); // last site url with GET

    $lastSiteUrlLenghtWithoutGet = strpos(substr($_SERVER['HTTP_REFERER'],(strpos($_SERVER['HTTP_REFERER'], $folder_name)
        + strlen($folder_name))),'?'); // last site url lenght without GET information

    if($lastSiteUrlLenghtWithoutGet === false){
        return $lastSiteUrlWithGet === false ? 'index.php' : $lastSiteUrlWithGet;
    } else{
        return substr($lastSiteUrlWithGet, 0, $lastSiteUrlLenghtWithoutGet);
    }
}
?>