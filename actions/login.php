<?php

if (empty($_POST['username']) || empty($_POST['token']))
	fail("You need to submit a username and token.");

$username = $_POST['username'];
$token = $_POST['token'];

$db = new Mysqli(
	$conf->db->host,
	$conf->db->username,
	$conf->db->password,
	$conf->db->database
);

if ($db->connect_error)
	fail($db->connect_error);

//We don't want SQL injection.
$username = $db->real_escape_string($username);


$uuid = getUUID($username);

$res = $db->query("SELECT EXISTS(SELECT * FROM tokens WHERE uuid='$uuid')");

$db->close();

if (empty($res))
	fail("User $username doesn't exist.");


$user = $res->fetch_assoc();

if ($token === $user['token'])
{
	$_SESSION['loggedin'] = true;
	$_SESSION['username'] = $username;
	$_SESSION['uuid'] = $uuid;

	//Create the user's directory if it doesn't exist
	if (!file_exists("$conf->schemsDir/$uuid"))
		mkdir("$conf->schemsDir/$uuid");

	redirect("browse");
}
else
{
	fail("Wrong username or token.");
}
