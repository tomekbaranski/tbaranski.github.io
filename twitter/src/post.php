<?php

Class Post {
    static public function GetAllPosts(mysqli $conn){
        $sql = "SELECT posts.id, posts.post_text, posts.creation_date, users.login FROM posts INNER JOIN users ON 
                posts.user_id = users.id ORDER BY posts.creation_date DESC";
        $result = $conn->query($sql);
        $toReturn = [];

        if($result != false){
            foreach ($result as $row){
                $newPost = array(
                    'id' => $row['id'],
                    'post_text' => $row['post_text'],
                    'creation_date' => $row['creation_date'],
                    'login' => $row['login'],
                );

                $toReturn [] = $newPost;
            }
        }
        return $toReturn;
    }

    static public function GetUserPosts(mysqli $conn, $id){
        $sql = "SELECT * FROM posts WHERE user_id = $id ORDER BY creation_date DESC";
        $result = $conn->query($sql);
        $toReturn = [];

        if($result != false){
            foreach ($result as $row){
                $newPost = new Post();

                $newPost->id = $row['id'];
                $newPost->user_id = $row['user_id'];
                $newPost->post_text = $row['post_text'];
                $newPost->creation_date = $row['creation_date'];

                $toReturn[] = $newPost;
            }
        }
        return $toReturn;
    }

    private $id;
    private $user_id;
    private $post_text;
    private $creation_date;

    public function __construct(){
        $this->id = -1;
        $this->user_id = "";
        $this->post_text = "";
        $this->creation_date = "";
    }

    public function getID (){
        return $this->id;
    }

    public function setUserId ($newUserId){
        $this->user_id = $newUserId;
    }

    public function getUserId(){
        return $this->user_id;
    }

    public function setPostText ($newPostText){
        $this->post_text = $newPostText;
    }

    public function getPostText(){
        return $this->post_text;
    }

    public function getCreationDate (){
        return $this->creation_date;
    }

    public function saveToDB(mysqli $conn){
        if($this->id === -1){
            $sql = "INSERT INTO posts (user_id, post_text) VALUES
                   ('{$this->user_id}', '{$this->post_text}')";
            $result = $conn->query($sql);
            if($result === TRUE){
                $this->id = $conn->insert_id;

                $sql = "SELECT creation_date FROM posts WHERE id = $this->id";
                $result = $conn->query($sql);
                if($result != FALSE){
                    if($result->num_rows === 1){
                        $row = $result->fetch_assoc();
                        $this->creation_date = $row['creation_date'];
                        return TRUE;
                    } else{
                        return FALSE;
                    }
                }
            }else{
                return FALSE;
            }
        }else{
            $sql = "UPDATE posts SET user_id='{$this->user_id}',post_text = '{$this->post_text}' WHERE id = {$this->id}";
            $result = $conn->query($sql);
            return $result;
        }
    }

    public function loadFromDB(mysqli $conn, $id){
        $sql = "SELECT * FROM posts WHERE id = $id";
        $result = $conn->query($sql);
        if($result != FALSE){
            if($result->num_rows === 1){
                $row = $result->fetch_assoc();
                $this->id = $row['id'];
                $this->user_id = $row['user_id'];
                $this->post_text = $row['post_text'];
                $this->creation_date = $row['creation_date'];

                return TRUE;
            }
        }else{
            return FALSE;
        }
    }
}
?>