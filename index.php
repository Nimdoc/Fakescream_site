<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="main.css">
		<?php
                        include "database.php";
                ?>
	</head>

	<body>
		<div id="page_wrapper">
		<?php readfile("navigation.html"); ?>


		<section id="main_section">
		<article>
			<h2>Latest Comic</h2><br>
			<?php

                                // Create connection
                                $conn = new mysqli($servername, $username, $password, $dbname);
                                // Check connection
                                if ($conn->connect_error)
                                {
                                        die("Connection failed: " . $conn->connect_error);
                                }

				$sql = "SELECT * FROM comics ORDER BY id DESC LIMIT 1";
				$result = $conn->query($sql);

				if ($result->num_rows > 0) 
				{
					$row = $result->fetch_assoc();
					echo "<img src=\"" . $row["path"] . "/" . $row["filename"]. "\"" . "width='512'>" . "<br>";
				}

				$last = $row["id"] - 1;

				echo "<li><a href=\"/comic_single.php?comic_id=" . $last . "\">PREVIOUS</a></li>";

                                $conn->close();
			?>
		</article>
		</section>
		</div>
	</body>
</html>
