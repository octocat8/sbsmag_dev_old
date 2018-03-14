<?php

class Registration {
    private $db_connection = null;
    public $errors = array();
    public $messages = array();
    public function __construct() {
        if (isset($_POST["register"])) {
            $this->registerNewUser();
        }
    }
    private function registerNewUser()
    {
        if (empty($_POST['username'])) {
            $this->errors[] = "Empty Username";
        } elseif (empty($_POST['user_class'])) {
            $this->errors[] = "Empty Class";
        } elseif (empty($_POST['password']) || empty($_POST['password_repeat'])) {
            $this->errors[] = "Empty Password";
        } elseif ($_POST['password'] !== $_POST['password_repeat']) {
            $this->errors[] = "Password and password repeat are not the same";
        } elseif (strlen($_POST['password']) < 6) {
            $this->errors[] = "Password has a minimum length of 6 characters";
        } elseif (strlen($_POST['username']) > 64 || strlen($_POST['username']) < 2) {
            $this->errors[] = "Username cannot be shorter than 2 or longer than 64 characters";
        } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['username'])) {
            $this->errors[] = "Username does not fit the name scheme: only a-Z and numbers are allowed, 2 to 64 characters";
        } elseif (!empty($_POST['username'])
            && strlen($_POST['username']) <= 64
            && strlen($_POST['username']) >= 2
            && preg_match('/^[a-z\d]{2,64}$/i', $_POST['username'])
            && !empty($_POST['user_class'])
            && !empty($_POST['password'])
            && !empty($_POST['password_repeat'])
            && ($_POST['password'] === $_POST['password_repeat'])
        ) {
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if (!$this->db_connection->connect_errno) {
                $username = $this->db_connection->real_escape_string(strip_tags($_POST['username'], ENT_QUOTES));
                $user_class = $this->db_connection->real_escape_string(strip_tags($_POST['user_class'], ENT_QUOTES));
                $password = $_POST['password'];
                // crypt the user's password with PHP 5.5's password_hash() function, results in a 60 character
                // hash string. the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using
                // PHP 5.3/5.4, by the password hashing compatibility library
                $password_hash = password_hash($password, PASSWORD_DEFAULT);

                $sql = "SELECT * FROM users WHERE username = '" . $username . "';";
                $query_check_username = $this->db_connection->query($sql);

                if ($query_check_username->num_rows == 1) {
                    $this->errors[] = "Sorry, that username is already taken.";
                } else {
                    // write new user's data into database
                    $sql = "INSERT INTO users (username, password, class)
                            VALUES('" . $username . "', '" . $password_hash . "', '". $user_class."');";
                    $query_new_user_insert = $this->db_connection->query($sql);

                    // if user has been added successfully
                    if ($query_new_user_insert) {
                        $this->messages[] = "Your account has been created successfully. You can now log in.";
                    } else {
                        $this->errors[] = "Sorry, your registration failed. Please go back and try again.";
                    }
                }
            } else {
                $this->errors[] = "Sorry, no database connection.";
            }
        } else {
            $this->errors[] = "An unknown error occurred.";
        }
    }
}
