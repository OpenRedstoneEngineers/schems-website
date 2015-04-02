<?php
	if ($loggedin)
		redirect("browse");
?>

<form method="post" action="?a=login">
<?php
	template("map",
	[
		"Username"=>"<input class='textfield' type='text' id='username' name='username'>",
		"Password"=>"<input class='textfield' type='password' id='password' name='password'>"
	])
?>
	<button class='navbutton'>Log In</button>
</form>
