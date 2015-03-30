<?php

error_reporting(E_ALL);
ini_set("display_errors", "On");

session_start();

$root = "..";

$conf = json_decode(file_get_contents("$root/conf.json"));

function fail($msg)
{
	$_SESSION['error'] = $msg;
	header("Location: " . $_SERVER['HTTP_REFERER']);
	die($msg);
}

function redirect($page)
{
	header("Location: ?p=$page");
}

function template($name, $args=[])
{
	global $root;
	include "$root/templates/$name.php";
}

if (!empty($_GET['a']))
{
	$action = $_GET['a'];

	if (!ctype_alnum($action))
		die("Action name is invalid.");
	if (!file_exists("$root/actions/$action.php"))
		die("Action $action doesn't exist.");

	include "$root/actions/$action.php";
}
else
{
	if (empty($_GET['p']))
		$page = "login";
	else
		$page = $_GET['p'];

	if (!ctype_alnum($page))
		die("Page name is invalid.");
	if (!file_exists("$root/views/$page.php"))
		die("Page $page doesn't exist.");

	template("pre", ["page"=>$page]);
	include "$root/views/$page.php";
	template("post");
}

$_SESSION['error'] = false;
