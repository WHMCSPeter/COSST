<?php
require_once('config.php');
$page = 'status';
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
      <div class="row">
      	<div class="col-md-12">
        	<h1 class="page-header">Status <small>Find out if services are online</small></h1>
        </div>
      </div>
      
      <div class="row">
      	<div class="col-md-3 well">
        	<h3>Help</h3>
            <p>
            From here, you can view the current status of our online services. This can be helpful when trying to find out if you are experiencing issues yourself or if the entire service is unavailable.
            </p>
        </div>
        
        <div class="col-md-9">
        <?php 
			$check = $frontend->statusCheck();
		?>
        	<table class="table table-responsive table-bordered table-striped">
            	<thead>
                	<th>Service</th>
                    <th>Host</th>
                    <th>Port</th>
                    <th>Status</th>
                </thead>
                <tbody>
                	<?php
					foreach ($check as $innerArray => $key) {
						if($key['check'] == 1) {
							echo '<tr class="success">';
							$online = true;
						}
						else
						{
							echo '<tr class="danger">';
							$online = false;
						}
						echo '<td>'.$innerArray.'</td>';
						echo '<td>'.$key['host'].'</td>';
						echo '<td>'.$key['port'].'</td>';
						if($online) {
							echo '<td><i class="glyphicon glyphicon-ok"></i> Online</td>';
						}
						else
						{
							echo '<td><i class="glyphicon glyphicon-remove"></i> Offline</td>';
						}
					}
					?>
                </tbody>
            </table>
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