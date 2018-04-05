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

		<article>
			<a href="/editor.php">BACK</a>
			<form action="editor_comic_upload.php" method="post" enctype="multipart/form-data">
				Select image to upload:
				<input type="text" name="title" id="title">
				<input type="file" name="fileToUpload" id="fileToUpload">
				<input type="submit" value="Upload Image" name="submit">
			</form>
		</article>
		</div>
        </body>
</html>

