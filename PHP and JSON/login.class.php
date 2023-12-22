<?php 
class LoginUser{
	// class properties
	private $username;
	private $password;
	public $error;
	public $success;
	private $storage = "./Data/users.json";
	private $stored_users = [];

	// class methods
	public function __construct($username, $password){
		$this->username = $username;
		$this->password = $password;
		if(file_exists($this->storage)){
			$this->stored_users = json_decode(file_get_contents($this->storage), true);
		}
		$this->login();
	}


	private function login(){
		foreach ($this->stored_users as $user) {
			if($user['username'] == $this->username){
				if(password_verify($this->password, $user['password'])){
					session_start();
					$_SESSION['user'] = $this->username;
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['usertype'] = $user['usertype'];
					session_regenerate_id(true);
					header("location: account.php"); exit();
				}
				return $this->error = "Invalid password. Please check your login credentials and try again.";
			}
		}
		return $this->error = "Invalid username. Please check your login credentials and try again.";
	}
}