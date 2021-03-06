<?php

if (empty($_POST['username']) || empty($_POST['password']))
	fail("You need to submit a username and password.");

function randomString($length)
{
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";	

	$str = "";
	$size = strlen($chars);
	for($i = 0; $i < $length; ++$i) {
		$str .= $chars[rand(0, $size - 1)];
	}

	return $str;
}

$username = $_POST['username'];
$password = $_POST['password'];

if (isset($_COOKIE['clienttoken']))
{
	$clientToken = $_COOKIE['clienttoken'];
}
else
{
	$clientToken = randomString(32);
	setcookie("clienttoken", $clientToken);
}

$content = json_encode([
	"agent"=>
	[
		"name"=>"Minecraft",
		"version"=>1
	],
	"username"=>addslashes($username),
	"password"=>addslashes($password),
	"clientToken"=>$clientToken
]);

$options =
[
	"http"=>
	[
		"header"=>"Content-Type: application/json",
		"method"=>"POST",
		"content"=>$content
	]
];

$context = stream_context_create($options);

//We silence errors here because PHP displays errors, not catchable with a try/tach,
//if the server responds with a 403 Forbidden, and mojang's API does that
//when the username and password doesn't match.
@$result = file_get_contents("https://authserver.mojang.com/authenticate", false, $context);

if (!$result)
{
	fail("Incorrect username or password.");
}

$result = json_decode($result);

if (!empty($result->error))
{
	fail($result->errorMessage, "login");
}
else
{
	$uuid = $result->selectedProfile->id;

	setcookie("accesstoken", $result->accessToken);
	setcookie("clienttoken", $result->clientToken);
	setcookie("username", $result->selectedProfile->name);
	setcookie("uuid", $uuid);

	$_SESSION['loggedin'] = true;

	//Create the user's directory if it doesn't exist
	if (!file_exists("$conf->schemsDir/$uuid"))
		mkdir("$conf->schemsDir/$uuid");

	redirect("browse");
}
