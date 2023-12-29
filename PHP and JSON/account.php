<?php
	require("logout.class.php");
	require("update.class.php");
	require("event.handler.class.php");
	require("review.class.php");
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
    if (isset($_POST['delete'])) {
        if (isset($_POST['userId'])) {
            $userIdToDelete = $_POST['userId'];
            
            // Assuming $yourObject is an instance of the class where deleteMessage is defined
            $update->deleteMessage($userIdToDelete);
            
            // You might want to redirect or reload the page after deleting
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            // Handle error - userId not provided
        }
    }
    if(isset($_POST['join'])){
        // user_vote currently not handled
        $eventHandler = new EventHandler($_POST['postID'],$_POST['subject'],$_POST['userID'], $_POST['user_vote']);
        header("location: account.php");
        exit();
    }
    if(isset($_POST['review'])){
        $review = new PostReview($_POST['reviewPostID'],$_POST['reviewPost']);
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
    <div style="color: black; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); font-weight: bold; font-size: 14px;" >
    <?php
        if (isset($_SESSION['usertype']) && $_SESSION['usertype'] === 'user') 
            echo"<h2>WELCOME USER!</h2>";
        else if (isset($_SESSION['usertype']) && $_SESSION['usertype'] === 'organizer') 
            echo"<h2>WELCOME ORGANIZER!</h2>";
        else
            echo"<h2>WELCOME ADMIN!</h2>";
    ?>
    </div>
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
            <?php
            if (isset($_SESSION['usertype']) && $_SESSION['usertype'] !== 'admin') {
                echo "<li><a href='post.php' class='nav-link' style='color: whitesmoke; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); font-weight: bold; font-size: 1.5em;'>Post An Event!</a></li>";
            }
            ?>
            <?php
            if (isset($_SESSION['usertype']) && $_SESSION['usertype'] === 'admin') {
                echo "<li><a href='delete.user.php' class='nav-link' style='color: whitesmoke; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); font-weight: bold; font-size: 1.5em;'>Delete A User!</a></li>";
            }
            if (isset($_SESSION['usertype']) && $_SESSION['usertype'] === 'organizer'){
                echo "<li><a href='registrants.php' class='nav-link' style='color: whitesmoke; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); font-weight: bold; font-size: 1.5em;'>Registrants</a></li>";
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
            if (isset($_SESSION['usertype']) && $_SESSION['usertype'] === 'admin') {
                echo '<th>Action</th>';
            }
            if (isset($_SESSION['usertype']) && $_SESSION['usertype'] === 'user' ||
                isset($_SESSION['usertype']) && $_SESSION['usertype'] === 'organizer') {
                echo '<th>Action</th>';
            }
            echo '<th>Reviews</th>';
            ?>
        </tr>
        
    </thead>
    <tbody id="tableBody">
        <?php
        foreach ($jsonData as $item) {
            echo "<tr style='background-color: rgb(212, 212, 212, .8)'>";
            foreach ($item as $key => $value) {
                if ($key !== "user_id" && $key !== "image" && $key !== "post_id" && $key !== "username") {
                    echo "<td style='width: 300px; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);'>$value
                    </td>";
                } elseif ($key === "image") {
                    echo "<td style='width: 300px; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);'><img style='height: 300px; width: auto; border-radius: 15px; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2)' src='./Images/$value' alt=''>
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
                    <form action='" . htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, 'UTF-8') . "' method='POST'>
                        <td style='width: 300px; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); font-weight: bold; font-size: 25px; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);'>
                            <input type='hidden' name='userId' value='$userId'>
                            <button style='background-color: black;' class='btn btn-outline-light me-2' name='delete' type='submit'>Delete</button>
                            </td>
                            </form>";
            } else if (isset($_SESSION['usertype']) && $_SESSION['usertype'] === 'user' ||
                isset($_SESSION['usertype']) && $_SESSION['usertype'] === 'organizer') {
                $postID = $item['post_id'];
                $subject = $item['subject'];
                $userID = $_SESSION['user_id'];
                echo "
                <form action='" . htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, 'UTF-8') . "' method='POST'>
                    <td style='width: 300px; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); font-weight: bold; font-size: 25px; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);'>
                        <input type='hidden' name='postID' value='$postID'>
                        <input type='hidden' name='subject' value='$subject'>
                        <input type='hidden' name='userID' value='$userID'>
                    </td>
                </form>
                <!-- Join Button -->
                <button style='background-color: black;' class='btn btn-outline-light me-2' name='join' type='submit'>Join</button>";
            }
            echo "
            <form action='" . htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, 'UTF-8') . "' method='POST'>
                <td style='width: 300px; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); font-weight: bold; font-size: 25px; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5); text-align: center;'>
                    <input type='hidden' name='reviewPostID' value='{$item['post_id']}'>
                    <textarea class='form-control' name='reviewPost' placeholder='Enter your review here........' style='width: 80%; margin: 0 auto; text-align: center;' rows='10'></textarea>
                    <button style='background-color: black;' class='btn btn-outline-light me-2' name='review' type='submit'>Submit</button>
                </td>
            </form>";            
            echo "</tr>";
        }
        ?>
    </tbody>
</table>


</body>

</html>