<?php
class Login {
	private $db_connection = null;
	public $errors = array();
	public $messages = array();

	public function __construct() {
		session_start();
		if(isset($_GET["logout"])) {
			$this->doLogout();
		} elseif(isset($_POST["login"])) {
			$this->doLoginWithPostData();
		}
	}
	private function doLoginWithPostData() {
		if(!empty($_POST['username']) && !empty($_POST['password'])) {
			$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		}
		if(!$this->db_connection->connect_errno) {
			$username = $this->db_connection->real_escape_string($_POST['username']);
			$sql = "SELECT *
			       FROM users
				WHERE username = '". $username . "';";
			$result_of_login_check = $this->db_connection->query($sql);
			if($result_of_login_check->num_rows == 1) {
				$result_row = $result_of_login_check->fetch_object();
				if(password_verify($_POST['password'], $result_row->password)) {
					$_SESSION['username'] = $result_row->username;	
					$_SESSION['login_status'] = 1;	
				} else {
					$this->errors[] = "Wrong Password";
				}
			} else {
				$this->errors[] = "User doesnt exist";
			}	
		} else {
			$this->errors[] = "Database not reached";
		}
	}

	public function doLogout() {
		$_SESSION = array();
		session_destroy();
		$this->messages[] = "Logged out";
	}
	public function isUserLoggedIn() {
		if(isset($_SESSION['login_status']) AND $_SESSION['login_status'] == 1) {
			return true;
		}
		return false;
	}
}
