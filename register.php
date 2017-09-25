<?php

session_start();

if(isset($_SESSION['user_id'])) {
	header("Location: /");
}
	
require 'database.php';

$message = '';

if (!empty($_POST['email']) && !empty($_POST['password'])):
	//Enter new user in database
	$sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
	$stmt = $conn->prepare($sql);

	$stmt->bindParam(':email', $_POST['email']);
	$stmt->bindParam(':password', password_hash($_POST['password'], PASSWORD_BCRYPT));

	if ($stmt->execute()):
		$message = 'Successfully created new user';
	else:
		$message = 'Sorry there must have been an issue creating your account';
	endif;
endif;

?>

<!DOCTYPE html>
<html>
<head>
	<title>Register Below</title>
	<link rel="stylesheet" type="text/css" href="asset/css/style.css">
	<link href='https://fonts.googleapis.com/css?family=Comfortaa' rel="stylesheet">
</head>
<body>
	<div class="header">
		<a href="/">Your App Name</a>
	</div>

	<?php if(!empty($message)): ?>
		<p><?= $message ?></p>
	<?php endif; ?>

	<h1>Register</h1>
	<span> or <a href="login.php">Login Here</a></span>

	<form action="register.php" method="POST">

		<input type="text" placeholder="Enter your email" name="email">
		<input type="password" placeholder="and password" name="password">
		<input type="password" placeholder="confirm password" name="confirm_password">

		<input type="submit">
	</form>

</body>
</html>