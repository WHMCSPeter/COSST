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
        	<h1>Dashboard</h1>
        </div>
      </div>

      <hr>
      
      <div class="row">
      	<div class="col-md-3">
        	<h2>Something</h2><hr>
        </div>
        
        <div class="col-md-3">
        	<h2>Something else</h2><hr>
        </div>
        
        <div class="col-md-3">
        	<h2>Latest News</h2><hr>
            <?php
			echo $frontend->dashboardNews();
			?>
            <!-- <p><strong>First News Article</strong> - <a href="">Read More</a><br />
            Something interesting would be written here... It may even need a "read more" button.</p>
            <hr>
            <p><strong>First News Article</strong> - <a href="">Read More</a><br />
            Something interesting would be written here... It may even need a "read more" button.</p> -->
        </div>
        
        <div class="col-md-3">
        	<h2>Actions</h2><hr>
            <a class="btn btn-lg btn-default">View Your Tickets</a><br><br>
            <a class="btn btn-lg btn-default">Open a Ticket</a><br><br>
            <a class="btn btn-lg btn-default">Edit Your Account</a>
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