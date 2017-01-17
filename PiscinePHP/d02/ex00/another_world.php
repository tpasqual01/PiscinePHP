#!/usr/bin/php
<?php
    if ($argc >= 2)
    {   
        $str = $argv[1];
        $str = preg_replace('/\s+/', ' ', $str);
        $str = preg_replace('/\t+/', ' ', $str);
        $str = preg_replace('/\s+/', ' ', $str);
        $str = trim($str, ' ');
        echo ($str)."\n";
    }
?>