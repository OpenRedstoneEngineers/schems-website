<?php
	if (!$loggedin)
		fail("Not logged in.");

	if (empty($_GET['path']))
	{
		$path = "";

		$dir = "$conf->schemsDir/$username";
	}
	else
	{
		$path = urldecode($_GET['path']);

		//We don't want people to be able to list random directories,
		//so we disallow strings containing '..'
		if (preg_match("/\.\./", $path))
			die("Illegal path.");

		$dir = "$conf->schemsDir/$username/$path";
	}

	if (file_exists($dir))
		$files = scandir($dir);
	else
		$files = [];

	$files = array_filter($files, function($file)
	{
		if ($file[0] === ".")
			return false;
		else
			return true;
	});
?>

<form class='hidden' method='post' enctype='multipart/form-data' action='?a=upload'>
	<input id='uploadFile' class='hidden' type='file' name='file' onchange='this.parentNode.submit()'></input>
</form>

<div class='files'>
	<?php template("fileList", ["files"=>$files, "path"=>$path]) ?>
</div>

<script>
	var files = document.querySelectorAll(".files .file");

	for (var i in files)
	{
		var file = files[i];

		var name = file.querySelector(".name").innerHTML;
		var delButton = file.querySelector(".button-delete");
		delButton.addEventListener("click", function()
		{
			lib.msgbox("Do you want to delete the file '"+name+"'?", function()
			{
				var delurl = delButton.getAttribute("data-delurl");
				location.href = delurl;
			});
		});
	}
</script>
