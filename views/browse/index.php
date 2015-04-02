<?php
	if (!$loggedin)
		fail("Not logged in.");

	if (empty($_GET['path']))
	{
		$path = "";

		$dir = "$conf->schemsDir/$_SESSION[username]";
	}
	else
	{
		$path = urldecode($_GET['path']);

		//We don't want people to be able to list random directories,
		//so we disallow strings containing '..'
		if (preg_match("/\.\./", $path))
			die("Illegal path.");

		$dir = "$conf->schemsDir/$_SESSION[username]/$path";
	}

	$files = scandir($dir);
?>

<form class='hidden' method='post' action='?a=upload'>
	<input id='uploadFile' class='hidden' type='file' onclick='this.parentNode.submit()'></input>
</form>

<div class='files'>
	<?php template("fileList", ["files"=>$files, "path"=>$path]) ?>
</div>

<script>
	var files = document.querySelectorAll(".files .file");

	for (var i in files)
	{
		var file = files[i];

		var delButton = file.querySelector(".button-delete");
		delButton.addEventListener("click", function()
		{
			lib.msgbox("Do you want to delete this file?", function()
			{
				var delurl = delButton.getAttribute("data-delurl");
				location.href = delurl;
			});
		});
	}
</script>