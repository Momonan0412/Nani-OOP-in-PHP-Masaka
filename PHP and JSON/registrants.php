<?php
	require("update.class.php");
    $update = new HandleJsonFile();
    $jsonData = $update->getEventsData();
?>
<?php
	session_start();
    if(!isset($_SESSION['user'])){
        header("location: login.php");
        exit();
    }
    if(isset($_GET['submit'])){
        // TO BE ADD THAT CAN UPDATE PENDING REGISTRANTS
		header("location: delete.user.php");
		exit();
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Users</title>
    <style>
    body {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        background-color: #333;
        margin: 0;
    }

    table {
        width: 70%;
        border-collapse: collapse;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        border-radius: 15px;
        overflow: hidden;
        background-color: #4b5961; /* Change to grayish tone */
        color: #ecf0f1;
    }

    th, td {
        padding: 15px;
        text-align: center;
        border-bottom: 1px solid #4b5961; /* Change to grayish tone */
    }

    th {
        background-color: #718daa; /* Change to grayish tone */
        color: #ecf0f1;
    }

    td {
        background-color: #4b5961; /* Change to grayish tone */
    }

    td form {
        display: flex;
        justify-content: center;
    }

    button {
        background-color: #b53737; /* Change to deep red */
        color: #ecf0f1;
        border: none;
        padding: 8px 15px;
        cursor: pointer;
        border-radius: 5px;
    }

    button:hover {
        background-color: #902828; /* Change to deep red */
    }
    #navigation {
        position: fixed;
        top: 10px;
        left: 10px;
        padding: 10px;
        border: 1px solid #e74c3c;
        border-radius: 10px;
        background-color: pink; /* Pink background */
        box-shadow: 0 0 10px rgba(255, 255, 255, 0.8); /* White box shadow */
    }

    </style>
    <div id="navigation">
        <a href="account.php" style="text-decoration: none; color: #ecf0f1;">HOME</a>
    </div>
</head>
<body>
<table>
    <thead>
        <tr>
            <th>Post ID</th>
            <th>Event Name</th>
            <th>Registrants</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($jsonData as $e) {
            echo "<tr>";
            echo "<td>{$e['post_id']}</td>";
            echo "<td>{$e['subject']}</td>";
            // Study!
            // Registrants
            echo "<td>";
            echo $e['registrants']['user_id'];
            //var_dump($e);
            // foreach ($e['registrants'] as $registrant) {
            //     echo $registrant['user_id'];
            // }
            echo "</td>";
            // Study!
            // Votes
            // echo "<td>";
            // foreach ($e['votes'] as $vote) {
            //     echo "{$vote['user_id']} - {$vote['vote']}<br>";
            // }
            // echo "</td>";

            // Action
            // echo $e['registrants']['status'];
            echo "<td>
                    <form action='" . htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, 'UTF-8') . "' method='POST'>
                        <input type='hidden' name='status' value='{$e['registrants']['status']}'>
                        <button type='submit' name='submit'>Approve</button>
                    </form>
                </td>";

            echo "</tr>";
        }
        ?>
    </tbody>
</table>


</body>
</html>
