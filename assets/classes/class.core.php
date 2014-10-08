<?php
class Core {
	
	function __construct($MySQLi){}
	
	function EscapeString($string = '')

	{
		global $MySQLi;
		return $MySQLi->real_escape_string(stripslashes(trim(htmlspecialchars($string))));
	}
	
	function Setting($var = '') {
		global $MySQLi;
		$query = "SELECT * FROM settings WHERE variable = '".$var."' LIMIT 1";
		$commit = $MySQLi->query($query);
		if($commit == false)
		{
			trigger_error("Could not retrieve setting for variable: ".$var.".");
		}
		else
		{
			$row = $commit->fetch_array();
			return $row['setting'];
		}
	}
	
	function Login($email = '', $password = '') {
		global $MySQLi;
		$query = "SELECT * FROM users WHERE email = '".$email."' LIMIT 1";
		$commit = $MySQLi->query($query);
		if($commit == false) {
			trigger_error("Could not log you in. Please contact support.");
		}
		else
		{
			$count = $commit->num_rows;
			if($count == 1) {
				$row = $commit->fetch_array();
				$pass = $row['password'];
				if($password == $pass) {
					$sechash = $this->generateRandomString();
					
					$query1 = "UPDATE users SET sechash = '".$sechash."' WHERE email = '".$row['email']."' LIMIT 1";
					$commit1 = $MySQLi->query($query1);
					
					setcookie("loggedin", true, time()+86400, "/");
					setcookie("id", $row['id'], time()+86400, "/");
					setcookie("sechash", $sechash, time()+86400, "/");
					return true;
				}
				else
				{
					return false;
				}
			}
			else if($count == 0) {
				$result = "noExist";
				return $result;
			}
		}
	}
	
	function generateRandomNumbers($length = '') {
		$characters = '0123456789';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}
	
	function generateRandomLetters($length = '') {
		$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}
	
	function generateRandomString($length = 12) {
		$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}
	
	function checkLoggedIn($id = '', $sechash = '') {
		global $MySQLi;
		$query = "SELECT * FROM users WHERE id = '".$id."' LIMIT 1";
		$commit = $MySQLi->query($query);
		if($commit == false) {
			trigger_error("Something went wrong validating your session. Please contact support.");
		}
		else
		{
			$count = $commit->num_rows;
			if($count == 1) {
				$row = $commit->fetch_array();
				if($row['sechash'] == $sechash) {
					return true;
				}
				else
				{
					return false;
				}
			}
				else
				{
					return false;
				}
		}
	}
	
	function UserInfo($id = '', $sechash = '', $col = '') {
		global $MySQLi;
		if($this->checkLoggedIn($id, $sechash)) {
			$query = "SELECT * FROM users WHERE id = '".$id."' LIMIT 1";
			$commit = $MySQLi->query($query);
			if($commit == false) {
				trigger_error("Could not retireve user info. Please contact support.");
			}
			else
			{
				$row = $commit->fetch_array();
				return $row[$col];
			}
		}
		else
		{
			header("Location: ./login?error=3");
			die();
		}
	}
	
	function Gravatar($id = '', $sechash = '') {
		$email = $this->UserInfo($id, $sechash, 'email');
		$hash = md5(strtolower(trim($email)));
		return $hash;
	}
}
?>