<!DOCTYPE html>
<html>
	<head>
		<title>ORE Schematics</title>
	</head>
	<body class='<?=$args['page']?>'>
	<?php
		if (!empty($_SESSION['error']))
		{
	?>
		<div id="error"><?=$_SESSION['error']?></div>
	<?php
		}
	?>
		<div id="content">

