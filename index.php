<?php
require_once('config.php');
$page = 'home';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Support Center &raquo; <?php echo $sitename; ?></title>
    <?php require_once('assets/inc/inc.head.php'); ?>
  </head>

  <body>

    <?php require_once('assets/inc/inc.nav.php'); ?>

    <div class="jumbotron">
      <div class="container">
        <h1><?php echo $lang['frontpage_header'];
		if(LOGGED_IN) {
			echo ', '.$user_name.'.';
		}
		else
		{
			echo '.';
		}
		?></h1>
        <p><?php
		if(!LOGGED_IN) {
        echo $lang['frontpage_description'];
		}
		else
		{
			$open = $tickets->ticketCount($user_id, '1');
			$awaiting_response = $tickets->ticketCount($user_id, '2');
			$resolved = $tickets->ticketCount($user_id, '3');
			echo 'You have '.$open.' open tickets, '.$awaiting_response.' awaiting your response and '.$resolved.' resolved tickets.';
		}
		?></p>
        <p><a class="btn btn-primary btn-lg" role="button"><?php echo $lang['kb_link']; ?> &raquo;</a></p>
      </div>
    </div>

    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-4">
          <h2><?php echo $lang['heading1']; ?></h2>
          <p><?php echo $lang['subtext1']; ?></p>
          <p><a class="btn btn-default" href="#" role="button"><?php echo $lang['linktext1']; ?> &raquo;</a></p>
        </div>
        <div class="col-md-4">
          <h2><?php echo $lang['heading2']; ?></h2>
          <p><?php echo $lang['subtext2']; ?></p>
          <p><a class="btn btn-default" href="#" role="button"><?php echo $lang['linktext2']; ?> &raquo;</a></p>
       </div>
        <div class="col-md-4">
          <h2><?php echo $lang['heading3']; ?></h2>
          <p><?php echo $lang['subtext3']; ?></p>
          <p><a class="btn btn-default" href="#" role="button"><?php echo $lang['linktext3']; ?> &raquo;</a></p>
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