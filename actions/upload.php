<?php

if (!$loggedin)
	fail("You're not logged in.");

if (empty($_FILES['file']))
	fail("No file specified.");

if (empty($_GET['path']))
	$path = "";
else
	$path = urldecode($_GET['path']);

$allowedExtensions = ["schematic", "prog"];

$file = $_FILES['file'];
$file['ext'] = strtolower(end(explode(".", $file['name'])));

if (!in_array($file['ext'], $allowedExtensions))
	fail("Extension $file[ext] is not allowed.");
if ($file['size'] > $conf->maxFileSize)
	fail("File too big.");
if (!validateName($file['name']))
	fail("File name contains illegal characters.");
if (!validateName($path, '\/') || preg_match('/\.\./', $path))
	fail("Path name contains illegal characters.");

$uploadPath = "$conf->schemsDir/$uuid/$path/$file[name]";

if (move_uploaded_file($file['tmp_name'], $uploadPath))
	redirect();
else
	fail("Couldn't upload file.");
