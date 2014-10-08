<?php
if(!LOGGED_IN) {
?>
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="./"><?php echo $sitename; ?></a>
      </div>
      <div class="navbar-collapse collapse">
        <form class="navbar-form navbar-right" action="<?php echo $system_url; ?>/login" method="post" role="form">
          <div class="form-group">
            <input type="email" placeholder="<?php echo $lang['placeholder_email']; ?>" name="email" class="form-control" required />
          </div>
          <div class="form-group">
            <input type="password" placeholder="<?php echo $lang['placeholder_password']; ?>" name="password" class="form-control" required />
          </div>
          <input type="submit" name="login" class="btn btn-success" value="<?php echo $lang['button_signin']; ?>" />
          <a href="<?php echo $system_url; ?>/register"><button class="btn btn-info"><?php echo $lang['button_register']; ?></button></a>
        </form>
      </div><!--/.navbar-collapse -->
    </div>
</div>
<?php
}
else
{
?>
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="./"><?php echo $sitename; ?></a>
      </div>
      <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav navbar-right">
            <li class="nav-name"><img src="http://www.gravatar.com/avatar/<?php echo $core->Gravatar($user_id, $sechash); ?>?size=20" width="20px" height="20px" alt="Profile Image" /> Welcome, <span>Peter</span></li>
        	<li<?php if($page == 'dashboard') { echo ' class="active"'; } ?>><a href="<?php echo $system_url; ?>dashboard">Dashboard</a></li>
            <li<?php if($page == 'my_tickets') { echo ' class="active"'; } ?>><a href="<?php echo $system_url; ?>tickets">My Tickets</a></li>
            <li<?php if($page == 'my_account') { echo ' class="active"'; } ?>><a href="<?php echo $system_url; ?>account">My Account</a></li>
            <li><a href="<?php echo $system_url; ?>login?logout">Logout</a></li>
        </ul>
      </div><!--/.navbar-collapse -->
    </div>
</div>
<?php
}
?>