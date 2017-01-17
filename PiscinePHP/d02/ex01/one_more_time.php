#!/usr/bin/php
<?php
function MappingMonth($mois)
{
	$array = array("janvier" => 1,
				   "fevrier" => 2,
				   "mars" => 3,
				   "avril" => 4,
				   "mai" => 5,
				   "juin" => 6,
				   "juillet" => 7,
				   "aout" => 8,
				   "septembre" => 9,
				   "octobre" => 10,
				   "novembre" => 11,
				   "decembre" => 12);
	return $array[$mois];
}
if ($argc > 1)
{
	$str = $argv[1];
	$str = strtolower($str);
	/*\w+ (?<date>\d{1,2}) (?<mois>\w+) (?<annee>\d{4}) (?<heure>\d{2}):(?<minute>\d{2}):(?<seconde>\d{2})  avec $matches[mois] pour renvoyer xx*/
	if (preg_match("/(lundi|mardi|mercredi|jeudi|vendredi|samedi|dimanche)\s(((0[1-9])|([1-9])|(1\d)|(2\d)|(3[0-1])))\s(janvier|fevrier|mars|avril|mai|juin|juillet|aout|septembre|octobre|novembre|decembre)\s([0-9]{4}) ([0-9]{2}):([0-9]{2}):([0-9]{2})/", $str, $matches))
	{
		date_default_timezone_set("Europe/Paris");
		print(mktime($matches[11], $matches[12], $matches[13],
				MappingMonth($matches[9]), $matches[6], $matches[10]));
	}
	else
		print("Wrong Format");
		print("\n");
}
?>
