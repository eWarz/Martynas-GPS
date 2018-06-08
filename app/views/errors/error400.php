<?php
?>
<h2><?php echo $name; ?></h2>
<p class="error">
	<strong><?php echo __d('laravel', 'Error'); ?>: </strong>
	<?php printf(
		__d('laravel', 'The requested address %s was not found on this server.'),
		"<strong>'{$url}'</strong>"
	); ?>
</p>
<?php
if (Configure::read('debug') > 0):
	echo $this->element('exception_stack_trace');
endif;
?>
