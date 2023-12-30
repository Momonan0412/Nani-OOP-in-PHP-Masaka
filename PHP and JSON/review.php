<?php
    session_start();
    $storage = "./Data/reviews.json";
    $reviewsStorage = array();
    if (file_exists($storage)) {
        $reviewsStorage = json_decode(file_get_contents($storage), true);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($_SESSION['subject']) ? $_SESSION['subject'] : 'Unknown'; ?></title>
    
    <!-- Include your CSS and JS links here -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel='stylesheet' href='styles.css'>
    <link rel="stylesheet" href="HeartButton.css">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
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
		</ul>
	</div>
	</main>  
    </div>
</header>
<body>
    <?php
        if(isset($_SESSION['postID']) && isset($reviewsStorage[$_SESSION['postID']])) {
            // If the session postID exists and there are reviews for that postID
            echo "<table>";
            echo "<th>" . (isset($_SESSION['subject']) ? $_SESSION['subject'] : 'Unknown') . " Reviews~" . "</th>";
            foreach ($reviewsStorage[$_SESSION['postID']] as $review) {
                // Display each review for the specific postID in a table row
                echo "<tr style='background-color: rgb(212, 212, 212, .8)'>
                <td>{$review['review']}</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<table>";
            echo "<th>" . (isset($_SESSION['subject']) ? $_SESSION['subject'] : 'Unknown') . " Reviews~" . "</th>";
                echo "<tr style='background-color: rgb(212, 212, 212, .8)'>
                <td>No reviews found!";
            echo "</table>";
            // Handle the case when the session postID doesn't match any reviews
        }
    ?>
</body>

</html>
