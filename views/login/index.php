<?php
	if ($loggedin)
		redirect("browse");
?>

<form method="post" action="?a=login">
	<?php
		template("map",
		[
			"Username"=>"<input class='textfield' type='text' id='username' name='username'>",
			"Token"=>"<input class='textfield' type='password' id='token' name='token'>"
		])
	?>
	<button class='navbutton'>Log In</button>
</form>
