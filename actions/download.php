<?php

if (!$_SESSION['loggedin'])
	die("Not logged in.");

if (empty($_GET['file']))
	fail("File doesn't exist.");
else
	$file = urldecode($_GET['file']);

if (empty($_GET['path']))
	$path = "";
else
	$path = urldecode($_GET['path']);

header("Content-Disposition: attachment; filename=\"$file\"");
header("Content-Transfer-Encoding: bytes");

$filepath = "$conf->schemsDir/$_SESSION[username]/$path/$file";

echo file_get_contents($filepath);
