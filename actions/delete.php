<?php

if (!$loggedin)
	fail("Not logged in.");

if (empty($_GET['file']))
	fail("You must supply a file name.");
else
	$file = urldecode($_GET['file']);

if (empty($_GET['path']))
	$path = "";
else
	$path = urldecode($_GET['path']);

if (!validateName($path, '\/') || preg_match('/\.\./', $path))
	fail("Path name contains illegal characters.");
if (!validateName($file))
	fail("File name contains illegal characters.");

$filePath = "$conf->schemsDir/$uuid/$path/$file";

if (unlink($filePath))
	redirect();
else
	fail("Couldn't delete file.");
