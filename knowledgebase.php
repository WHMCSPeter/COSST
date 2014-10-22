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
	if(!isset($_GET['article']) && !isset($_GET['category']) && !isset($_GET['search']))
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
                <?php $frontend->kb_categories($system_url); ?>      
            </div>
        
        	<div class="col-md-10">
        		<form action="<?php echo $system_url.'knowledgebase/search/submit'; ?>" method="post">
                	<div class="input-group">
                    	<span class="input-group-addon">Search</span>
                        <input type="text" class="form-control" name="search" placeholder="What do you need help with?" />
                        <span class="input-group-btn">
        					<input type="submit" class="btn btn-default" value="Search Now">
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
    
    <div class="row">
      	<div class="col-md-2 well">
        	<h3>Categories</h3>
            <?php $frontend->kb_categories($system_url); ?>
            <br>
            <a href="<?php echo $system_url.'knowledgebase'; ?>"><button class="btn btn-info">&laquo; Back</button></a>       
        </div>
        
      	<div class="col-md-10">
       		<form action="<?php echo $system_url.'knowledgebase/search/submit'; ?>" method="post">
               	<div class="input-group">
                  	<span class="input-group-addon">Search</span>
                    <input type="text" class="form-control" name="search" placeholder="What do you need help with?" />
                    <span class="input-group-btn">
   					<input type="submit" class="btn btn-default" value="Search Now">
   					</span>
                </div>
            </form>
            <br>
            <?php $frontend->displayKBCategory($category); ?>
            </div>
        </div>
    <?php
	}
	else if(isset($_GET['article'])) {
		echo 'Show article';
	}
	else if(isset($_GET['search'])) {
		echo '%'.str_replace(" ","%",$_POST['search']).'%';
		//Use above formula in search
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