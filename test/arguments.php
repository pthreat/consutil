<?php

	require "vendor/autoload.php";

	use \stange\util\console\Arguments;
	use \stange\util\console\Argument;

	$arguments	=	new Arguments($_SERVER['argv']);

	echo "Trying to find argument test or short argument t\n";

	var_dump($arguments->find('test','t'));
