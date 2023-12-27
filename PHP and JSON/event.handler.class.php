<?php
/**
 * Class EventHandler
 * 
 * Handles events with registrants and votes, stored in an array structure.
 */
class EventHandler {
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

    /**
     * Constructor for EventHandler.
     * 
     * @param string $postID The ID of the event.
     * @param string $subject The subject or name of the event.
     * @param string $userID The user ID associated with the event.
     * @param string $user_vote The vote associated with the user for the event.
     */
    public function __construct($postID, $subject, $userID, $user_vote){
        $this->postID = $postID;
        $this->subject = $subject;
        $this->userID = $userID;
        $this->user_vote = $user_vote;

        // Load existing events data from storage
        $this->eventStorage = json_decode(file_get_contents($this->storage), true);

        // Initialize registrants and votes as arrays
        $this->registrants = [
            [
                "user_id" => $this->userID,
                "status" => "Pending"
            ]
        ];
        $this->TheVotes = [
            [
                "user_id" => $this->userID,
                "vote" => $this->user_vote
            ]
        ];

        $flag = false;
        // Check if an event with the given post ID already exists
        foreach($this->eventStorage as $key => $event){
            if($event['post_id'] == $this->postID){
                $flag = true;
                $this->updateEvent($key); // Update existing event
                break;
            }
        }
        // If the event does not exist, create a new event
        if(!$flag){
            $this->event_state = $this->setEventState($this->registrants, $this->TheVotes);
            if($this->checkFieldValues()){
                $this->insertEvent();
            }
        }
    }

    /**
     * Sets the state of the event with registrants and votes.
     * 
     * @param array $registrants An array representing registrants for the event.
     * @param array $TheVotes An array representing votes for the event.
     * 
     * @return array The state of the event.
     */
    private function setEventState($registrants, $TheVotes){
        $event_state = [
            "post_id" => $this->postID,
            "subject" => $this->subject,
            "registrants" => $registrants,
            "votes" => $TheVotes
        ];
        return $event_state;
    }

    /**
     * Checks if the necessary fields are filled.
     * 
     * @return bool Returns true if the fields are filled; false otherwise.
     */
    private function checkFieldValues(){
        if(empty($this->postID) || empty($this->subject)){
            $this->error = "Please fill all the necessary fields.";
            return false;
        } else {
            return true;
        }
    }

    /**
     * Inserts a new event into the events data.
     * 
     * @return string Returns a success message if the event is posted successfully; otherwise, an error message.
     */
    private function insertEvent(){
        array_push($this->eventStorage, $this->event_state);
        if(file_put_contents($this->storage, json_encode($this->eventStorage, JSON_PRETTY_PRINT))){
            return $this->success = "Event Posted!";
        } else {
            return $this->error = "Something went wrong, please try again";
        }
    }

    /**
     * Updates an existing event by appending registrants and votes.
     * 
     * @param int $index The index of the existing event in the events data.
     */
    private function updateEvent($index) {
        // Assuming $this->registrants and $this->TheVotes are arrays

        // Append registrants to the existing array
        $this->eventStorage[$index]['registrants'][] = $this->registrants[0];

        // Append votes to the existing array
        $this->eventStorage[$index]['votes'][] = $this->TheVotes[0];

        // Save the updated events data back to the storage
        if (file_put_contents($this->storage, json_encode($this->eventStorage, JSON_PRETTY_PRINT))) {
            $this->success = "Event Updated!";
        } else {
            $this->error = "Something went wrong while updating the event, please try again";
        }
    }
}
?>
