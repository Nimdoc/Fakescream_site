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
			<link rel="icon" type="image/png" href="/Public/favicon.png">
			<?php
			include "database.php";
			?>
		</head>

		<body>

		<div id="page_wrapper">

		<?php readfile("navigation.html"); ?>

			<article>
				<?php

				$target_dir = "/var/www/html/Comics/";
				$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
				$ext = pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION);
				$cur_time = time();
				$target_filename = $target_dir . $cur_time . "." . $ext;
				$uploadOk = 1;
				$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
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


					$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
					if($check !== false)
					{
						echo "File is an image - " . $check["mime"] . ".";
						$uploadOk = 1;
					}
					else
					{
						echo "File is not an image.";
						$uploadOk = 0;
						}
					}
					// Check if file already exists
					if (file_exists($target_file))
					{
						echo "Sorry, file already exists.";
						$uploadOk = 0;
					}
					// Check file size
					if ($_FILES["fileToUpload"]["size"] > 500000)
					{
						echo "Sorry, your file is too large.";
						$uploadOk = 0;
					}
					// Allow certain file formats
					if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
					&& $imageFileType != "gif" )
					{
						echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
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
						if ($stmt = $conn->prepare("INSERT INTO comics (title, author, path, filename) VALUES (?, ?, \"Comics\", ?)"))
						{
							if(!$stmt->bind_param("sss", $db_title, $db_user, $db_name))
								echo " Parameter Bind Error. <br>";


							$db_user = $_SESSION['username'];
							$db_title = $_POST["title"];
							$db_name = $cur_time . "." . $ext;
						
							if(!$stmt->execute())
								echo "Statement Execution Error. <br>";

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
					}
				echo "<br><br>Redirecting in 5 seconds...";
				header( "refresh:5;url=editor_comic.php" );
				?>

		</article>
		</div>
	</body>
</html>


