function logout($home = false) {
    if (confirm("Are you sure you want to log out?")) {
        $loc = ($home) ? "PM-extras/logout.php" : "../PM-extras/logout.php";
        window.location.href = $loc;
    }
}