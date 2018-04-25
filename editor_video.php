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
		<link rel="icon type="image/png" href="/Public/favicon.png">
	</head>

        <body>
		<div id="page_wrapper">
		<?php readfile("navigation.html"); ?>
		
                <section id="main_section">
		<article>
			<a href="/editor.php">BACK</a>
			<form action="editor_video_upload.php" method="post" enctype="multipart/form-data">
				Select video to upload:
				<input type="text" name="title" id="title">
				<input type="file" name="fileToUpload" id="fileToUpload">
				<input type="submit" value="Upload Video" name="submit">
			</form>
		</article>
		</section>
		</div>
        </body>
</html>

