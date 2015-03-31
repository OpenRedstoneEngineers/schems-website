<?php
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

<div class="menu">
	<button onclick='document.getElementById("uploadFile").click()'>Upload</button>
	<button onclick='location.href="?a=logout"'>Log Out</button>
</div>

<div class='files'>
<?php
	foreach($files as $file)
	{
		$urlfile = urlencode($file);
		$urlpath = urlencode($path);

		$dlurl = "?a=download&file=$urlfile&path=$urlpath";
		$delurl = "?a=delete&file=$urlfile&path=$urlpath";

		if ($file[0] !== ".")
		{
	?>
		<div class='file'>
			<a href='<?=$dlurl?>' class='name'><?=$file?></a>
			<a href='javascript:void(0)' data-delurl='<?$delurl?>' class='button-delete'>Delete</a>
		</div>
	<?php
		}
	}
?>
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
