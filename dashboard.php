<?php
require_once('config.php');
$page = 'dashboard';
if(!LOGGED_IN) {
	header("Location: ".$system_url."login?error=restricted");
	die();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
  	<title>Dashboard &raquo; <?php echo $sitename; ?></title>
    <?php require_once('assets/inc/inc.head.php'); ?>
  </head>

  <body>

    <?php require_once('assets/inc/inc.nav.php'); ?>

    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-4 col-md-offset-4" style="text-align: center">
        	<h1><?php echo $lang['title_dashboard']; ?></h1>
        </div>
      </div>

      <hr>
      
      <div class="row">
      	<div class="col-md-6">
        	<h2 class="page-header">Welcome, <?php echo $user_name; ?>.</h2>
            <p>This is some paragraph text.</p>
            <h3 class="page-header">What do you want to do?</h3>
            <p><button class="btn btn-lg btn-primary">First Link</button></p>
        </div>
        
        <div class="col-md-6">
        	<h2 class="page-header">Latest News</h2>
            <?php
				echo $frontend->dashboardNews();
			?>
            <p style="float:right"><a href="./news">More News &raquo;</a></p>
            <!-- <p><strong>First News Article</strong> - <a href="">Read More</a><br />
            Something interesting would be written here... It may even need a "read more" button.</p>
            <hr>
            <p><strong>First News Article</strong> - <a href="">Read More</a><br />
            Something interesting would be written here... It may even need a "read more" button.</p> -->
        </div>
      </div>
      
      <hr>

      <footer>
        <?php require_once('assets/inc/inc.footer.php'); ?>
      </footer>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="<?php echo $system_url; ?>assets/js/bootstrap.min.js"></script>
  </body>
</html>