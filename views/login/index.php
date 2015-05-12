<?php
	if ($loggedin)
		redirect("browse");
?>

<form method="post" action="?a=login">
	<?php
		template("map",
		[
			"Minecraft Username"=>"<input class='textfield' type='text' id='username' name='username'>",
			"Minecraft Password"=>"<input class='textfield' type='password' id='password' name='password'>"
		]);
	?>
	<button class='navbutton'>Log In</button>
</form>
