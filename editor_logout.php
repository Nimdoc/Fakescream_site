<!DOCTYPE html>
<html>
        <head>
                <link rel="stylesheet" type="text/css" href="main.css">
		<link rel="icon" type="image/png" href="/Public/favicon.png">
        </head>

        <body>
                <div id="page_wrapper">
                <?php readfile("navigation.html"); ?>

                <section id="main_section">
                        <article>
				<?php
					session_start();
					unset($_SESSION["username"]);
					unset($_SESSION["password"]);
					unset($_SESSION["valid"]);

					if (isset($_COOKIE[session_name()])) {
						setcookie(session_name(), '', time()-42000, '/');
					}

					session_destroy();
					   
					echo 'Logout successful.';
					header('Refresh: 2; URL = index.php');
				?>
                        </article>
                </section>
                </div>
        </body>
</html>

