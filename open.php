<?php
require_once('config.php');
$page = 'dashboard';
if(!LOGGED_IN) {
	header("Location: ".$system_url."login?error=openticket");
	die();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
  	<title>Open a Ticket &raquo; <?php echo $sitename; ?></title>
    <?php require_once('assets/inc/inc.head.php'); ?>
  </head>

  <body>

    <?php require_once('assets/inc/inc.nav.php'); ?>

    <div class="container">
    <?php if(!isset($_POST['open-ticket'])) { ?>
      <div class="row">
      	<div class="col-md-12">
        	<h1>Open a Ticket</h1>
        </div>
        <hr>
        <div class="col-md-12">
        	<form class="text-center" role="form" action="./open" method="post">
            	<div class="row">
                <div class="col-md-4">
                	<div class="form-group">
                      <div class="input-group">
                        <div class="input-group-addon">Name</div>
                        <input class="form-control" type="text" placeholder="<?php echo $core->UserInfo($user_id, $sechash, 'first_name').' '.$core->UserInfo($user_id, $sechash, 'last_name'); ?>" disabled>
                      </div>
                    </div>
                 </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-addon">Email Address</div>
                        <input class="form-control" type="email" placeholder="<?php echo $core->UserInfo($user_id, $sechash, 'email'); ?>" disabled>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-addon">IP Address</div>
                        <input class="form-control" type="text" placeholder="<?php echo $_SERVER['REMOTE_ADDR']; ?>" disabled>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3 col-md-offset-3">
                	<div class="form-group">
                      <div class="input-group">
                        <div class="input-group-addon">Department</div>
                        <select class="form-control" name="dept">
                        	<option >Please select...</option>
                            <?php $frontend->listDepartments(); ?>
                        </select>
                      </div>
                    </div>
                  </div>
                   <div class="col-md-3">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-addon">Priority</div>
                        <select class="form-control" name="priority">
                        	<option >Please select...</option>
                            <?php $frontend->listPriorities(); ?>
                        </select>
                      </div>
                    </div>
                   </div>
                </div>
                <div class="row">
                <div class="col-md-8 col-md-offset-2">
                	<div class="form-group">
                      <div class="input-group">
                        <div class="input-group-addon">Subject</div>
                        <input class="form-control" type="text" placeholder="Something is broken..." name="subject">
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-addon">Message</div>
                        <textarea class="form-control" name="message" placeholder="Please provide as much information as possible..." rows="5"></textarea>
                      </div>
                    </div>
                    <a href="./" class="btn btn-danger btn-lg">&laquo; Return to Dashboard</a> &nbsp; <input type="submit" class="btn btn-lg btn-success" name="open-ticket" value="Open Ticket &raquo;" />
                </div>
            </form>
        </div>
      </div>
      </div>
      <?php } else {
		  $create = $core->createTicket($user_id, $_POST['dept'], '1', $_POST['subject'], $_POST['message'], $_SERVER['REMOTE_ADDR']);
		  if(!$create) {
			  header("Location: ./error?code=createticket");
			  die();
		  }
		  else
		  {
		  ?>
    		<div class="row">
            	<div class="col-md-12">
                	<p class="page-header">Open a Ticket</p>
                </div>
            </div>
            <div class="row">
            	<div class="col-md-6 col-md-offset-3">
                	<p class="alert alert-success">Your ticket regarding "<strong><?php echo $create['subject'];?></strong>" has been created with the ID: <strong><?php echo $create['ticket_id']; ?></strong>. You may now <a href="./tickets/<?php echo $create['ticket_id']; ?>">click here to view it</a>.</p>
                </div>
            </div>
      <?php }
	  }
	  ?>
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