<?php

// Start a session
session_start();

// Set the login credentials
$username = "admin";
$password = "pass";

// Check if the login form has been submitted
if (isset($_POST['login'])) {
    // Get the username and password from the form
    $formUsername = $_POST['username'];
    $formPassword = $_POST['password'];

    // Check if the username and password match
    if ($formUsername == $username && $formPassword == $password) {
        // Save the login status in the session
        $_SESSION['logged_in'] = true;
    } else {
        // Display an error message
        echo "Invalid username or password.";
    }
}

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    // Display the login form
    ?>
    <form action="" method="post">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username"><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" value="Login" name="login">
    </form>
    <?php
    // Stop the rest of the script from running
    exit;
}
// Set the directory where the files are stored
$dir = "files/";

// Check if the form to upload a file has been submitted
if (isset($_POST['submit'])) {
    // Get the file name and path
    $file = $dir . basename($_FILES['file']['name']);

    // Check if the file has been uploaded successfully
    if (move_uploaded_file($_FILES['file']['tmp_name'], $file)) {
        // Display a success message
        echo "The file ". basename( $_FILES['file']['name']). " has been uploaded.";
    } else {
        // Display an error message
        echo "There was an error uploading the file, please try again.";
    }
}

// Check if the delete button has been clicked
if (isset($_GET['delete'])) {
    // Get the file name
    $file = $dir . $_GET['delete'];

    // Check if the file exists and if it is a file
    if (file_exists($file) && is_file($file)) {
        // Delete the file
        unlink($file);

        // Display a success message
        echo "The file has been deleted.";
    } else {
        // Display an error message
        echo "The file does not exist or is not a file.";
    }
}

// Get a list of all the files in the directory
$files = scandir($dir);
?>

<!-- Display a form to upload a file -->
<form action="" method="post" enctype="multipart/form-data">
    Select a file to upload:
    <input type="file" name="file">
    <input type="submit" value="Upload" name="submit">
</form>

<!-- Display a list of the files in the directory -->
<h2>Files</h2>
<ul>
    <?php foreach($files as $file): ?>
        <?php if ($file != '.' && $file != '..'): ?>
            <li>
                <a href="files/<?php echo $file; ?>"><?php echo $file; ?></a>
                <!-- Display a link to delete the file -->
                <a href="?delete=<?php echo $file; ?>">Delete</a>
            </li>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>
