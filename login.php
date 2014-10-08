<?php
require_once('config.php');
$page = 'login';
if(isset($_GET['logout'])) {
	setcookie("loggedin", "", time()-3600, "/");
	setcookie("id", "", time()-3600, "/");
	setcookie("sechash", "", time()-3600, "/");
	header("Location: ./login?msg=logout");
	die();
}
if(isset($_POST['login'])) {
	$email = $core->EscapeString($_POST['email']);
	$password = sha1($_POST['password']);
	$login = $core->Login($email, $password);
	if($login == true) {
		header("Location: ./");
		die();
	}
	else if($login == false)
	{
		header("Location: ./login?error=1");
		die();
	}
	else if($login == 'noExist')
	{
		header("Location: ./login?error=2");
		die();
	}
	else
	{
		header("Location: ./login?error=error3");
		die();
	}
}
else
{
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
        <div class="col-md-4">
        <?php
		if(isset($_GET['error'])) {
			if($_GET['error'] == 1) {
				echo '<p class="alert alert-danger" style="text-align: center; margin-top: 10px;"><i class="glyphicon glyphicon-remove"></i> Your password is incorrect. Please try again.</p>';
			}
			else if($_GET['error'] == 2) {
				echo '<p class="alert alert-danger" style="text-align: center; margin-top: 10px;"><i class="glyphicon glyphicon-remove"></i> Account does not exist. Please <a href="./register" class="alert-link">register</a> to log in.</p>';
			}
			else if($_GET['error'] == 3) {
				echo '<p class="alert alert-danger" style="text-align: center; margin-top: 10px;"><i class="glyphicon glyphicon-remove"></i> An unknown error occured. Please try again.</p>';
			}
			else if($_GET['error'] == 'restricted') {
				echo '<p class="alert alert-danger" style="text-align: center; margin-top: 10px;"><i class="glyphicon glyphicon-remove"></i> Please log in to view your tickets, account or dashboard.</p>';
			}
		}
		else if(isset($_GET['msg'])) {
			if($_GET['msg'] == 'logout') {
				echo '<p class="alert alert-info" style="text-align: center; margin-top: 10px;"><i class="glyphicon glyphicon-exclamation-sign"></i> You have successfully logged out.</p>';
			}
			if($_GET['msg'] == 'openticket') {
				echo '<p class="alert alert-info" style="text-align: center; margin-top: 10px;"><i class="glyphicon glyphicon-exclamation-sign"></i> You must log in to submit a ticket.</p>';
			}
		}
		?>
          <h2><?php echo $lang['heading_login']; ?></h2>
        <?php
		if(!LOGGED_IN) {
		?>
          <form role="form" action="login" method="post">
          	<div class="input-group">
            <span class="input-group-addon">Email</span>
            <input type="email" name="email" class="form-control" placeholder="email@address.com" />
            </div>
            <br />
            <div class="input-group">
            <span class="input-group-addon">Password</span>
            <input type="password" name="password" class="form-control" />
            </div>
            <br />
            <input type="submit" name="login" class="btn btn-lg btn-success" style="float: right;" value="<?php echo $lang['button_signin']; ?>" />
            <a href="./" class="btn btn-lg btn-default" style="float: left;">&laquo; Return Home</a>
          </form>
        <?php
		}
		else
		{
			echo '<p style="text-align: center;">You are already logged in. You can head to the Dashboard or logout. The choice is yours!</p>';
			echo '<p><a href="./dashboard"><button class="btn btn-lg btn-default" style="float: left;">&laquo; Return to Dashboard</button></a> <a href="./dashboard"><form action="'.$system_url.'login"><input type="submit" name="logout" class="btn btn-lg btn-info" style="float: right;" value="Log Out &raquo;"></form></a></p>';
		}
		?>
       </div>
        <div class="col-md-4">
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
<?php
}
?>