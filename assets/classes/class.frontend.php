<?php
class Frontend {
	
	function __construct($MySQLi) {}
	
	function dashboardNews() {
		global $MySQLi;
		$query = "SELECT * FROM articles WHERE published = '1' ORDER BY created DESC LIMIT 2";
		$commit = $MySQLi->query($query);
		if($commit == false) {
			trigger_error("Could not retrieve news articles.");
		}
		else
		{
			$count = $commit->num_rows;
			if($count == 0) {
				echo '<p><strong>No articles to display!</strong><br />';
            	echo 'Stay tuned! Articles will be displayed here as and when they are published!</p>';
			}
			else
			{
				while($row = $commit->fetch_assoc()) {
					$created = strtotime($row['created']);
					$date = date('d/m/Y', $created);
					echo '<div class="panel panel-default">';
					echo '<div class="panel-heading">';
					echo '<h3 class="panel-title"><strong>'.$row['title'].'</strong></h3>';
					echo '</div>';
					echo '<div class="panel-body">';
					echo '<p>'.$row['short_article'].'</p>';
					echo '<p><span class="label label-default">'.$date.' by '.$this->staffDetails($row['author'], 'first_name').' '.$this->staffDetails($row['author'], 'last_name').'</span><span style="float: right;" class="btn btn-sm btn-default"><a href="./news/'.$row['slug'].'">Read More</a></span></p>';
					echo '</div>';
					echo '</div>';
				}
			}
		}
	}
	
	function staffDetails($sid = '', $col = '') {
		global $MySQLi;
		$query = "SELECT * FROM staff WHERE id = '".$sid."' LIMIT 1";
		$commit = $MySQLi->query($query);
		if($commit == false) {
			trigger_error("Could not retrieve staff details.");
		}
		else
		{
			$row = $commit->fetch_array();
			return $row[$col];
		}
	}
	
	function listDepartments() {
		global $MySQLi;
		$query = "SELECT * FROM departments WHERE hidden = '0' ORDER BY name";
		$commit = $MySQLi->query($query);
		if($commit == false) {
			trigger_error("Could not retrieve departments. Please contact support.");
		}
		else
		{
			while($row = $commit->fetch_assoc()) {
				echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
			}
		}
	}
	
	function listPriorities() {
		global $MySQLi;
		$query = "SELECT * FROM priorities WHERE hidden = '0'";
		$commit = $MySQLi->query($query);
		if($commit == false) {
			trigger_error("Could not retrieve priorities. Please contact support.");
		}
		else
		{
			while($row = $commit->fetch_assoc()) {
				echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
			}
		}
	}
	
	function kb_categories() {
		global $MySQLi;
		$query = "SELECT * FROM kb_categories WHERE hidden = '0'";
		$commit = $MySQLi->query($query);
		if($commit == false) {
			trigger_error("Could not retrieve KB categories. Please contact support.");
		}
		else
		{
			while($row = $commit->fetch_assoc()) {
				echo '<a href="knowledgebase/categories/'.$row['slug'].'">'.$row['name'].'</a><br>';
			}
		}
	}
	
	function featured_kb($limit = '') {
		global $MySQLi;
		$query = "SELECT * FROM kb_articles ORDER BY rand() LIMIT ".$limit."";
		$commit = $MySQLi->query($query);
		if($commit == false) {
			trigger_error("Could not retrieve KB articles. Please contact support.");
		}
		else
		{
			while($row = $commit->fetch_assoc()) {
				echo '<div class="panel panel-default">';
				echo '<div class="panel-heading">';
				echo '<h3 class="panel-title"><a href="knowledgebase/article/'.$row['id'].'"><strong>'.$row['title'].'</strong></a> <span><a href="knowledgebase/categories/'.$this->kbCategoryInfoByID($row['category'], 'slug').'">'.$this->kbCategoryInfoByID($row['category'], 'name').'</a></span></h3>';
				echo '</div>';
				echo '<div class="panel-body">';
				echo substr($row['body'], 0, 255);
				if(strlen($row['body']) > 255) {
					echo '...';
				}
				echo '<a href="#" style="float: right;"><button class="btn btn-sm btn-primary">Read More...</button></a>';
				echo '</div>';
				echo '</div>';
			}
		}
	}
	
	function kbCategoryInfoByID($id = '', $col = '') {
		global $MySQLi;
		$query = "SELECT * FROM kb_categories WHERE id = '".$id."' LIMIT 1";
		$commit = $MySQLi->query($query);
		if($commit == false) {
			trigger_error("Could not retrive category name. Please contact support.");
		}
		else
		{
			$row = $commit->fetch_array();
			return $row[$col];
		}
	}
	
	function displayKBCategory($slug = '') {
		global $MySQLi;
		$query = "SELECT * FROM kb_categories WHERE slug = '".$slug."' LIMIT 1";
		$commit = $MySQLi->query($query);
		if($commit == false) {
			trigger_error("Could not locate category. Please contact support.");
		}
		else
		{
			$count = $commit->num_rows;
			if($count == 0) {
				return false;
			}
			else
			{
				$row = $commit->fetch_array();
				$cat = $row['id'];
				$query1 = "SELECT * FROM kb_articles WHERE category = '".$cat."'";
				$commit1 = $MySQLi->query($query1);
				if($commit1 == false) {
					trigger_error("Could not retrieve articles");
				}
				else
				{
					$count1 = $commit1->num_rows;
					if($count1 == 0) {
						echo '<p class="alert alert-danger"><strong>Error:</strong> There are currently no articles in this category.</p>';
						return true;
					}
					else
					{
						echo 'Category stuff!';
						echo $count1;
						echo $cat;
						return true;
					}
				}
			}
		}
	}
	
	function categoryInfo($slug = '', $col = '') {
		global $MySQLi;
		$query = "SELECT * FROM kb_categories WHERE slug = '".$slug."' LIMIT 1";
		$commit = $MySQLi->query($query);
		if($commit == false) {
			trigger_error("Could not retrieve category info. Please contact support.");
		}
		else
		{
			$count = $commit->num_rows;
			if($count == 0) {
				return false;
			}
			else
			{
				$row = $commit->fetch_array();
				return $row[$col];
			}
		}
	}
}
?>