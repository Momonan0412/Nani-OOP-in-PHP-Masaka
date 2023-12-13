<?php
    class EventHandler{
        private $postID;
        private $userID;
        private $subject;
        private $user_vote;

        private $registrants;
        private $TheVotes;
        
        private $storage = "./Data/events.json";
        private $eventStorage;
        private $event_state;

        private $error;
        private $success;

        public function __construct($postID, $subject, $userID, $user_vote){
            $this->postID = $postID;
            $this->subject = $subject;
            $this->userID = $userID;
            $this->user_vote = $user_vote;

            $this->eventStorage = json_decode(file_get_contents($this->storage), true);

            $this->registrants = [
                "user_id" =>  $this->userID,
                "status" => "Pending"
            ];
            $this->TheVotes = [
                "user_id" =>  $this->userID,
                "vote" => $this->user_vote
            ];
            $flag = false;
            foreach($this->eventStorage as $key => $event){
                if($event['post_id'] == $this->postID){
                    $flag = true;
                    $this->updateEvent($key); // Update existing event
                    break;
                }
            }
            if(!$flag){
                $this->event_state = $this->setEventState($this->registrants, $this->TheVotes);
                if($this->checkFieldValues()){
                    $this->insertEvent();
                }
            }
        }

        private function setEventState($registrants, $TheVotes){
            $event_state = [
                "post_id" => $this->postID,
                "subject" => $this->subject,
                "registrants" => $registrants,
                "votes" => $TheVotes
            ];
            return $event_state;
        }
        private function checkFieldValues(){
            if(empty($this->postID) || empty($this->subject)){
                $this->error = "Please fill all the necessary fields.";
                return false;
            } else {
                return true;
            }
        }
        private function insertEvent(){
            array_push($this->eventStorage, $this->event_state);
			if(file_put_contents($this->storage, json_encode($this->eventStorage, JSON_PRETTY_PRINT))){
				return $this->success = "Message Posted!";
			} else {
				return $this->error = "Something went wrong, please try again";
			}
        }
        private function updateEvent($index){
            $this->eventStorage[$index]['registrants'] = $this->registrants;
            $this->eventStorage[$index]['votes'] = $this->TheVotes;
    
            if(file_put_contents($this->storage, json_encode($this->eventStorage, JSON_PRETTY_PRINT))){
                $this->success = "Event Updated!";
            } else {
                $this->error = "Something went wrong while updating the event, please try again";
            }
        }
    }
?>