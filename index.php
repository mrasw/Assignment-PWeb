<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Login</title>
	</head>
	<body>
	
	<?= (isset($_SESSION['errlog'])) ? "<div class='alert alert-danger'>Username atau password anda salah.</div>" : "" ?>
			


		<form method="POST" action="login_proses.php">
				<div class="form-group">
					<label>Username</label>
					<input type="text" name="username">
				</div>
					<label>Password</label>
					<input type="password" name="password">
				</div>
				<input type="submit" value="Login">
			</form>
		</div>
	</body>
</html>
<?php session_unset(); ?>
