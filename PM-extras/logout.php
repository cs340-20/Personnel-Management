<?php
    session_start();
    session_destroy();
    session_start();

    $_SESSION['loggedin'] = false;
    // Redirect to the login page:
    header('Location: ../index.php');
?>