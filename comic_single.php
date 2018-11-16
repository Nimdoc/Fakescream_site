<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="main.css">
		<link rel="icon" type="image/png" href="/Public/favicon.png">
		<?php
			include "database.php";
		?>
	</head>

	<body>
		<div id="page_wrapper">

		<?php readfile("navigation.html"); ?>
		<section id="main_section">
			<article>
				<?php
		
				// Create connection
				$conn = new mysqli($servername, $username, $password, $dbname);
				// Check connection
				if ($conn->connect_error) 
				{
					die("Connection failed: " . $conn->connect_error);
				} 	


				if($_GET["comic_id"])
				{
					$comic_id = $_GET["comic_id"];
				}
				else
				{
					$comic_id = 1;
				}
				
				if($stmt = $conn->prepare("SELECT * FROM comics WHERE id = ?"))
				{
					$stmt->bind_param("i", $comic_id);

					$stmt->execute();

					$stmt->bind_result($id, $title, $author, $path, $filename);					

					while($stmt->fetch()) 
					{
						echo "<h2>" . $title . "</h2><br>";
						echo "<h4>Created by: " . $author . "</h4><br>";
						echo "<img src=\"" . $path . "/" . $filename. "\"" . "width='512'>" . " <br>";
					}

					$transition = $comic_id - 1;

					$stmt->bind_param("i", $transition);

					$stmt->execute();

					$stmt->bind_result($id, $title, $author, $path, $filename);

					echo "<ul id=\"transition\">";

					if($stmt->fetch())
					{
						echo "<li><a href=\"/comic_single.php?comic_id=" . $id . "\">PREVIOUS</a></li>";
					}

					$transition = $comic_id + 1;

					$stmt->bind_param("i", $transition);

					$stmt->execute();

					$stmt->bind_result($id, $title, $author, $path, $filename);

					if($stmt->fetch())
					{
						echo "<li><a href=\"/comic_single.php?comic_id=" . $id . "\">NEXT</a></li>";
					}

					echo "</ul>";
				}
				$stmt->close();
				$conn->close(); 
				?>
			</article>
		</section>
		</div>
	</body>
</html>
