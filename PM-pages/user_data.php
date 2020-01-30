<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../PM-css/styles.css">
    <title>User Data</title> 

</head>
<body>

    <?php require('../PM-extras/db_utils.php'); 
        $link = create_connection();    
        $UID = $_GET['user_ID'];
    ?>

    <!-- Nav-bar links -->
    <ul>
        <li><a href="../index.php">Home</a></li>
        <li><a href="personnel.php">Personnel</a></li>
        <li><a href="events.php">Events</a class="active"></li>
        <li><a href="messaging.php">Messaging</a></li>
    </ul>

    <div class="page_body">
        <!-- Body structure goes here -->
        <h2><?php echo get_user_name($link, $UID); ?></h2>
        <p>The meat and potatoes goes here!</p>
    </div>

    


</body>
</html>