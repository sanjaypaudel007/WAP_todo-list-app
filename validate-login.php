<?php
include("logic/db-connection.php");
session_start();

$call = filter_input(INPUT_POST, 'call');
switch ($call) {
    case "Insert":
        userInsert();
        break;
    case "Login":
        userLogin();
        break;
    default:
        exit(0);
}

function userInsert() {
	global $db;
    $username = filter_input(INPUT_POST, 'username');
    $password = filter_input(INPUT_POST, 'password');
    $password_confirm = filter_input(INPUT_POST, 'password_confirm');
    $pass_hash = password_hash($password, PASSWORD_DEFAULT);
    $email = filter_input(INPUT_POST, 'email');
    $date = date('Y-m-d H:i:s');
    if ($password === $password_confirm) {
        $statement = $db->prepare("INSERT INTO users VALUES (NULL, :username, :password, :email, :created_date)");
        $statement->execute(array(":username" => $username, ":password" => $pass_hash, ":email" => $email, ":created_date" => $date));
        $_SESSION['error'] = 'User  has been registered..';
        unset($_SESSION['username']);
        unset($_SESSION['email']);
        header("Location:login.php");
    } else {
        $_SESSION['msg'] = 'Password donot match..';
        $_SESSION['username'] = filter_input(INPUT_POST, 'username');
        $_SESSION['email'] = filter_input(INPUT_POST, 'email');
        header("Location:signup.php");
    }
}

function userLogin() {
	global $db;
	
    $username = filter_input(INPUT_POST, 'username');
    $password = filter_input(INPUT_POST, 'password');
    $statement = $db->prepare("SELECT * FROM users where username= :username");
    $statement->execute(array(':username' => $username));
    $user = $statement->fetch();
    $hash = $user["password"];
    if (!password_verify($password, $hash)) {
        $error = "Invalid username or password";
        $_SESSION['error'] = $error;
		 header("Location:login.php");
    } else {
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['user_id'] = $user['user_id'];
        header("Location:index.php");
    }
}
