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

					$conn = new mysqli($servername, $username, $password, $dbname);
					// Check connection
					if ($conn->connect_error)
					{
						die("Connection failed: " . $conn->connect_error);
					}

					// Insert the joke into the database.
					if ($stmt = $conn->prepare("INSERT INTO jokes (joke, author) VALUES (?, ?)")) 
					{
						$user = $_SESSION['username'];

						$stmt->bind_param("ss", $_POST["joke"], $user);

						$stmt->execute();

						echo "Processing submission.";

					}
					else // DB error.
					{
						echo "Cannot prepare statement.";
					}
						echo "<br><br>Redirecting in 5 seconds...";
						header( "refresh:5;url=editor_joke.php" );
				?>
                        </article>
                </section>
		<div id="page_wrapper">
        </body>
</html>

