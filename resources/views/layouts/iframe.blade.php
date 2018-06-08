<!DOCTYPE html>
<html lang="en">
  <head>
    <?php echo $this->Html->charset(); ?>
    <title><?php if($title) echo $title; else echo "Ups"; echo ' - ' . $title_for_layout; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
	//	echo $this->Html->meta('icon');

		echo $this->Html->css('bootstrap');
		echo $this->Html->css('bootstrap-responsive.min');
	//	echo $this->Html->css('font-awesome.min');
	//	echo $this->Html->css('custom'); //custom css
	//	echo $this->Html->css('styleless'); //dynamic css
		
		echo $this->Html->css('start/jquery-ui');
		//echo $this->Html->css('redmond/jquery-ui');
		//echo $this->Html->css('cupertino/jquery-ui');
	//	echo $this->Html->css('jquery-ui-timepicker-addon');
		
		echo $this->Html->script('jquery');
		echo $this->Html->script('bootstrap.min');
		
	//	echo $this->Html->script('jquery.validate.min');
		echo $this->Html->script('jquery.cookie');
		echo $this->Html->script('jquery-ui-1.9.2.custom.min');
	//	echo $this->Html->script('jquery-ui-timepicker-addon');
		
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
	
    <style type="text/css">
      body {
        padding-bottom: 0px;
    /*    background-color:#fffaee; */
        width:100%;
        height:100%;
      }
		html {
		height:100%;
		width:100%
		}
    </style>
    
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

 
  </head>

  <body>



		<?php //echo $this->Session->flash('flash',array('element'=>'alert')); ?>
		<?php //echo $this->Session->flash('auth',array('element'=>'alert')); ?>
		<?php echo $this->fetch('content'); ?>

 
	
  </body>
</html>