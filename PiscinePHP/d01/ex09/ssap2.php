#!/usr/bin/php
<?php
function ret_ascii($car)
{
	$car = ord($car);
	if (ctype_digit($car))
		return ($car + 100);
	else if (ctype_alpha($car))
	{
		if (ctype_upper($car))
			return ($car + 32);
		else
			return ($car);
	}
	else 
		return ($car + 500);
}

function tri($a, $b)
{
	$long_a = strlen($a);
	$long_b = strlen($b);
	$i = 0;
	while($i < $long_a && $i < $long_b)
	{
		$car_1 = ret_ascii($a[$i]);
		$car_2 = ret_ascii($b[$i]);
		if ($car_1 != $car_2)
			return ($car_1 < $car_2 ? -1 : 1);
		$i++;
	}
	if ($i == $long_a && $i == $long_b)
		return (0);
	return ($i == $long_a ? -1 : 1);
}

$i = 1;
if (argc == 0)
	exit (1);
while ($i < $argc)
{
	$my_item = $argv[$i];
	$my_str = preg_replace('/\s\s+/', ' ', $argv[$i++]);
	$my_str = trim($my_str);
	$my_tab = explode(" ", $my_str);
	$length = count($my_tab);
	$j = 0;
	while ($j < $length)
	{
		$my_item = $my_tab[$j++];
		$result[] = $my_item;
	}
}
usort($result, tri);
foreach ($result as $val) 
	echo "$val\n";
?>