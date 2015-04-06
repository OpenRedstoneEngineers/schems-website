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

if (empty($_GET['newname']))
	fail("You must supply a new name.");
else
	$newName = urldecode($_GET['newname']);

if (!validateName($path, '\/') || preg_match('/\.\./', $path))
	fail("Path name contains illegal characters.");
if (!validateName($file))
	fail("File name contains illegal characters.");
if (!validateName($newName))
	fail("New name contains illegal characters.");
if (pathinfo($file, PATHINFO_EXTENSION) !== pathinfo($file, PATHINFO_EXTENSION))
	fail("You can't change the file extension.");

$basePath = "$conf->schemsDir/$uuid/$path";

//die("Renaming $basePath/$file to $basePath/$newName.");

if (file_exists("$basePath/$newName"))
	fail("File '$newName' already exists.");
if (rename("$basePath/$file", "$basePath/$newName"))
	redirect();
else
	fail("Couldn't rename file.");
