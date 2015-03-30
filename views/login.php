<form type="post" action="?a=login">
<?php
	template("map",
	[
		"Username"=>"<input type='text' id='username' name='username'>",
		"Password"=>"<input type='password' id='password' name='password'>"
	])
?>
</form>
