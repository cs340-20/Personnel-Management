<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../PM-css/styles.css">
    <title>User Data</title> 

    <style>
        .top_line {
            width: 100%;
            height: 50px;
        }

        .top_line_L {
            width: 50%;
            height: 100%;
            float: left;
        }
        
        .top_line_R {
            margin-top: 25px;
            width: 50%;
            height: 100%;
            float: left;
            bottom: 0;
        }

        .column {
            float: right;
            width: 150px;
            height: 30px;
            padding: 8px 5px 0px 5px;
            border-radius: 10px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            color: #FF7676;
            background-color: #EEE;
            border-radius: 5px;
            box-shadow: 5px 5px 5px #AAAAAA, -5px -5px 5px #FFFFFF;
        }

    </style>

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
        <div class="top_line">
            <div class="top_line_L">
                <h1><?php echo get_user_name($link, $UID); ?></h1>
            </div>
            <div class="top_line_R">
                <div class="column" onclick="openTab('b3');">
                    Remove Person
                </div>
            </div>
        </div>
    </div>

    


</body>
</html>