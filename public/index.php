<?php

error_reporting(E_ALL);
ini_set("display_errors", "On");

$root = "..";

$conf = json_decode(file_get_contents("$root/conf.json"));

function fail($msg)
{
	die($msg);
}

function template($name, $args)
{
	global $root;
	include "$root/templates/$name.php";
}

if (!empty($_GET['a']))
{
	$action = $_GET['a'];

	if (!ctype_alnum($action))
		fail("Action name is invalid.");
	if (!file_exists("$root/actions/$action.php"))
		fail("Action doesn't exist.");

	include "$root/actions/$action.php";
}
else
{
	$page = $_GET['p'];

	if (empty($page))
		$page = "browse";
	if (!ctype_alnum($page))
		fail("Page name is invalid.");
	if (!file_exists("$root/views/$page.php"))
		fail("Page doesn't exist.");

	include "$root/templates/pre.php";
	include "$root/views/$page.php";
	include "$root/templates/post.php";
}
