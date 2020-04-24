<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="../PM-css/styles.css">
    <link rel="stylesheet" type="text/css" href="../PM-css/home-style.css">
    <link rel="stylesheet" type="text/css" href="../PM-css/login-style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">

    <!-- javascript functions for page -->
    <script type="text/javascript" src="../PM-script/personnel_script.js"></script>


    <title>Personnel Management</title>

</head>

<body>
    
    <!-- HTML for nav links and logo -->
    <div class="page_container">
        <div class="nav_bar">
            <div class="nav_logo">
                <h2>AdminMax</h2>
            </div>
            <div class="nav_stack">
                <div class="nav_links">
                    <div class="n_link">
                        <button class="nav_button nav_button_others" onclick="window.location.href = '../index.php';">Home</button>
                    </div>
                    <div class="n_link">
                        <button class="nav_button nav_button_others" onclick="window.location.href = '../PM-pages/personnel.php';">Personnel</button>
                    </div>
                    <div class="n_link">
                        <button class="nav_button nav_button_others" onclick="window.location.href = '../PM-pages/events.php';">Events</button>
                    </div>
                    <div class="n_link">
                        <button class="nav_button nav_button_others" onclick="window.location.href = '../PM-pages/messaging.php';">Messaging</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="home_body">
            <!-- Page content goes here -->

            <div class="login">
                <h1>Login</h1>
                
                <?php  
                    if (isset($_GET['err'])) {
                        if ($_GET['err'] == 1) {
                            echo '<br><p style="align: center; color: red;">Invalid Username</p>';
                        }
                    }
                ?>
                
                <form action="../PM-extras/authenticate.php" method="post">
                    <label for="username">
                        <i class="fas fa-user"></i>
                    </label>
                    <input type="text" name="username" placeholder="Username" id="username" required>
                    <input type="submit" value="Login">
                </form>
            </div>

        </div>


<!-- 
        <div class="footer">
            <nav>
                <a class='footer_link' href="../index.php">Home</a> |
                <a class='footer_link' href="../PM-pages/personnel.php">Personnel</a> |
                <a class='footer_link' href="../PM-pages/events.php">Events</a> |
                <a class='footer_link' href="../PM-pages/messaging.php">Messaging</a>
            </nav>
            <p class="footer_note">Devs: Alex Whitaker, Cainan Howard, Sammy Awad, Timothy Krenz</p>
        </div> -->

</body>

</html>