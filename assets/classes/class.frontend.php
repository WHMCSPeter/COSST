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
					//echo '<p><strong>'.$row['title'].'</strong> - <a href="./news/'.$row['slug'].'">Read More</a><br />';
            		//echo $row['short_article'].'<br><span class="label label-default" style="float: right">Published on '.$date.'</span></p><hr>';
					echo '<div class="panel panel-default">';
					echo '<div class="panel-heading">';
					echo '<h3 class="panel-title"><strong>'.$row['title'].'</strong></h3>';
					echo '</div>';
					echo '<div class="panel-body">';
					echo '<p>'.$row['short_article'].'</p>';
					echo '<p><span class="label label-default">'.$date.'</span><span style="float: right;" class="btn btn-sm btn-default"><a href="./news/'.$row['slug'].'">Read More</a></span></p>';
					echo '</div>';
					echo '</div>';
				}
			}
		}
	}
	
}
?>