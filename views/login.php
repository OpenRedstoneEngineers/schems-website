<?php
	if ($_SESSION['loggedin'])
		redirect("browse");
?>

<form method="post" action="?a=login">
<?php
	template("map",
	[
		"Username"=>"<input type='text' id='username' name='username'>",
		"Password"=>"<input type='password' id='password' name='password'>"
	])
?>
	<button>Log In</button>
</form>
