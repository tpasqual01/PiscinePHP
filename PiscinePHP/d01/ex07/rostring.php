#!/usr/bin/php
<?php
    if ($argv[1] != NULL)
    {
        $decoupe = explode(' ', $argv[1]);
        echo $decoupe[count($decoupe) - 1] . "\n";
		for ($i = 1; $i < count($decoupe) - 1; $i++)
			echo $decoupe[$i] . "\n";
		if (count($decoupe) != 1)
			echo $decoupe[0] . "\n";
    }
?>