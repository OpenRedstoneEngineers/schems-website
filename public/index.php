<?php

error_reporting(E_ALL);
ini_set("display_errors", "On");

session_start();

$root = "..";

$conf = json_decode(file_get_contents("$root/conf.json"));

function fail($msg, $page=false)
{
	$_SESSION['error'] = $msg;
	if ($page)
		$location = "?p=$page";
	else if (empty($_SERVER['HTTP_REFERER']))
		$location = "?p=login";
	else
		$location = $_SERVER['HTTP_REFERER'];

	header("Location: $location");
	die($msg);
}

function redirect($page)
{
	header("Location: ?p=$page");
}

if (empty($_SESSION['loggedin']) || !$_SESSION['loggedin'])
	$loggedin = false;
else
	$loggedin = true;

if ($loggedin)
	$username = $_SESSION['username'];
else
	$username = "";

function template($name, $args=[])
{
	global $root;
	global $loggedin;
	global $conf;
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
	if (!file_exists("$root/views/$page/index.php"))
		die("Page $page doesn't exist.");

	template("index", ["page"=>$page]);
}

$_SESSION['error'] = false;
