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
				140 Character limit right now, keep that in mind. Check character count before submitting. Will eventually change it. Newlines don't work, make your jokes work in one sentence.
				<a href="/editor.php">BACK</a>
                        	<form action="editor_joke_submit.php" method="post" enctype="multipart/form-data">
                                Input Joke:<br>
                                <textarea rows="10" cols="60" type="text" name="joke" id="joke"></textarea><br>
                                <input type="submit" value="Submit Joke" name="submit">
                        </form>

			</article>
                </section>
		</div>
        </body>
</html>

