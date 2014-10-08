<?php
require_once('config.php');
if(!LOGGED_IN) {
	header("Location: ".$system_url."login?msg=openticket");
	die();
}
?>