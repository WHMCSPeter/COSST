<?php
require_once('config.php');
if(!LOGGED_IN) {
	header("Location: ".$system_url."login?error=restricted");
	die();
}

if(isset($_POST['tid'])) {
	if(isset($_POST['resolve'])) {
		$tid = $core->EscapeString($_POST['tid']);
		$check = $tickets->checkTicketOwner($user_id, $tid);
		if(!$check) {
			header("Location: ".$system_url."error?code=update_ownership");
			die();
		}
		else
		{
			$update = $tickets->statusUpdate($tid, 3, $user_id);
			if($update) {
				header("Location: ".$system_url."tickets/".$tid);
				die();
			}
			else
			{
				header("Location: ".$system_url."error?code=status_update_fail");
				die();
			}
		}
	}
	else if(isset($_POST['reply'])) {
		$tid = $core->EscapeString($_POST['tid']);
		$message = $core->EscapeString($_POST['message']);
		$check = $tickets->checkTicketOwner($user_id, $tid);
		if(!$check) {
			header("Location: ".$system_url."error?code=update_ownership");
			die();
		}
		else
		{
			$update = $tickets->Reply($tid, $user_id, $message, NULL);
			if($update) {
				header("Location: ".$system_url."tickets/".$tid);
				die();
			}
			else
			{
				header("Location: ".$system_url."error?code=ticket_reply_fail");
				die();
			}
		}
	}
}
else
{
	header("Location: ".$system_url."error?code=no_tid");
	die();
}