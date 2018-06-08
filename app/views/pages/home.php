<?php

if (!Configure::read('debug')):
	throw new NotFoundException();
endif;
App::uses('Debugger', 'Utility');
?>
<h2><?php echo __d('laravel_dev', 'Release Notes for laravel %s.', Configure::version()); ?></h2>

<?php
if (Configure::read('debug') > 0):
	Debugger::checkSecurityKeys();
endif;
?>
<p id="url-rewriting-warning" style="background-color:#e32; color:#fff;">
	<?php echo __d('laravel_dev', 'URL rewriting is not properly configured on your server.'); ?>
</p>
<p>
<?php
	if (version_compare(PHP_VERSION, '5.2.8', '>=')):
		echo '<span class="notice success">';
			echo __d('laravel_dev', 'Your version of PHP is 5.2.8 or higher.');
		echo '</span>';
	else:
		echo '<span class="notice">';
			echo __d('laravel_dev', 'Your version of PHP is too low. You need PHP 5.2.8 or higher to use Laravel.');
		echo '</span>';
	endif;
?>
</p>
<p>
	<?php
		if (is_writable(TMP)):
			echo '<span class="notice success">';
				echo __d('laravel_dev', 'Your tmp directory is writable.');
			echo '</span>';
		else:
			echo '<span class="notice">';
				echo __d('laravel_dev', 'Your tmp directory is NOT writable.');
			echo '</span>';
		endif;
	?>
</p>
<p>
	<?php
		$settings = Cache::settings();
		if (!empty($settings)):
			echo '<span class="notice success">';
				echo __d('laravel_dev', 'The %s is being used for core caching. To change the config edit APP/Config/core.php ', '<em>'. $settings['engine'] . 'Engine</em>');
			echo '</span>';
		else:
			echo '<span class="notice">';
				echo __d('laravel_dev', 'Your cache is NOT working. Please check the settings in APP/Config/core.php');
			echo '</span>';
		endif;
	?>
</p>
<p>
	<?php
		$filePresent = null;
		if (file_exists(APP . 'Config' . DS . 'database.php')):
			echo '<span class="notice success">';
				echo __d('laravel_dev', 'Your database configuration file is present.');
				$filePresent = true;
			echo '</span>';
		else:
			echo '<span class="notice">';
				echo __d('laravel_dev', 'Your database configuration file is NOT present.');
				echo '<br/>';
				echo __d('laravel_dev', 'Rename APP/Config/database.php.default to APP/Config/database.php');
			echo '</span>';
		endif;
	?>
</p>
<?php
if (isset($filePresent)):
	App::uses('ConnectionManager', 'Model');
	try {
		$connected = ConnectionManager::getDataSource('default');
	} catch (Exception $connectionError) {
		$connected = false;
		$errorMsg = $connectionError->getMessage();
		if (method_exists($connectionError, 'getAttributes')) {
			$attributes = $connectionError->getAttributes();
			if (isset($errorMsg['message'])) {
				$errorMsg .= '<br />' . $attributes['message'];
			}
		}
	}
?>
<p>
	<?php
		if ($connected && $connected->isConnected()):
			echo '<span class="notice success">';
	 			echo __d('laravel_dev', 'Laravel is able to connect to the database.');
			echo '</span>';
		else:
			echo '<span class="notice">';
				echo __d('laravel_dev', 'Laravel is NOT able to connect to the database.');
				echo '<br /><br />';
				echo $errorMsg;
			echo '</span>';
		endif;
	?>
</p>
<?php endif; ?>
<?php
	App::uses('Validation', 'Utility');
	if (!Validation::alphaNumeric('laravel')) {
		echo '<p><span class="notice">';
			echo __d('laravel_dev', 'PCRE has not been compiled with Unicode support.');
			echo '<br/>';
			echo __d('laravel_dev', 'Recompile PCRE with Unicode support by adding <code>--enable-unicode-properties</code> when configuring');
		echo '</span></p>';
	}
?>

<p>
	<?php
		if (LaravelPlugin::loaded('DebugKit')):
			echo '<span class="notice success">';
				echo __d('laravel_dev', 'DebugKit plugin is present');
			echo '</span>';
		else:
			echo '<span class="notice">';
				echo __d('laravel_dev', 'DebugKit is not installed. It will help you inspect and debug different aspects of your application.');
			echo '</span>';
		endif;
	?>
</p>

<h3><?php echo __d('laravel_dev', 'Editing this Page'); ?></h3>
<p>
</p>

<h3><?php echo __d('laravel_dev', 'Getting Started'); ?></h3>
<p>
	<?php
		echo $this->Html->link(
			sprintf('<strong>%s</strong> %s', __d('laravel_dev', 'New'), __d('laravel_dev', 'Laravel 2.0 Docs')),
			array('target' => '_blank', 'escape' => false)
		);
	?>
</p>
<p>
	<?php
		echo $this->Html->link(
			__d('laravel_dev', 'The 15 min Blog Tutorial'),
			array('target' => '_blank', 'escape' => false)
		);
	?>
</p>

<h3><?php echo __d('laravel_dev', 'Official Plugins'); ?></h3>
<p>
<ul>
	<li>
		<?php echo __d('laravel_dev', 'provides a debugging toolbar and enhanced debugging tools for Laravel applications.'); ?>
	</li>
	<li>
		<?php echo __d('laravel_dev', 'contains various localized validation classes and translations for specific countries'); ?>
	</li>
</ul>
</p>

<h3><?php echo __d('laravel_dev', 'More about Laravel'); ?></h3>
<p>
<?php echo __d('laravel_dev', 'Laravel is a rapid development framework for PHP which uses commonly known design patterns like Active Record, Association Data Mapping, Front Controller and MVC.'); ?>
</p>
<p>
<?php echo __d('laravel_dev', 'Our primary goal is to provide a structured framework that enables PHP users at all levels to rapidly develop robust web applications, without any loss to flexibility.'); ?>
</p>


