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


				if($_GET["video_id"])
				{
					$video_id = $_GET["video_id"];
				}
				else
				{
					$video_id = 1;
				}
				
				if($stmt = $conn->prepare("SELECT * FROM videos WHERE id = ?"))
				{
					$stmt->bind_param("i", $video_id);

					$stmt->execute();

					$stmt->bind_result($id, $title, $author, $path, $filename);					

					while($stmt->fetch()) 
					{
						echo "<h2>" . $title . "</h2><br>";
						echo "<h4>Created by: " . $author . "</h4><br>";

						echo "<video controls>";
						echo "<source src=\"" . $path . "/" . $filename. "\"" . "type=\"video/webm\">";
						echo "</video>";
					}

					// Calculate previous video
					$transition = $video_id - 1;

					$stmt->bind_param("i", $transition);

					$stmt->execute();

					$stmt->bind_result($id, $title, $author, $path, $filename);

					echo "<ul id=\"transition\">";

					// Print previous video url if it exists
					if($stmt->fetch())
					{
						echo "<li><a href=\"/video_single.php?video_id=" . $id . "\">PREVIOUS</a></li>";
					}

					// Calculate next video
					$transition = $video_id + 1;

					$stmt->bind_param("i", $transition);

					$stmt->execute();

					$stmt->bind_result($id, $title, $author, $path, $filename);

					// Print out next video url if it exists
					if($stmt->fetch())
					{
						echo "<li><a href=\"/video_single.php?video_id=" . $id . "\">NEXT</a></li>";
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
