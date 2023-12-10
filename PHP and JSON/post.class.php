<?php
class PostMessage{
	private $subject;
	private $message;
	private $username;
	private $post_id;
	private $user_id;
	private $image;

	public $error;
	public $success;
	private $storage = "./Data/messages.json";
	private $stored_message = [];
	private $new_message;
	public function __construct($subject, $message, $image){
		session_start();
		$this->subject = filter_var(trim($subject), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$this->message = filter_var(trim($message), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$this->image = $image;
		if(file_exists($this->storage)){
			$this->stored_message = json_decode(file_get_contents($this->storage), true);
		}
		$this->post_id = count($this->stored_message) + 1;
		$this->user_id = $_SESSION['user_id'];
		$this->username = $_SESSION['user'];
		$this->new_message = [
			"post_id" => $this->post_id,
			"user_id" => $this->user_id,
			"username" => $this->username,
			"subject" => $this->subject,
			"message" => $this->message,
			"image" => $image
		];
        try {
            $this->checkFieldValues();
            $this->insertPost();
        } catch (Exception $e) {
            $this->error = $e->getMessage();
        }
	}
	public function checkFieldValues(){
		if(empty($this->username) || empty($this->subject) || empty($this->message) || empty($this->post_id) || empty($this->image)){
			$this->error = "Please fill all the necessary fields.";
			return false;
		} else {
			return true;
		}
	}
	private function subjectExist(){
		foreach($this->stored_message as $msg){
			if($this->subject == $msg['subject']){
				$this->error = "subject already taken, please choose a different one.";
				return true;
			}
		}
		return false;
	}
	private function insertPost(){
		if($this->subjectExist() == false){
			array_push($this->stored_message, $this->new_message);
			if(file_put_contents($this->storage, json_encode($this->stored_message, JSON_PRETTY_PRINT))){
				return $this->success = "Message Posted!";
			} else {
				return $this->error = "Something went wrong, please try again";
			}
		}
	}
}
?>