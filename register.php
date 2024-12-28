<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'user_db');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Determine whether the request is for sign-up or sign-in
if (isset($_POST['signUp'])) {
    // Sign-Up Logic
    $firstName = $conn->real_escape_string($_POST['fName']);
    $lastName = $conn->real_escape_string($_POST['lName']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['passsword'], PASSWORD_DEFAULT); // Secure password

    // Check if email already exists
    $checkEmail = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($checkEmail);

    if ($result->num_rows > 0) {
        echo "Email already registered. Please <a href='login.html'>login</a>.";
    } else {
        // Insert new user
        $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES ('$firstName', '$lastName', '$email', '$password')";

        if ($conn->query($sql) === TRUE) {
            echo "Registration successful. Please <a href='login.html'>login</a>.";
        } else {
            echo "Error: " . $conn->error;
        }
    }
} elseif (isset($_POST['signIn'])) {
    // Sign-In Logic
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['passsword'];

    // Retrieve user data
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            echo "Login successful. Welcome, " . $row['first_name'] . " " . $row['last_name'] . "!";
        } else {
            echo "Invalid password. Please try again.";
        }
    } else {
        echo "No account found with this email. Please <a href='signup.html'>sign up</a>.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
