<?php
require_once('config.php');
$page = 'my_tickets';
if(!LOGGED_IN) {
	header("Location: ".$system_url."login?error=restricted");
	die();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
  	<title>Support Center &raquo; <?php echo $sitename; ?></title>
    <?php require_once('assets/inc/inc.head.php'); ?>
  </head>

  <body>

    <?php require_once('assets/inc/inc.nav.php'); ?>

    <div class="container">
      <!-- Example row of columns -->
      <?php
	  if(!isset($_GET['tid'])) {
	  ?>
      <div class="row">
      	<div class="col-md-3">
        	<h1>Open Ticket</h1>
            <p><a href="../open"><button class="btn btn-lg btn-success">Open New Ticket</button></a></p>
            <h1>Ticket Statistics</h1>
            <form>
				<div class="input-group">
                	<span class="input-group-addon">Open Tickets</span>
                    <input type="text" class="form-control" placeholder="<?php echo $tickets->ticketCount($user_id, '1'); ?>" disabled />
                </div>
                <br />
                <div class="input-group">
                	<span class="input-group-addon">Awaiting Your Response</span>
                    <input type="text" class="form-control" placeholder="<?php echo $tickets->ticketCount($user_id, '2'); ?>" disabled />
                </div>
                <br />
                <div class="input-group">
                	<span class="input-group-addon">Awaiting Staff Response</span>
                    <input type="text" class="form-control" placeholder="<?php echo $tickets->ticketCount($user_id, '4'); ?>" disabled />
                </div>
                <br />
                <div class="input-group">
                	<span class="input-group-addon">On Hold</span>
                    <input type="text" class="form-control" placeholder="<?php echo $tickets->ticketCount($user_id, '5'); ?>" disabled />
                </div>
                <br />
                <div class="input-group">
                	<span class="input-group-addon">Resolved</span>
                    <input type="text" class="form-control" placeholder="<?php echo $tickets->ticketCount($user_id, '3'); ?>" disabled />
                </div>
                <br />
                <div class="input-group">
                	<span class="input-group-addon">Total Tickets</span>
                    <input type="text" class="form-control" placeholder="<?php echo $tickets->ticketCount($user_id, NULL); ?>" disabled />
                </div>
            </form>
        </div>
        
        <div class="col-md-9">
        <h1>Your Tickets</h1>
        	<table class="table table-responsive table-bordered table-hover">
            	<thead>
                	<tr>
                    	<th>Ticket ID</th>
                        <th>Subject</th>
                        <th>Department</th>
                        <th>Status</th>
                        <th>Last Updated</th>
                        <th>Close</th>
                    </tr>
                </thead>
                <tbody>
                	<?php echo $tickets->ticketList($user_id, '0', 50); ?>
                </tbody>
            </table>
            <hr>
            <table class="table table-bordered">
            	<tr>
                	<td>Open</td>
                    <td class="success">Resolved</td>
                    <td class="warning">Awaiting Your Response</td>
                    <td class="info">Awaiting Staff Response</td>
                    <td class="danger">On Hold</td>
                </tr>
            </table>
        </div>
      </div>
        <?php
	  }
	  else
	  {
		  $tid = $core->EscapeString($_GET['tid']);
		  $tid_check = $tickets->checkTicketID($tid);
		  $owner = $tickets->checkTicketOwner($user_id, $tid);
		  if($tid_check) {
			  if($owner) {
      ?>
      <div class="row">
      	<div class="col-md-3">
        	<h1><?php echo $lang['ticket_information_header']; ?></h1>
            <?php
				$ticket_id = $tickets->ticketInfo($tid, 'ticket_id');
				$dept = $tickets->DepartmentByID($tickets->ticketInfo($tid, 'dept_id'));
				$status_id = $tickets->ticketInfo($tid, 'status');
			?>
            <form role="form">
              <div class="form-group">
                <label for="ticketID">Ticket ID</label>
                <input type="text" class="form-control" id="ticketID" placeholder="<?php echo $ticket_id; ?>" disabled />
              </div>
              <div class="form-group">
                <label for="DeptID">Department</label>
                <input type="text" class="form-control" id="DeptID" placeholder="<?php echo $dept; ?>" disabled />
              </div>
              <div class="form-group">
                <label for="status">Status</label>
                <input type="text" class="form-control" id="status" placeholder="<?php echo $tickets->StatusByID($status_id, 'name'); ?>" disabled />
              </div>
            </form>
            <?php
			if($status_id != 3) {
			?>
            <button class="btn btn-info" data-toggle="modal" data-target="#reply-box"><?php echo $lang['button_ticketreply']; ?></button>&nbsp;<button class="btn btn-danger" data-toggle="modal" data-target="#resolved-box"><?php echo $lang['button_ticketresolved']; ?></button>
            <?php
			}
			?>
        </div>
        
        <div class="col-md-9">
        	<h1><?php echo $lang['ticket_history_header']; ?> &raquo; <?php echo $tickets->ticketInfo($tid, 'subject'); ?> <?php if($status_id != 3) { ?><span style="float: right;"><button class="btn btn-info" data-toggle="modal" data-target="#reply-box"><?php echo $lang['button_ticketreply']; ?></button>&nbsp;<button class="btn btn-danger" data-toggle="modal" data-target="#resolved-box"><?php echo $lang['button_ticketresolved']; ?></button></span><?php } else { ?><small><span class="label label-success" style="float: right;"><?php echo $lang['message_ticketresolved']; ?></span></small><?php } ?></h1>
            <?php
            	echo $tickets->ticketHistory($tid);
				echo $tickets->ticketResponses($tid);
			?>
            
            <!-- Reply Box -->
            <div class="modal fade" id="reply-box" tabindex="-1" role="dialog" aria-labelledby="replyBoxLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="replyBoxLabel">Reply to ticket <?php echo $tid; ?></h4>
                  </div>
                  	<form action="<?php echo $system_url; ?>update_ticket" method="post">
                  <div class="modal-body">
                    <textarea placeholder="Type your reply here... (Minimum 25 characters)" class="form-control" name="message"></textarea>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $lang['button_cancel']; ?></button>
                    <input type="hidden" name="tid" value="<?php echo $ticket_id; ?>" />
                    <input type="submit" class="btn btn-success" value="<?php echo $lang['button_ticketreply']; ?>" name="reply">
                  </div>
                  
                    </form>
                </div>
              </div>
            </div>
            
            <!-- Resolved Box -->
            <div class="modal fade" id="resolved-box" tabindex="-1" role="dialog" aria-labelledby="resolvedBoxLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="replyBoxLabel">Mark ticket <?php echo $tid; ?> as Resolved</h4>
                  </div>
                  <div class="modal-body">
                    <p><?php echo $lang['modal_ticketresolved']; ?></p>
                  </div>
                  <div class="modal-footer">
                  	<form action="<?php echo $system_url; ?>update_ticket" method="post">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $lang['button_cancel']; ?></button>
                    <input type="hidden" name="tid" value="<?php echo $ticket_id; ?>" />
                    <input type="submit" class="btn btn-success" name="resolve" />
                    </form>
                  </div>
                </div>
              </div>
            </div>
      </div>
      </div>
      <?php
			  }
			  else
			  {
			  ?>
				  <div class="row">
					<div class="col-md-offset-4 col-md-4" style="text-align: center;">
						<h1><i class="glyphicon glyphicon-remove" style="color: red;"></i><br />
						Error!</h1>
						<p class="alert alert-danger">You do not have permission to view this ticket.</p>               
					</div>
        		  </div> 
              <?php
			  }
	  	}
		else
		{
	  ?>
      	<div class="row">
        	<div class="col-md-offset-4 col-md-4" style="text-align: center;">
            	<h1><i class="glyphicon glyphicon-remove" style="color: red;"></i><br />
                Error!</h1>
                <p class="alert alert-danger">This ticket (ID: <?php echo $tid; ?>) does not exist.</p>               
            </div>
        </div>  
      <?php
		}
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