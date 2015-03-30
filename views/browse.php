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

<div class="menu">
	<button>Upload</button>
	<button onclick='location.href="?a=logout"'>Log Out</button>
</div>

<div class='files'>
<?php
	foreach($files as $file)
	{
		$urlfile = urlencode($file);
		$urlpath = urlencode($path);
		$dlurl = "?a=download&file=$urlfile&path=$urlpath";

		if ($file[0] !== ".")
		{
	?>
		<a href='<?=$dlurl?>' class='file'>
			<?=$file?>
		</div>
	<?php
		}
	}
?>
</div>
