<?php
	if ($args['files'])
	{
		foreach($args['files'] as $file)
		{
			$urlfile = urlencode($file);
			$urlpath = urlencode($args['path']);

			$downloadUrl = "?a=download&file=$urlfile&path=$urlpath";
			$renameUrl = "?a=rename&file=$urlfile&path=$urlpath&newname=";
			$deleteUrl = "?a=delete&file=$urlfile&path=$urlpath";
?>
	<div class='file'>
		<a href='<?=$downloadUrl?>' class='name'><?=$file?></a>
		<a href='javascript:void(0)' data-renameUrl='<?=$renameUrl?>' class='button-rename'>Rename</a>
		<a href='javascript:void(0)' data-deleteUrl='<?=$delurl?>' class='button-delete'>Delete</a>
	</div>
<?php
		}
	}
	else
	{
?>
	There is nothing here.
<?php
	}
?>
