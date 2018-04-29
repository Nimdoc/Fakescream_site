<!DOCTYPE html>
<html>
        <head>
                <link rel="stylesheet" type="text/css" href="main.css">
		<link rel="icon type="image/png" href="/Public/favicon.png">
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

                                        $conn = new mysqli($servername, $username, $password, $dbname);
                                        // Check connection
                                        if ($conn->connect_error)
                                        {
                                                die("Connection failed: " . $conn->connect_error);
                                        }

					if($_GET["page"])
					{
						$page = $_GET["page"];
					}
					else
					{
						$page = 0;
					}

					$pg_lower = 10 * $page;
					$pg_upper = (10 * $page) + 10;

				
                                        if ($stmt = $conn->prepare("SELECT * FROM jokes WHERE id > ? and id <= ?"))   
                                        {
                                                $stmt->bind_param("ii", $pg_lower, $pg_upper);

                                                $stmt->execute();

						$stmt->bind_result($id, $joke, $author);

						while ($stmt->fetch()) 
						{
							echo "<div id=\"joke\">" . $joke . "<br><br>-" . $author . "</div><br><br>";
						}
                                        }

					$stmt->close();

					if ($stmt = $conn->prepare("SELECT * FROM jokes WHERE id < ?"))
                                        {
						$prev_id = ($_GET["page"]) * 10;

						$stmt->bind_param("i", $prev_id);
						
						$stmt-> execute();

						$stmt->bind_result($id, $joke, $author);

						if($stmt->fetch())
						{
							echo "<li><a href=\"/jokes.php?page=" . ($_GET["page"] - 1) . "\">PREV</a></li>";
						}
                                        }

					$stmt->close();

					if ($stmt = $conn->prepare("SELECT * FROM jokes WHERE id > ?"))
                                        {
						$next_id = ($_GET["page"] + 1) * 10;

						$stmt->bind_param("i", $next_id);

						$stmt-> execute();

						$stmt->bind_result($id, $joke, $author);

						if($stmt->fetch())
						{
							echo "<li><a href=\"/jokes.php?page=" . ($_GET["page"] + 1) . "\">NEXT</a></li>";
						}
                                        }

					$conn->close();
                                ?>
                        </article>
                </section>
		</div>
        </body>
</html>

