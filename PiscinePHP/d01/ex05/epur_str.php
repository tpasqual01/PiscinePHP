#!/usr/bin/php
<?php
	$str = ' ';
	if ($argc == 2)
	{	
		$str = preg_replace('/\s\s+/', ' ', $argv[1]);
		echo trim($str)."\n";
	}	
?>