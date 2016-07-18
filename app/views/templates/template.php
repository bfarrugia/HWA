<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8"/>
		<link rel="stylesheet" type="text/css" href="/hwa/assets/css/style.css"/>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
		<script src="/hwa/assets/js/hwa.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		<title><?php echo $view->pageTitle; ?></title>
		<?php 
			if($view->injectRenderTemplate('header'))
				include($view->injectRenderTemplate('header')); ?>
	</head>
	<body>
		<?php 
			if($view->injectRenderTemplate('nav'))
				include($view->injectRenderTemplate('nav')); ?>
		<div class="container">
			<?php 
			if($view->injectRenderTemplate('mainContent'))
				include($view->injectRenderTemplate('mainContent')); ?>
		</div>
	</body>
</html>