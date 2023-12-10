<?php 
class RegisterUser{
	// Class properties
	private $username;
	private $raw_password;
	private $encrypted_password;
	private $user_type;
	private $user_id;
	private $name;
	private $email;

	public $error;
	public $success;
	private $storage = "./Data/users.json";
	private $stored_users = [];
	private $new_user; // array 


	public function __construct($username, $password, $user_type, $name, $email){

		// Trim and sanitize username
		$this->username = filter_var(trim($username), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	
		// Trim and sanitize password, then hash it
		$this->raw_password = filter_var(trim($password), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$this->encrypted_password = password_hash($this->raw_password, PASSWORD_DEFAULT);
		
		// Trim and sanitize user type
		$this->user_type = filter_var(trim($user_type), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		// Trim and sanitize name
		$this->name = filter_var(trim($name), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		// Trim and sanitize email
		$this->email = filter_var(trim($email), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	
		// Load stored users from JSON file
		if(file_exists($this->storage)){
			$this->stored_users = json_decode(file_get_contents($this->storage), true);
		}

		 // Generate new user ID
		$this->user_id = count($this->stored_users) + 1;

		// Create a new user array with a generated user ID
		$this->new_user = [
			"user_id" => $this->user_id,
			"name" => $this->name,
			"username" => $this->username,
			"password" => $this->encrypted_password,
			"email" => $this->email,
			"usertype" => $this->user_type,
		];
	
		// Check field values and insert user if valid
		if($this->checkFieldValues()){
			$this->insertUser();
		}
	}
	


/**
 * Checks the validity of the input field values before inserting a new user.
 *
 * This method ensures that both the username and password fields are not empty.
 * If either field is empty, an error message is set, and the method returns false.
 * Otherwise, it returns true, indicating that the input fields are valid.
 *
 * @return bool Returns true if both username and password fields are not empty, false otherwise.
 */
	public function checkFieldValues(){
		if(empty($this->username) || empty($this->raw_password) || empty($this->user_type) || empty($this->email)){
			$this->error = "Please fill all the necessary fields.";
			return false;
		} else {
			return true;
		}
	}



/**
 * Checks if the given username already exists in the stored user data.
 *
 * This method iterates through the existing users and compares the provided
 * username with each stored username. If a match is found, an error message
 * is set, indicating that the username is already taken.
 *
 * @return bool Returns true if the username already exists, false otherwise.
 */
	private function usernameExists(){
		foreach($this->stored_users as $user){
			if($this->username == $user['username']){
				$this->error = "Username already taken, please choose a different one.";
				return true;
			}
		}
		return false;
	}
	private function emailExists(){
		foreach($this->stored_users as $user){
			if($this->email == $user['email']){
				$this->error = "email already taken, please choose a different one.";
				return true;
			}
		}
		return false;
	}

/**
 * Inserts a new user into the stored user data if the username is not taken.
 *
 * This method calls the usernameExists() method to check if the provided
 * username is available. If the username is available, the new user is added
 * to the stored users array, and the updated data is written back to the storage file.
 * It returns a success message if the insertion is successful and an error message
 * otherwise.
 *
 * @return string Returns a success message on successful user insertion,
 *                or an error message if the insertion fails.
 */
	private function insertUser(){
		if($this->usernameExists() == false && $this->emailExists() == false){
			array_push($this->stored_users, $this->new_user);
			if(file_put_contents($this->storage, json_encode($this->stored_users, JSON_PRETTY_PRINT))){
				return $this->success = "Your registration was successful";
			} else {
				return $this->error = "Something went wrong, please try again";
			}
		}
	}




} // end of class