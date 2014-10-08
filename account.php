<?php
require_once('config.php');
$page = 'my_account';
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
      <div class="row">
      	<div class="col-md-4">
        </div>
        <div class="col-md-4" style="text-align: center; margin-top: 10px;">
        	<img src="http://www.gravatar.com/avatar/<?php echo $core->Gravatar($user_id, $sechash); ?>" style="border-radius: 50%;" alt="Profile Image" /><br />
            <h1>Hello, <?php echo $core->UserInfo($user_id, $sechash, 'first_name'); ?>.</h1>
            <p><small>To edit your profile image, please update it at <a href="http://www.gravatar.com/">Gravatar.com</a></small></p>
        </div>
        <div class="col-md-4">
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-md-4">
       		<h2><?php echo $lang['account_header1']; ?></h2>
            <p><?php echo $lang['account_subtext1']; ?></p>
            <form role="form" action="update_account" method="post">
            	<div class="input-group">
                	<span class="input-group-addon">First Name</span>
                    <input type="text" class="form-control" name="fname" placeholder="Joe"<?php if($core->UserInfo($user_id, $sechash, 'first_name') != NULL) { echo ' value="'.$core->UserInfo($user_id, $sechash, 'first_name').'"'; } ?> />
                </div>
                <br />
                <div class="input-group">
                	<span class="input-group-addon">Last Name</span>
                    <input type="text" class="form-control" name="lname" placeholder="Bloggs"<?php if($core->UserInfo($user_id, $sechash, 'last_name') != NULL) { echo ' value="'.$core->UserInfo($user_id, $sechash, 'last_name').'"'; } ?> />
                </div>
                <br />
                <input type="submit" name="personal" class="btn btn-success" value="Update Information" style="float: right;" />
            </form>
        </div>
        <div class="col-md-4">
            <h2><?php echo $lang['account_header2']; ?></h2>
            <p><?php echo $lang['account_subtext2']; ?></p>
            <p><strong>Current Email Address:</strong> <?php if($core->UserInfo($user_id, $sechash, 'email') == NULL) { echo 'None on record. Please add one.'; } else { echo $core->UserInfo($user_id, $sechash, 'email').'.'; } ?></p>
            <form role="form" action="update_account" method="post">
            	<div class="input-group">
                	<span class="input-group-addon">New Email</span>
                    <input type="email" class="form-control" name="email" placeholder="joe@bloggs.com" required />
                </div>
                <br />
                <div class="input-group">
                	<span class="input-group-addon">Confirm</span>
                    <input type="email" class="form-control" name="emailc" placeholder="joe@bloggs.com" required />
                </div>
                <br />
                <input type="submit" name="contact" class="btn btn-success" value="Update Email" style="float: right;" />
            </form>
       </div>
        <div class="col-md-4">
        	<h2><?php echo $lang['account_header3']; ?></h2>
            <p><?php echo $lang['account_subtext3']; ?></p>
            <p>Your password was last changed on: <?php if($core->UserInfo($user_id, $sechash, 'pw_lastchange') == NULL) { echo '<strong>Never changed.</strong>'; } else { $date = strtotime($core->UserInfo($user_id, $sechash, 'pw_lastchange')); echo date('jS F Y', $date); } ?></p>
            <form role="form" action="update_account" method="post">
            	<div class="input-group">
                	<span class="input-group-addon">New Password</span>
                    <input type="password" class="form-control" name="password" required />
                </div>
                <br />
                <div class="input-group">
                	<span class="input-group-addon">Confirm</span>
                    <input type="password" class="form-control" name="passwordc" required />
                </div>
                <br />
                <input type="submit" name="passwd" class="btn btn-success" value="Update Password" style="float: right;" />
            </form>
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