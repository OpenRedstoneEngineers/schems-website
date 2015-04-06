<!DOCTYPE html>
<html>
	<head>
		<title>ORE Schematics</title>
		<meta charset='utf-8'>
		<link rel='stylesheet' href='style.css'>
		<link href='http://fonts.googleapis.com/css?family=Josefin+Sans:400,300' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300' rel='stylesheet' type='text/css'>
		<meta name='viewport' content='width=device-width,initial-scale=1'>
	</head>
	<body class='<?=$args['page']?>'>

		<div id='header'>
			<div class='logo'>
				<h2 class='acronym'>ORE</h2>
				<h1 class='title'>Open Redstone Engineers</h1>
				<div class='menu'>
				<?php
					if (file_exists("$root/views/$args[page]/menu.php"))
						include "$root/views/$args[page]/menu.php";
				?>
				</div>
			</div>
		</div>

		<?php
			if (!empty($_SESSION['error']))
			{
		?>
			<div id='error'><?=$_SESSION['error']?></div>
		<?php
			}
		?>

		<div id='msgbox'>
			<div class='content'></div>
			<div class='buttons'>
				<button class='smallbutton button-cancel'>Cancel</button>
				<button class='smallbutton button-ok'>Ok</button>
			</div>
		</div>

		<div id='content'>
			<?php include "$root/views/$args[page]/index.php" ?>
		</div>

		<script src="script.js"></script>
	</body>
</html>
