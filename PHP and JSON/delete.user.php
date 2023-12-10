<?php
	require("update.class.php");
    $update = new HandleJsonFile();
    $jsonData = $update->getUsersData();
?>
<?php
    if(isset($_GET['submit'])){
		$update->deleteUser($_GET['userId']);
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
                <th>User ID</th>
                <th>Name</th>
                <th>Username</th>
                <th>Password</th>
                <th>Email</th>
                <th>User Type</th>
                <th>Action</th> <!-- Add Action column -->
            </tr>
        </thead>
        <tbody>
        <?php
            foreach ($jsonData as $item) {
                echo "<tr>";
                echo "<td>{$item['user_id']}</td>";
                echo "<td>{$item['name']}</td>";
                echo "<td>{$item['username']}</td>";
                echo "<td>{$item['password']}</td>";
                echo "<td>{$item['email']}</td>";
                echo "<td>{$item['usertype']}</td>";
                echo "<td>
                        <form action='' method='GET'>
                            <input type='hidden' name='userId' value='{$item['user_id']}'>
                            <button type='submit' name='submit'>Delete</button>
                        </form>
                      </td>";
                echo "</tr>";
            }
        ?>
        </tbody>
    </table>
</body>
</html>
