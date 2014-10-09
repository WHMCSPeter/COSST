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
            <p><?php echo $lang['dashboard_text']; ?></p>
            <h3 class="page-header">What do you want to do?</h3>
            <p>
            	<a href="./open"><button class="btn btn-lg btn-primary">Open a Ticket</button></a>
                <a href="./tickets"><button class="btn btn-lg btn-primary">View Tickets</button></a>
                <a href="./account"><button class="btn btn-lg btn-primary">Edit Your Account</button></a>
            </p>
        </div>
        
        <div class="col-md-6">
        	<h2 class="page-header">Latest News</h2>
            <?php
				echo $frontend->dashboardNews();
			?>
            <p style="float:right"><a href="./news"><?php echo $lang['link_morenews']; ?></a></p>
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