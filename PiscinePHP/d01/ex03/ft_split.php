<?php
function ft_split($str)
{
	$str = preg_replace('/\s{2,}/', ' ', $str);
	$str = trim($str, ' ');
	$tab = explode(' ', $str);
	sort($tab);
	return ($tab);
}