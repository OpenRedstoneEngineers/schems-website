<?php

error_reporting(E_ALL);
ini_set("display_errors", "Off");

$root = "..";

session_start();

$conf = json_decode(file_get_contents("$root/conf.json"));

if (empty($_SESSION['loggedin']) || !$_SESSION['loggedin'])
	$loggedin = false;
else
	$loggedin = true;

if ($loggedin)
{
	$username = $_SESSION['username'];
	$uuid = $_SESSION['uuid'];
	if ($username == "" || $uuid == "")
	{
		$loggedin = false;
	}
}
else
{
	$username = "";
	$uuid = "";
}

//We don't want evil characters in our usernames, file names, etc.
//However, we need to be able to customize which characters are allowed
//in some cases, for example we need to allow a / in file paths.
function validateName($name, $extraChars="")
{
	if (preg_match("/^[a-zA-Z0-9\._$extraChars]*$/", $name))
		return true;
	else
		return false;
}

function fail($msg, $page=false)
{
	global $loggedin;

	$_SESSION['error'] = $msg;

	if ($page)
		$location = "?p=$page";
	else if ($loggedin)
		$location = "?p=browse";
	else
		$location = "?p=login";

	header("Location: $location");
	die($msg);
}

function redirect($page=false)
{
	if ($page)
		header("Location: ?p=$page");
	else
		header("Location: $_SERVER[HTTP_REFERER]");

	die();
}

function template($name, $args=[])
{
	global $root;
	global $loggedin;
	global $username;
	global $uuid;
	global $conf;
	include "$root/templates/$name.php";
}

function getUUID($name)
{
	$options =
	[
		"http"=>
		[
			"header"=>"Content-Type: application/json",
			"method"=>"POST",
			"content"=>json_encode([$name])
		]
	];
	$context = stream_context_create($options);
	$result = file_get_contents("https://api.mojang.com/profiles/minecraft", false, $context);
	return json_decode($result)[0]->id;
}

//We don't want evil usernames.
if ($loggedin && !validateName($username))
{
	$_SESSION['username'] = "";
	$_SESSION['loggedin'] = false;
	fail("Your username contains illegal characters.", "login");
}

//Do an "action" (run a script which isn't supposed to produce HTML, but rather
//redirect back to a page) if the 'a' GET parameter is supplied
if (!empty($_GET['a']))
{
	$action = $_GET['a'];

	if (!ctype_alnum($action))
		die("Action name is invalid.");
	if (!file_exists("$root/actions/$action.php"))
		die("Action $action doesn't exist.");

	include "$root/actions/$action.php";
}

//If no action is supplied, we want to show a page the user requests. If no
//page URL parmeter ('p') is supplied, we intelligently pick which page to show.
else
{
	if (empty($_GET['p']))
	{
		if ($loggedin)
			$page = "browse";
		else
			$page = "login";
	}
	else
	{
		$page = $_GET['p'];
	}

	if (!validateName($page))
		die("Page name is invalid.");
	if (!file_exists("$root/views/$page/index.php"))
		die("Page $page doesn't exist.");

	template("index", ["page"=>$page]);

	$_SESSION['error'] = false;
}
