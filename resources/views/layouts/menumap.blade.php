<!DOCTYPE html>
<html lang="en">
  <head>
    <?php echo $this->Html->charset(); ?>
    <title><?php if($title) echo $title; else echo "Ups"; echo ' - ' . $title_for_layout; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('bootstrap');
		echo $this->Html->css('bootstrap-responsive.min');
		echo $this->Html->css('font-awesome.min');
		echo $this->Html->css('pick-a-color-1.1.6.min');
		echo $this->Html->css('custom'); //custom css
		echo $this->Html->css('styleless'); //dynamic css
		
		echo $this->Html->css('start/jquery-ui');
		//echo $this->Html->css('redmond/jquery-ui');
		//echo $this->Html->css('cupertino/jquery-ui');
		echo $this->Html->css('jquery-ui-timepicker-addon');
		
		echo $this->Html->script('jquery');
		echo $this->Html->script('bootstrap.min');
		
		echo $this->Html->script('jquery.validate.min');
		echo $this->Html->script('jquery-ui-1.9.2.custom.min');
		echo $this->Html->script('jquery-ui-timepicker-addon');
		echo $this->Html->script('tinycolor-0.9.14.min');
		echo $this->Html->script('pick-a-color-1.1.6.min');
		
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
    <!-- Le styles -->
   
    <style type="text/css">
      body {
        padding-bottom: 0px;
        background-color:#fff;
        width:100%;
        height:100%;
      }
      
     .masthead .nav {
     	margin-bottom: 10px;
     }
     .navbar-search {
     	margin-top:0px;
     }
	  a.btn {
		button.btn
	  }
	 .nav > li > a.no-hover:hover {
	 	text-decoration:none;
	 	background: transparent;
	 	color:rgb(0,136,204);
	 	background-image: none;
	 }
	 .dropdown:hover .dropdown-menu {
    /*display: block;*/
	}
	.copyright .dropup {
		display:inline-block;
	}
	
    </style>
    
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

  </head>
  <body>
	<?php echo $this->element('menu/mainmenu'); ?>
    <div style="width:100%;height:575px">
		<?php //echo $this->Session->flash('flash',array('element'=>'alert')); ?>
		<?php //echo $this->Session->flash('auth',array('element'=>'alert')); ?>
		<?php echo $this->fetch('content'); ?>

    </div> <!-- /container -->
	 <div class="footer" style="margin-top:0px">
      <div class="">
      </div>
      </div>
	<script>
	$(document).ready(function(){
   		 $('.dropdown-toggle').dropdown();
   	//Add Hover effect to menus
   		jQuery('ul.nav li.dropdown').hover(function() {
   		  jQuery(this).find('.dropdown-menu').stop(true, true).delay(50).fadeIn();
   		}, function() {
   		  jQuery(this).find('.dropdown-menu').stop(true, true).delay(90).fadeOut();
   		});
   		
   		jQuery('.dropup').hover(function() {
   		  jQuery('div.dropup').find('.dropdown-menu').stop(true, true).delay(50).fadeIn();
   		}, function() {
   		  jQuery('div.dropup').find('.dropdown-menu').stop(true, true).delay(1900).fadeOut();
   		});
   	});
    </script>
  </body>
</html>