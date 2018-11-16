<?php
	ob_start();
	session_start();
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
			<?php
				// Create connection
                                $conn = new mysqli($servername, $username, $password, $dbname);
                                // Check connection
                                if ($conn->connect_error)
                                {
                                        die("Connection failed: " . $conn->connect_error);
                                }


				$msg = '';
			

				// Check if the required fields have information	
				if(isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password']))
				{
					// Get the users information
					if($stmt = $conn->prepare("SELECT * FROM users WHERE user = ?"))
					{
						$stmt->bind_param("s", $_POST['username']);

						$stmt->execute();

	                                        $stmt->bind_result($id, $user, $salt, $hash);
					
						if($stmt->fetch())
						{
							// Hash the password with the salt
							$data = $salt . $_POST['password'];

							$hash_pass = hash('sha512', $data);
						}
					}
				

					// Check if the hashes match, if so set the session variables	
					if($_POST['username'] == $user && $hash == $hash_pass)
					{
						$_SESSION['valid'] = true;
						$_SESSION['timeout'] = time();
						$_SESSION['username'] = $user;
						
						echo "<article>";	
						echo 'Valid!';
						echo "</article>";	

						header("Location: editor.php");
					}
					else // Invalid username
					{
						$msg = 'Wrong username or password.';
					}
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
		</div>
	</body>
</html>
