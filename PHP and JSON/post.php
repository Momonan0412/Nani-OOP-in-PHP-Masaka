<?php
require("post.class.php");
require("update.class.php");
?>
<?php
	session_start();
    if(!isset($_SESSION['user'])){
        header("location: login.php");
        exit();
    }
	if(isset($_POST['submit'])){
		$message = new PostMessage($_POST['subject'],$_POST['message'], $_POST['image']);
		if($message->checkFieldValues()){
			header("location: account.php");
			exit();
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="description" content="Pwede mamatay? JK Frfr">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
	
	<link rel="stylesheet" href="styles.css">
	<title>Event Post</title>
</head>
<body>

	<h1></h1>
    <main>
        <ul class="navigation">
			<li><a href="account.php" class="nav-link" style="color: pink; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); font-weight: bold; font-size: 1.5em;">Home</a></li>
			<li><a href="post.php" class="nav-link" style="color: whitesmoke; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); font-weight: bold; font-size: 1.5em;">Post An Event!</a></li>
        </ul>
    </main>
	<section class="container my-2">
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, 'UTF-8'); ?>" method="POST">
			<div class="mb-3">    
				<h3 style="color: gray;">Empower Your Event</h3>
			</div>
			<label>POST AN EVENT</label>
			<input type="text" name="subject" placeholder="What Event?">
			
			<label>ENTER THE EVENT'S CONTENT</label>
			<textarea name="message" placeholder="What is the event about?"></textarea>
			
			<label for="image">Select Event Image:</label>
			<input type="file" name="image" id="image" accept="image/*">
			<br>
			<div class="mb-3">    
				<input type="submit" name="submit" value="Post The Event!">
			</div>
		</form>

		<?php if (!empty($message->error)): ?>
			<p style="position: fixed;" class="alert alert-dark error"><?php echo $message->error; ?></p>
		<?php endif; ?>

		<?php if (!empty($message->success)): ?>
			<p style="position: fixed;" class="alert alert-dark success"><?php echo $message->success; ?></p>
		<?php endif; ?>
	</section>


	
</body>
</html>