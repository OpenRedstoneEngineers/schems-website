<?php
	if ($loggedin)
		redirect("browse");

	//If all necessary cookies exist, validate the access token
	if (isset($_COOKIE['accesstoken'])
	&&  isset($_COOKIE['clienttoken'])
	&&  isset($_COOKIE['username'])
	&&  isset($_COOKIE['uuid']))
	{
		$content = json_encode([
			"accessToken"=>$_COOKIE['accesstoken']
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

		@$result = file_get_contents("https://authserver.mojang.com/validate", false, $context);

		//If the token is valid, the API returns nothing with status code 200.
		//If it's invalid, the API returns an error text with the status code
		//403 permission denied.
		if ($result === "")
		{
			$_SESSION['loggedin'] = true;
			redirect("browse");
		}
		else
		{
			setcookie("accesstoken", "");
		}
	}
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
