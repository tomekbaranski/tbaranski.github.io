<?php
Class Message{

    static public function GetUserMessages(mysqli $conn){
        $sql = "SELECT messages.id, messages.sender_id, messages.receiver_id, messages.message, messages.is_read, 
                messages.creation_date, users.login FROM messages INNER JOIN users ON messages.sender_id = users.id 
                WHERE receiver_id = {$_SESSION['loggedUserId']} ORDER BY creation_date DESC";
        $result = $conn->query($sql);
        $toReturn = [];

        if($result != FALSE){
            foreach ($result as $row){
                $newMessage = array(
                    'id' => $row['id'],
                    'sender_id' => $row['sender_id'],
                    'receiver_id' => $row['receiver_id'],
                    'message_text' => $row['message'],
                    'is_read' => $row['is_read'],
                    'creation_date' => $row['creation_date'],
                    'login' => $row['login']                    
                );

                $toReturn [] = $newMessage;
            }
        }
        return $toReturn;
    }

    static public function CountUnreadMessages(mysqli $conn){
        $sql = "SELECT is_read FROM messages WHERE receiver_id = {$_SESSION['loggedUserId']} AND is_read = 0";
        $result = $conn->query($sql);
        return $result->num_rows;
    }

    private $id;
    private $sender_id;
    private $receiver_id;
    private $message_text;
    private $is_read;
    private $creation_date;

    public function __construct(){
        $this->id = -1;
        $this->sender_id = "";
        $this->receiver_id = "";
        $this->message_text = "";
        $this->is_read = 0;
        $this->creation_date = "";
    }

    public function getId(){
        return $this->id;
    }
    public function getSenderId(){
        return $this->sender_id;
    }
    public function setSenderId($sender_id){
        $this->sender_id = $sender_id;
    }
    public function getReceiverId(){
        return $this->receiver_id;
    }
    public function setReceiverId($receiver_id){
        $this->receiver_id = $receiver_id;
    }
    public function getMessageText(){
        return $this->message_text;
    }
    public function setMessageText($message_text){
        $this->message_text = $message_text;
    }
    public function messageOpend(){
        $this->is_read = 1;
    }
    public function messageNotOpened(){
        $this->is_read = 0;
    }
    public function getCreationDate(){
        return $this->creation_date;
    }

    public function saveToDB(mysqli $conn){
        if ($this->id === -1) {
            $sql = "INSERT INTO messages (sender_id, receiver_id, message, is_read) VALUES
                    ('{$this->sender_id}', '{$this->receiver_id}', '{$this->message_text}', '{$this->is_read}')";
            $result = $conn->query($sql);

            if ($result === TRUE) {
                $this->id = $conn->insert_id;

                $sql = "SELECT creation_date FROM messages WHERE id = $this->id";
                $result = $conn->query($sql);

                if ($result != FALSE) {
                    if ($result->num_rows === 1) {
                        $row = $result->fetch_assoc();
                        $this->creation_date = $row['creation_date'];
                        return TRUE;
                    } else {
                        return FALSE;
                    }
                }

            } else {
                return FALSE;
            }
        } else {
            $sql = "UPDATE messages SET sender_id = '{$this->sender_id}', receiver_id = '{$this->receiver_id}', 
                    message = '{$this->message_text}', is_read = '{$this->is_read}' WHERE id = $this->id";
            $result = $conn->query($sql);
            return $result;
        }
    }

    public function loadFromDB(mysqli $conn, $id){
        $sql = "SELECT * FROM messages WHERE id = $id";
        $result = $conn->query($sql);
        if($result != FALSE){
            if($result->num_rows === 1){
                $row = $result->fetch_assoc();
                $this->id = $row['id'];
                $this->sender_id = $row['sender_id'];
                $this->receiver_id = $row['receiver_id'];
                $this->message_text = $row['message'];
                $this->creation_date = $row['creation_date'];

                return TRUE;
            }
        }else{
            return FALSE;
        }
    }
}
?>