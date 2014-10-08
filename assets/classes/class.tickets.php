<?php
class Tickets {
	
	function __construct($MySQLi) {}
	
	function ticketCount($uid = '', $status = '') {
		global $MySQLi;
		if($status == NULL) {
			$query = "SELECT * FROM tickets WHERE user_id = '".$uid."'";
		}
		else
		{
			$query = "SELECT * FROM tickets WHERE user_id = '".$uid."' AND status = '".$status."'";
		}
		$commit = $MySQLi->query($query);
		if($commit == false) {
			trigger_error("Couldn't retrieve stats. Please contact support.");
		}
		else
		{
			$row = $commit->num_rows;
			return $row;
		}
	}
	
	function ticketList($uid = '', $from = '', $limit = '') {
		global $MySQLi;
		$query = "SELECT * FROM tickets WHERE user_id = '".$uid."' LIMIT 2";
		$commit = $MySQLi->query($query);
		if($commit == false) {
			trigger_error("Could not retrieve tickets. Please contact support.");
		}
		else
		{
			while($row = $commit->fetch_assoc()) {
				$class = $this->StatusByID($row['status'], 'class');
				$updated = strtotime($row['last_updated']);
				$date = date('h:iA - d/m/Y', $updated);
				if($class != NULL) {
					echo '<tr class="'.$class.'">';
				}
				else
				{
					echo '<tr>';
				}
				echo '<td><a href="./tickets/'.$row['ticket_id'].'">'.$row['ticket_id'].'</a></td>';
				echo '<td>'.$row['subject'].'</td>';
				echo '<td>'.$this->DepartmentByID($row['dept_id']).'</td>';
				echo '<td>'.$this->StatusByID($row['status'], 'name').'</td>';
				echo '<td>'.$date.'</td>';
				echo '<td><a href="">Close</a></td>';
			}
		}
	}
	
	function DepartmentByID($id = '') {
		global $MySQLi;
		$query = "SELECT * FROM departments WHERE id = '".$id."' LIMIT 1";
		$commit = $MySQLi->query($query);
		if($commit == false) {
			trigger_error("Could not retrieve department names.");
		}
		else
		{
			$row = $commit->fetch_array();
			return $row['name'];
		}
	}
	
	function StatusByID($id = '', $col = '') {
		global $MySQLi;
		$query = "SELECT * FROM statuses WHERE id = '".$id."' LIMIT 1";
		$commit = $MySQLi->query($query);
		if($commit == false) {
			trigger_error("Could not retrieve department names.");
		}
		else
		{
			$row = $commit->fetch_array();
			return $row[$col];
		}
	}
	
	function ticketInfo($tid = '', $col = '') {
		global $MySQLi;
		$query = "SELECT * FROM tickets WHERE ticket_id = '".$tid."' LIMIT 1";
		$commit = $MySQLi->query($query);
		if($commit == false) {
			trigger_error("Could not retrieve department names.");
		}
		else
		{
			$row = $commit->fetch_array();
			return $row[$col];
		}
	}
	
	function submitterDetails($uid = '', $col ='', $staff = '') {
		global $MySQLi;
		if(!$staff) {
			$query = "SELECT * FROM users WHERE id = '".$uid."' LIMIT 1";
		}
		else if($staff) {
			$query = "SELECT * FROM staff WHERE id = '".$uid."' LIMIT 1";
		}
		$commit = $MySQLi->query($query);
		if($commit == false) {
			trigger_error("Could not get submitter information.");
		}
		else
		{
			$row = $commit->fetch_array();
			return $row[$col];
		}
	}
	
	function ticketHistory($tid = '') {
		global $MySQLi;
		$query = "SELECT * FROM tickets WHERE ticket_id = '".$tid."' LIMIT 1";
		$commit = $MySQLi->query($query);
		if($commit == false) {
			trigger_error("Could not retrieve ticket details. Please contact support.");
		}
		else
		{
			while($row = $commit->fetch_array()) {
				$submitter = $this->submitterDetails($row['user_id'], 'first_name', false).' '.$this->submitterDetails($row['user_id'], 'last_name', false);
				$gravatar = md5(strtolower(trim($this->submitterDetails($row['user_id'], 'email', false))));
				$created = date('jS M Y - h:iA', strtotime($row['created']));
				echo '<div class="panel panel-primary">';
              	echo '<div class="panel-heading">';
              	echo '<img src="http://www.gravatar.com/avatar/'.$gravatar.'?size=35" height="35px" width="35px" alt="Profile Image" /> <strong>'.$submitter.' | User</strong> <span>'.$created.'</span>';
              	echo '</div>';
              	echo '<div class="panel-body">';
              	echo '<p>'.$row['initial_message'].'</p>';
				echo '<p>-----<br />IP: '.$row['sent_ip'].'</p>';
              	echo '</div>';
            	echo '</div>';
			}
		}
	}
	
	function ticketResponses($tid = '') {
		global $MySQLi;
		$query = "SELECT * FROM responses WHERE ticket_id = '".$tid."' ORDER BY id";
		$commit = $MySQLi->query($query);
		if($commit == false) {
			trigger_error("Could not retrieve ticket details. Please contact support.");
		}
		else
		{
			while($row = $commit->fetch_array()) {
				$created = date('jS M Y - h:iA', strtotime($row['created']));
				
				if($row['user_id'] != NULL){
					$gravatar = md5(strtolower(trim($this->submitterDetails($row['user_id'], 'email'))));
					$submitter = $this->submitterDetails($row['user_id'], 'first_name').' '.$this->submitterDetails($row['user_id'], 'last_name');
					echo '<div class="panel panel-primary">';
					echo '<div class="panel-heading">';
            	  	echo '<img src="http://www.gravatar.com/avatar/'.$gravatar.'?size=35" height="35px" width="35px" alt="Profile Image" /> <strong>'.$submitter.' | User</strong> <span>'.$created.'</span>';
              		echo '</div>';
              		echo '<div class="panel-body">';
              		echo '<p>'.$row['message'].'</p>';
              		echo '</div>';
            		echo '</div>';
				}
				else if($row['staff_id'] != NULL) {
					$gravatar = md5(strtolower(trim($this->submitterDetails($row['staff_id'], 'email', true))));
					$submitter = $this->submitterDetails($row['staff_id'], 'first_name', true).' '.$this->submitterDetails($row['staff_id'], 'last_name', true);
					$created = date('jS M Y - h:iA', strtotime($row['created']));
					echo '<div class="panel panel-info">';
					echo '<div class="panel-heading">';
            	  	echo '<img src="http://www.gravatar.com/avatar/'.$gravatar.'?size=35" height="35px" width="35px" alt="Profile Image" /> <strong>'.$submitter.' | Staff</strong> <span>'.$created.'</span>';
              		echo '</div>';
              		echo '<div class="panel-body">';
              		echo '<p>'.$row['message'].'</p>';
              		echo '</div>';
            		echo '</div>';
				}
				else if($row['staff_id'] == NULL && $row['user_id'] == NULL) {
					$created = date('jS M Y - h:iA', strtotime($row['created']));
					echo '<div class="panel panel-danger">';
					echo '<div class="panel-heading">';
            	  	echo '<img src="../assets/images/system_post.png" height="35px" width="35px" alt="Profile Image" /> <strong>System</strong> <span>'.$created.'</span>';
              		echo '</div>';
              		echo '<div class="panel-body">';
              		echo '<p><strong>'.$row['message'].'</strong></p>';
              		echo '</div>';
            		echo '</div>';
				}
			}
		}
	}
	
	function checkTicketID($tid = '') {
		global $MySQLi;
		$query = "SELECT * FROM tickets WHERE ticket_id = '".$tid."' LIMIT 1";
		$commit = $MySQLi->query($query);
		if($commit == false) {
			trigger_error("Could not verify if ticket exists.");
		}
		else
		{
			$result = $commit->num_rows;
			if($result == 1) {
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	
	function checkTicketOwner($uid = '', $tid = '') {
		global $MySQLi;
		$query = "SELECT * FROM tickets WHERE ticket_id = '".$tid."' LIMIT 1";
		$commit = $MySQLi->query($query);
		if($commit == false) {
			trigger_error("Could not verify ownership of the ticket.");
		}
		else
		{
			$row = $commit->fetch_array();
			$user_id = $row['user_id'];
			if($uid == $user_id) {
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	
	function statusUpdate($tid = '', $status_id = '', $by = '') {
		global $MySQLi;
		$query = "UPDATE tickets SET status = '".$status_id."' WHERE ticket_id = '".$tid."' LIMIT 1";
		$query1 = "INSERT INTO `responses` (`ticket_id`, `created`, `message`) VALUES ('".$tid."', '".date('Y-m-d H:i:s')."', 'Ticket marked as \"".$this->StatusByID($status_id, 'name')."\" by ".$this->submitterDetails($by, 'first_name', false)." ".$this->submitterDetails($by, 'last_name', false).".')";
		$commit = $MySQLi->query($query);
		$commit1 = $MySQLi->query($query1);
		if($commit == false) {
			trigger_error("Could not update the status of ticket ID: ".$tid.". Please contact support.");
		}
		else
		{
			return true;
		}
	}
	
	function Reply($tid = '', $uid = '', $message = '', $staff = '') {
		global $MySQLi;
		$created = date('Y-m-d H:i:s');
		$ip = $_SERVER['REMOTE_ADDR'];
		$query = "INSERT INTO `responses` (`ticket_id`, `user_id`, `created`, `message`, `sent_ip`) VALUES ('".$tid."', '".$uid."', '".$created."', '".$message."', '".$ip."')";
		$commit = $MySQLi->query($query);
		if($commit == false) {
			trigger_error("Could not save your reply. Please contact support.");
		}
		else
		{
			return true;
		}
	}
}
?>