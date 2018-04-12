<?php
	session_start();
	if($_SESSION['valid'] != true)
	{
		echo "Access denied.";
		header("Location: editor_login.php");
		exit();
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="main.css">
	</head>

	<body>
		<div id="page_wrapper">
		<?php readfile("navigation.html"); ?>

		<section id="main_section">

			<article>
				<h1>Fakescream Editor. Welcome.</h1>
				<a href="/editor_logout.php">LOGOUT</a>

				<ul>
					<li><a href="/editor_comic.php">Sumbit Comic</a></li>
					<li><a href="/editor_joke.php">Sumbit Joke</a></li>
				</ul>
			</article>
		</section>
		</div>
	</body>
</html>
