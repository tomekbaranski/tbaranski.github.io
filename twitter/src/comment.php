<?php

Class Comment {

    static public function GetAllCommentsForPost(mysqli $conn, $post_id){
        $sql = "SELECT comments.post_id, comments.comment, comments.creation_date, users.login FROM comments 
                INNER JOIN users ON comments.user_id = users.id WHERE post_id = $post_id ORDER BY creation_date ASC";
        $result = $conn->query($sql);
        $toReturn = [];

        if($result != FALSE){
            foreach ($result as $row){
                $newComment = array(
                    'post_id' => $row['post_id'],
                    'comment' => $row['comment'],
                    'creation_date' => $row['creation_date'],
                    'login' => $row['login']
                );
                
                $toReturn [] = $newComment;
            }
        }
        return $toReturn;
    }

    private $id;
    private $post_id;
    private $user_id;
    private $comment;
    private $creation_date;

    public function __construct(){
        $this->id = -1;
        $this->post_id = "";
        $this->user_id = "";
        $this->comment = "";
        $this->creation_date = "";
    }

    public function getId(){
        return $this->id;
    }

    public function setPostId ($newPostId){
        $this->post_id = $newPostId;
    }

    public function getPostId (){
        return $this->post_id;
    }

    public function setUserID ($newUserID){
        $this->user_id = $newUserID;
    }

    public function getUserID (){
        return $this->user_id;
    }

    public function setComment ($newComment){
        $this->comment = $newComment;
    }

    public function getComment(){
        return $this->comment;
    }

    public function getCreationDate() {
        return $this->creation_date;
    }

    public function saveToDB(mysqli $conn){
        if($this->id === -1){
            $sql = "INSERT INTO comments (post_id, user_id, comment) VALUES
                    ('{$this->post_id}', '{$this->user_id}', '{$this->comment}')";
            $result = $conn->query($sql);
            
            if($result === TRUE){
                $this->id = $conn->insert_id;

                $sql = "SELECT creation_date FROM comments WHERE id = $this->id";
                $result = $conn->query($sql);
                if($result != FALSE && $result->num_rows === 1){
                    $row = $result->fetch_assoc();
                    $this->creation_date = $row['creation_date'];
                    return TRUE;
                }else{
                    return FALSE;
                }
            }else{
                return FALSE;
            }
        } else{
            $sql = "UPDATE comments SET post_id = '{$this->post_id}', user_id = '{$this->user_id}', comment = '{$this->comment}'
                    WHERE id = $this->id";
            $result = $conn->query($sql);
            return $result;
        }
    }

    public function loadFromDB(mysqli $conn, $id){
        $sql = "SELECT * FROM comments WHERE id = $id";
        $result = $conn->query($sql);
        if($result != FALSE){
            if($result->num_rows === 1){
                $row = $result->fetch_assoc();
                $this->post_id = $row['post_id'];
                $this->user_id = $row['user_id'];
                $this->comment = $row['comment'];
                $this->creation_date = $row['creation_date'];
                return TRUE;
            }else{
                return FALSE;
            }
        }
    }
}
?>