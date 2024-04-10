<?php

function execute_query($sql)
{
    global $conn;
    $result = $conn->query($sql);
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}


function insert_user()
{
    // Check if form is submitted and call the insertUser function
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    }

    $username = !empty($_POST["fname"]) ? $_POST["fname"] : null;

    if ($username == null) {
        $_SESSION['error'] = "Name cannot be empty!";

        // Redirect back to location from which the request was made
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        return;
    }

    $email = !empty($_POST["femail"]) ? $_POST["femail"] : null;

    if ($email == null) {
        $_SESSION['error'] = "Email cannot be empty!";
        // Redirect back to location from which the request was made
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        return;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email address";
        // Redirect back to location from which the request was made
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        return;
    }

    $password = !empty($_POST["fpass"]) ? $_POST["fpass"] : null;

    if ($password == null) {
        $_SESSION['error'] = "Password cannot be empty!";
        // Redirect back to location from which the request was made
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        return;
    }

    $is_admin = 0; // New users are not administrators by default

    // Prepare and execute SQL statement to insert data into users table
    $sql = "INSERT INTO users (username, password, email, is_admin) VALUES ('$username', '$password', '$email', $is_admin)";

    global $conn;

    try {
        $conn->query($sql);
    } catch (Exception $e) {
        $_SESSION['error'] = "Error: " . $sql . "<br>" . $conn->error;
        
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        return;
    }

    // Set success message
    $_SESSION['success'] = "User successfully registered.";

    header("Location: " . $_SERVER["HTTP_REFERER"]);
    return;
}
