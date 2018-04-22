<?php

session_start();
if($_SESSION['valid'] != true)
{
		echo "Access denied.";
		header("Location: editor_login.php");
		exit();
	}

	?>


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

			<article>
				<?php

				$target_dir = "/var/www/html/Videos/";
				$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
				$ext = pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION);
				$cur_time = time();
				$target_filename = $target_dir . $cur_time . "." . $ext;
				$uploadOk = 1;
				$file_type = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
				// Check if image file is a actual image or fake image
				if(isset($_POST["submit"]))
				{

					// Create connection
					$conn = new mysqli($servername, $username, $password, $dbname);
					// Check connection
					if ($conn->connect_error)
					{
						echo "Database Error.";
						die("Connection failed: " . $conn->connect_error);
					}

					echo $_FILES["fileToUpload"]["name"];
					echo "<br>";
					echo $_FILES["fileToUpload"]["size"];
					echo "<br>";

					// Check file size
					if ($_FILES["fileToUpload"]["size"] > 16000000)
					{
						echo "Sorry, your file is too large.";
						$uploadOk = 0;
					}
					// Allow certain file formats
					if($file_type != "webm")
					{
						echo "Sorry, only WEBM files are allowed.";
						$uploadOk = 0;
					}
					// Check if $uploadOk is set to 0 by an error
					if ($uploadOk == 0)
					{
						echo "Sorry, your file was not uploaded.";
						// if everything is ok, try to upload file
					}
					else
					{
					if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_filename))
					{
						if ($stmt = $conn->prepare("INSERT INTO videos (title, author, path, filename) VALUES (?, \"User\", \"Videos\", ?)"))
						{
							if(!$stmt->bind_param("ss", $db_title, $db_name))
								echo "Error.";

							$db_title = $_POST["title"];
							$db_name = $cur_time . "." . $ext;
						
							if(!$stmt->execute())
								echo "Error.";

							echo $_POST["title"];
							echo "<br>";
							echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
						}
						else
						{
							echo "Database error";
						} 
					}
					else
					{
						echo "Sorry, there was an error uploading your file.";
					}
					echo "<br><br>Redirecting in 5 seconds...";
					header( "refresh:5;url=editor_video.php" );
					} 
					}
				?>

		</article>
		</div>
	</body>
</html>
