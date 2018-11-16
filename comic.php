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
				<ul id="comic_list">
				<?php
						
				// Create connection
				$conn = new mysqli($servername, $username, $password, $dbname);
				// Check connection
				if ($conn->connect_error) 
				{
					die("Connection failed: " . $conn->connect_error);
				} 	

				// Get the current page to load
				if($_GET["page"])
				{
					$page = $_GET["page"];
				}
				else // No page set, default to 0
				{
					$page = 0;
				}

				// Calculate the comics to load
				$pg_lower = 10 * $page;
                                $pg_upper = (10 * $page) + 10;
				
				// Query the database
				if($stmt = $conn->prepare("SELECT * FROM comics WHERE id > ? and id <= ?"))
				{
					$stmt->bind_param("ii", $pg_lower, $pg_upper);

					$stmt->execute();

					$stmt->bind_result($id, $title, $author, $path, $filename);					

					// Print out the comics
					while($stmt->fetch()) 
					{
						echo "<li>";
						echo "<a href=\"/comic_single.php?comic_id=" . $id . "\">" . $title . "</a>";
					}
				}
				$stmt->close();
				$conn->close(); 
				?>
				</ul>
			</article>
		</section>
		</div>
	</body>
</html>
