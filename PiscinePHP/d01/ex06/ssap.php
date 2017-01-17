#!/usr/bin/php
<?php
	$i = 1;
	while ($i < $argc)
	{	
		$str = $str . $argv[$i] . ' ';
		$i++;
	}	
	$str = trim($str);
	$tab = explode(" ", $str);
	sort($tab);
	foreach ($tab as $value)
    	echo $value . "\n";
?>