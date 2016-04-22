<?php

	require "vendor/autoload.php";

	use \stange\util\console\Arguments;
	use \stange\util\console\Argument;

	$arguments	=	new Arguments($_SERVER['argv']);
	var_dump($arguments->getParsedArguments());
