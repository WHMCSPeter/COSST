<?php
$host = 'localhost'; //The hostname/IP of your MySQL server.
$dbuser = 'root'; //The username to connect to your database.
$dbpw = 'qw72110929'; //The password to connect to your database.
$database = 'cosst'; //The name of your database.

//Error reporting - Comment out this line for debugging purposes.
//error_reporting(0);

//Establish the database connection.
$MySQLi = new MySQLi($host, $dbuser, $dbpw, $database);

//Check if the connection works.
//TO BE CODED

//Import classes.
require_once('assets/classes/class.core.php');
require_once('assets/classes/class.tickets.php');
require_once('assets/classes/class.frontend.php');

//Initialize classes.
$core = new Core($MySQLi);
$tickets = new Tickets($MySQLi);
$frontend = new Frontend($MySQLi);

//Set global variables.
$sitename = $core->Setting('site_name');
$language = $core->Setting('lang');
$company = $core->Setting('company_name');
$system_url = $core->Setting('system_url');

//Set the language.
require_once('assets/lang/lang.'.$language.'.php');

//Work out if logged in and define variables if so.
if(isset($_COOKIE['loggedin']) && isset($_COOKIE['id']) && isset($_COOKIE['sechash'])) {
	if($core->checkLoggedIn($core->EscapeString($_COOKIE['id']), $core->EscapeString($_COOKIE['sechash']))) {
		define("LOGGED_IN", true);
		$user_name = $core->UserInfo($core->EscapeString($_COOKIE['id']), $core->EscapeString($_COOKIE['sechash']), 'first_name');
		$user_id = $core->EscapeString($_COOKIE['id']);
		$sechash = $core->EscapeString($_COOKIE['sechash']);
	}
	else
	{
		define("LOGGED_IN", false);
	}
}
else
{
	define("LOGGED_IN", false);
}