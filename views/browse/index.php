<?php
	if (!$loggedin)
		fail("Not logged in.");

	if (empty($_GET['path']))
	{
		$path = "";

		$dir = "$conf->schemsDir/$uuid";
	}
	else
	{
		$path = urldecode($_GET['path']);

		//We don't want people to be able to list random directories,
		//so we disallow strings containing '..'
		if (preg_match("/\.\./", $path))
			die("Illegal path.");

		$dir = "$conf->schemsDir/$uuid/$path";
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

	function addListeners(file)
	{
		var name = file.querySelector(".name").innerHTML;

		file.querySelector(".button-delete").addEventListener("click", function(evt)
		{
			lib.msgbox("Do you want to delete the file '"+name+"'?", function()
			{
				var deleteUrl = evt.srcElement.getAttribute("data-deleteUrl");
				location.href = deleteUrl;
			});
		});

		file.querySelector(".button-rename").addEventListener("click", function(evt)
		{
			var ext = name.match(/\.(prog|schematic)$/)[0];
			var baseName = name.replace(/\.(prog|schematic)$/, "");
			lib.msgbox("New Name:<br><input class='file-newname' type='text' value='"+baseName+"'>", function()
			{
				var newName = document.querySelector("#msgbox .file-newname").value;
				var renameUrl = evt.srcElement.getAttribute("data-renameUrl");
				location.href = renameUrl+encodeURIComponent(newName.trim()+ext);
			});
		});
	}

	for (var i in files)
	{
		if (files[i] instanceof Node)
			addListeners(files[i]);
	}
</script>
