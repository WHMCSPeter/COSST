<?php
require_once('config.php');
$page = 'knowledgebase';
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
        		<h1 class="page-header">Knowledgebase <small>Answers to frequently asked questions...</small></h1>
            </div>
        </div>
        
        <div class="row">
        	<div class="col-md-2 well">
            	<h3>Categories</h3>
                <?php $frontend->kb_categories(); ?>         
            </div>
        
        	<div class="col-md-10">
        		<form>
                	<div class="input-group">
                    	<span class="input-group-addon">Search</span>
                        <input type="text" class="form-control" name="term" placeholder="What do you need help with?" />
                    </div>
                </form>
                <br>
                <?php $frontend->featured_kb(3); ?>
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