<?php

// Include the database configuration file
include 'config.php';

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Insert the new task into the database
    $description = $_POST['description'];
    $sql = "INSERT INTO tasks (description, user_id)
            VALUES ('$description', {$_SESSION['user_id']})";
    mysqli_query($conn, $sql);
}

// Fetch the user's tasks
$sql = "SELECT * FROM tasks WHERE user_id = {$_SESSION['user_id']}";
$result = mysqli_query($conn, $sql);

?>

<html>
<head>
    <title>My Todo List</title>
</head>
<body>
    <h1>Welcome to your todo list, <?php echo $_SESSION['username']; ?>!</h1>

    <h2>Add a new task</h2>
    <form method="post">
        <label for="description">Description:</label>
        <input type="text" name="description"><br>
        <input type="submit" value="Add">
    </form>

    <h2>Your tasks</h2>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <p><?php echo $row['description']; ?></p>
        <hr>
    <?php endwhile; ?>
</body>
</html>
