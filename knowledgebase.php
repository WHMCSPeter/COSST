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
    <?php
	if(!isset($_GET['article']) && !isset($_GET['category']))
	{
	?>
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
                        <span class="input-group-btn">
        					<input type="submit" class="btn btn-default" name="search" value="Search Now">
      					</span>
                    </div>
                </form>
                <h2><small>Random Articles</small></h2>
                <?php $frontend->featured_kb($core->Setting('kb_featured')); ?>
            </div>
        </div>
        <?php
	}
	else if(isset($_GET['category'])) {
		$category = $core->EscapeString($_GET['category']);
		$cat = $frontend->categoryInfo($category, 'name');
		if(!$cat) {
			header("Location: ".$system_url."knowledgebase");
			die();
		}
	?>
    <div class="row">
    	<div class="col-md-12">
        	<h1 class="page-header">Knowledgebase <small><?php echo $cat; ?></small></h1>
        </div>
    </div>
    <?php
	}
	else if(isset($_GET['article'])) {
		echo 'Show article';
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