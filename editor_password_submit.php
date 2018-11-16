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
					
					// Check if password has been submitted	
					if(!empty($_POST['password']))
					{
						$user = $_SESSION['username'];

						// Get the users information from the database
						if($stmt = $conn->prepare("SELECT * FROM users WHERE user = ?"))	
						{
							$stmt->bind_param("s", $_SESSION['username']);

							$stmt->execute();

							$stmt->bind_result($id, $db_user, $salt, $hash);

							$stmt->fetch();	
						}
						else
						{
							echo "Can't get salt.";
						}

						$stmt->close();

						// Process the new password into the database
						if ($stmt = $conn->prepare("UPDATE users SET hash = ? WHERE user = ?")) 
						{
							$data = $salt . $_POST['password'];

							$hash_pass = hash('sha512', $data);

							$stmt->bind_param("ss", $hash_pass, $_SESSION['username']);

							$stmt->execute();

							echo "Processing password";
						}
						else // Error
						{
							echo "Unsuccessful.";
						}
					}
					echo "<br><br>Redirecting in 5 seconds...";
					header( "refresh:5;url=editor.php" );
				?>
                        </article>
                </section>
		<div id="page_wrapper">
        </body>
</html>

