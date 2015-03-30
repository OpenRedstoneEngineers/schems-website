<?php

if (empty($_POST['username']) || empty($_POST['password']))
	fail("You need to submit a username and password.");

$username = $_POST['username'];
$password = $_POST['password'];

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

$res = $db->query("SELECT * FROM users WHERE username='$username'");

$db->close();

if (empty($res))
	fail("User $username doesn't exist.");

$user = $res->fetch_assoc();
$hash = MD5($user['salt'] . $_POST['password']);

if ($hash === $user['password'])
{
	$_SESSION['loggedin'] = true;
	$_SESSION['username'] = $username;
	redirect("browse");
}
else
{
	fail("Wrong username or password.");
}
