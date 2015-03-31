<!DOCTYPE html>
<html>
	<head>
		<title>ORE Schematics</title>
		<link rel='stylesheet' href='style.css'>
	</head>
	<body class='<?=$args['page']?>'>
	<?php
		if (!empty($_SESSION['error']))
		{
	?>
		<div id='error'><?=$_SESSION['error']?></div>
	<?php
		}
	?>

		<div id='msgbox' class='hidden'>
			<div class='content'></div>
			<button class='button-cancel'>Cancel</button>
			<button class='button-ok'>Ok</button>
		</div>

		<div id='content'>
