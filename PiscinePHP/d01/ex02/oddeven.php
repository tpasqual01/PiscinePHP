#!/usr/bin/php
<?php
print("Entrez un nombre: ");
while (fscanf(STDIN, "%s", $nbr))
{
	if (is_numeric($nbr))
		if ($nbr % 2 == 0)
			print("Le chiffre " . $nbr . " est " . "Pair" . "\n");
		else
			print("Le chiffre " . $nbr . " est " . "Impair" . "\n");
	else
		print("'" . $nbr . "' n'est pas un chiffre" . "\n");
	print("Entrez un nombre: ");
	$nbr = '';
}
print($nbr . "\n");
?>