<?php
	foreach($args['files'] as $file)
	{
		$urlfile = urlencode($file);
		$urlpath = urlencode($args['path']);

		$dlurl = "?a=download&file=$urlfile&path=$urlpath";
		$delurl = "?a=delete&file=$urlfile&path=$urlpath";

		if ($file[0] !== ".")
		{
?>
	<div class='file'>
		<a href='<?=$dlurl?>' class='name'><?=$file?></a>
		<a href='javascript:void(0)' data-delurl='<?=$delurl?>' class='button-delete'>Delete</a>
	</div>
<?php
		}
	}
?>
