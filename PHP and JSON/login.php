<?php require("login.class.php") ?>
<?php 
	if(isset($_POST['submit'])){
		$user = new LoginUser($_POST['username'], $_POST['password']);
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="styles.css">
	<title>Log in form</title>
</head>
<body>
    <section class="container my-2">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, 'UTF-8'); ?>" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="mb-3">
                <h2>LOGIN</h2>
            </div>
            <div class="mb-3">
                <label class="form-label">Username</label> <br>
                <input class="form-control" type="text" name="username">
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label> <br>
                <input class="form-control" type="password" name="password">
            </div>
            <div class="mb-3">
                <button style="background-color: black;" class="btn btn-outline-light me-2" type="submit" name="submit">Log in</button>
				<small id="emailHelpId" class="form-text text-muted">You don't have an account? <a href="index.php">Register</a> </small>
            </div>
			<?php if (!empty($user->error)): ?>
				<p class="alert alert-dark"  class="error"><?php echo $user->error; ?></p>
			<?php endif; ?>
			<?php if (!empty($user->success)): ?>
				<p class="alert alert-dark"  class="success"><?php echo $user->success; ?></p>
			<?php endif; ?>

        </form>
    </section>
</body>
</html>