<?php
if ($_GET['action'])
	switch ($_GET['action']) {
	    case "set":
	        setcookie($_GET['name'], $_GET['value'], time() + 3600);
	        break;
	    case "get":
	        $val = $_COOKIE[$_GET['name']];
			if ($val)
			   echo $val."\n";
	        break;
	    case "del":
	        setcookie($_GET['name'], "", time() - 3600);
	        break;
	    case "info":
	        foreach($_COOKIE as $key => $value)
	        	echo $key . " = " . $value . "<br/>";
	        break;
}
?>