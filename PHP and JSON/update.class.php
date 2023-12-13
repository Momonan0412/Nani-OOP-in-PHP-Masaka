<?php
class HandleJsonFile{
    private $eventsStorage = "./Data/events.json";
    private $messagesStorage = "./Data/messages.json";
    private $userStorage = "./Data/users.json";
    private $stored_events = array();
    private $stored_messages = array();
    private $stored_users = array();
    public function getEventsData(){
        if(file_exists($this->eventsStorage)){
            $this->stored_events = json_decode(file_get_contents($this->eventsStorage), true);
        }
        return $this->stored_events;
    }
    public function getMessagesData(){
        if(file_exists($this->messagesStorage)){
            $this->stored_messages = json_decode(file_get_contents($this->messagesStorage), true);
        }
        return $this->stored_messages;
    }
    public function getUsersData(){
        if(file_exists($this->userStorage)){
            $this->stored_users = json_decode(file_get_contents($this->userStorage), true);
        }
        return $this->stored_users;
    }
    public function deleteUser($user_id){
        $users = $this->getUsersData();
        foreach ($users as $key => $user) {
            if($user['user_id'] == $user_id){
                unset($users[$key]);
                break;
            }
        }
        file_put_contents($this->userStorage, json_encode($users, JSON_PRETTY_PRINT));
    }
    public function deleteMessage($user_id){
        $msgs = $this->getMessagesData();
        foreach ($msgs as $key => $msg) {
            if($msg['user_id'] == $user_id){
                unset($msgs[$key]);
                break;
            }
        }
        file_put_contents($this->messagesStorage, json_encode($msgs, JSON_PRETTY_PRINT));
    }
    public function approved(){
        $events = $this->getEventsData();
        foreach($events as $e){
            //  TO-DO CHANGE THE STATUS
        }
    }
}
?>