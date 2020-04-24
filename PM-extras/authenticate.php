<?php
    require "db_utils.php";

    $con = create_connection();
    if ( mysqli_connect_errno() ) {
        // If there is an error with the connection, stop the script and display the error.
        exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }

    if ( !isset($_POST['username']) ) {
        // Could not get the data that should have been sent.
        exit('Please fill the username field!');
    }

    // Prepare our SQL, preparing the SQL statement will prevent SQL injection.
    if ($stmt = $con->prepare('SELECT user_ID, permissions FROM people WHERE email = ?')) {
        // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
        $stmt->bind_param('s', $_POST['username']);
        $stmt->execute();
        // Store the result so we can check if the account exists in the database.
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            session_start();
            $stmt->bind_result($uid, $perm);
            $stmt->fetch();
            // Account exists, now we verify the password.
            // Note: remember to use password_hash in your registration file to store the hashed passwords.
            
            // Verification success! User has loggedin!
            // Create sessions so we know the user is logged in, they basically act like cookies but remember the data on the server.
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['permissions'] = $perm;
            $_SESSION['id'] = $uid;
            echo 'Welcome user #' . $_SESSION['id'] . '! Redirecting...';
            header("location: ../index.php");
        } else {
            header("location: ../PM-pages/login.php?err=1");
        }

        $stmt->close();
    }

?>