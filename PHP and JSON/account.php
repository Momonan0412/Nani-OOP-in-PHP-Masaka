<?php
	require("logout.class.php");
	require("update.class.php");
    $update = new HandleJsonFile();
    $jsonData = $update->getMessagesData();
?>
<?php 
    session_start();
    if(!isset($_SESSION['user'])){
        header("location: login.php");
        exit();
    }

    if(isset($_GET['logout'])){
        LogoutUser::logout();
        header("location: login.php");
        exit();
    }
    if(isset($_GET['submit'])){
		$update->deleteMessage($_GET['userId']);
		header("location: account.php");
		exit();
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
	<link rel='stylesheet' href='styles.css'>
    <link rel="stylesheet" href="HeartButton.css">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
	<title>User account</title>
</head>

<header class="p-3 text-bg-dark">
	<div class="container">
    <form id="logout-form" method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, 'UTF-8'); ?>">
    <label style="text-align: center;" for="">
        <h2 style="color: black; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); font-weight: bold; font-size: 1.5em;" >WELCOME!</h2>
        <h4>
            <span style="color: pink; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); font-weight: bold; font-size: 1.5em;">
                <?php echo $_SESSION['user']; ?>!
            </span>
        </h4>
    </label>
        <button style="background-color: black;" class="btn btn-outline-light me-2" type="submit" name="logout">Sign Out</button>
    </form>
	<main>
	<div class="nav-container">
		<ul class="navigation">
			<li><a href="account.php" class="nav-link" style="color: pink; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); font-weight: bold; font-size: 1.5em;">Home</a></li>
			<li><a href="post.php" class="nav-link" style="color: whitesmoke; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); font-weight: bold; font-size: 1.5em;">Post An Event!</a></li>
            <?php
            if (isset($_SESSION['usertype']) && $_SESSION['usertype'] === 'admin') {
                echo "<li><a href='delete.user.php' class='nav-link' style='color: whitesmoke; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); font-weight: bold; font-size: 1.5em;'>Delete A User!</a></li>";
            }
            ?>
		</ul>
	</div>
	</main>  
    </div>
</header>
<body>
<table>
    <thead>
        <tr>
            <th>Post ID</th>
            <th>Username</th>
            <th>Event</th>
            <th>Description</th>
            <th>Event Image</th>
            <?php
            // Check if the user has 'admin' usertype
            if (isset($_SESSION['usertype']) && $_SESSION['usertype'] === 'admin') {
                echo '<th>Action</th>';
            }
            if (isset($_SESSION['usertype']) && $_SESSION['usertype'] === 'user') {
                echo '<th>Action</th>';
            }
            ?>
        </tr>
        
    </thead>
    <tbody id="tableBody">
        <?php
        foreach ($jsonData as $item) {
            echo "<tr>";
            foreach ($item as $key => $value) {
                if ($key !== "user_id" && $key !== "image" && $key !== "post_id" && $key !== "username") {
                    echo "<td style='width: 300px; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);'>$value
                    </td>";
                } elseif ($key === "image") {
                    echo "<td style='width: 300px; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);'><img style='height: 300px; width: auto; border-radius: 15px; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2)' src='./Images/$value' alt=''>
                    <div class='heart-btn'>
                    <div class='content'>
                    <span class='heart'></span>
                    <span class='text'>Like</span>
                    <span class='numb'></span>
                    </div>
                    </div>
                    </td>";
                } elseif ($key === "post_id" ) {
                    echo "<td style='width: 300px; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); font-weight: bold; font-size: 50px; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);'>$value</td>";
                } elseif ($key === "username" ) {
                    echo "<td style='width: 300px; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); font-weight: bold; font-size: 25px; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);'>$value</td>";
                }
            }

            // Check if the user has 'admin' usertype
            if (isset($_SESSION['usertype']) && $_SESSION['usertype'] === 'admin') {
                $userId = $item['user_id']; // Assuming 'user_id' is the unique identifier
                echo "
                    <form action='' method='GET'>
                        <input type='hidden' name='userId' value='$userId'>
                        <td style='width: 300px; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); font-weight: bold; font-size: 25px; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);'><button style='background-color: black;' class='btn btn-outline-light me-2' name='submit' type='submit'>Delete</button></td>
                    </form>
                ";
            }
            if (isset($_SESSION['usertype']) && $_SESSION['usertype'] === 'user' && $value != "Flex.jpg") {
                $userId = $item['user_id']; // Assuming 'user_id' is the unique identifier
                echo "
                    <form action='' method='GET'>
                        <input type='hidden' name='userId' value=''>
                        <td style='width: 300px; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); font-weight: bold; font-size: 25px; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);'><button style='background-color: black;' class='btn btn-outline-light me-2' type='submit'>Join</button></td>
                    </form>
                ";
            }elseif (isset($_SESSION['usertype']) && $_SESSION['usertype'] === 'user' && $value == "Flex.jpg") {
                $userId = $item['user_id']; // Assuming 'user_id' is the unique identifier
                echo "
                    <form action='' method='GET'>
                        <input type='hidden' name='userId' value=''>
                        <td style='width: 300px; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); font-weight: bold; font-size: 25px; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);'><button style='background-color: black;' class='btn btn-outline-light me-2' type='submit'>NOT AVAILABLE!</button></td>
                    </form>
                ";
            }
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
<script>
  $(document).ready(function(){
    $('.content').click(function(){
      // Toggle the classes for the clicked heart
      $(this).toggleClass("heart-active");
      $(this).find('.text').toggleClass("heart-active");
      $(this).find('.numb').toggleClass("heart-active");
      $(this).find('.heart').toggleClass("heart-active");
    });
  });
</script>
</body>

</html>