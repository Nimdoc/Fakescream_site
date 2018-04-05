<?php
	ob_start();
	session_start();
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="main.css">
	</head>

	<body>
		<?php readfile("navigation.html"); ?>

		<section id="main_section">
			<?php
				$msg = '';
				
				if(isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password']))
					if($_POST['username'] == 'user' && $_POST['password'] == 'abc')
					{
						$_SESSION['valid'] = true;
						$_SESSION['timeout'] = time();
						$_SESSION['username'] = 'user';
						
						echo "<article>";	
						echo 'Valid!';
						echo "</article>";	

						header("Location: editor.php");
					}
					else // Invalid username
					{
						$msg = 'Wrong username.';
					}
			?>

			<article>
				<form class = "form-signin" role = "form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post">
				
				<h4 class = "form-signin-heading"><?php echo $msg; ?></h4>

				<input type = "text" class = "form-control" 
					name = "username" placeholder = "username" 
					required autofocus></br>
				<input type = "password" class = "form-control"
					name = "password" placeholder = "password" required>
				<button class = "btn btn-lg btn-primary btn-block" type = "submit" 
					name = "login">Login</button>
			</article>
		</section>
	</body>
</html>
