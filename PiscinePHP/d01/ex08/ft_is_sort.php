<?PHP
function ft_is_sort($tab)
{
	$tab_sort = $tab;
	asort($tab_sort);
	return $tab_sort == $tab; 
}
?>
