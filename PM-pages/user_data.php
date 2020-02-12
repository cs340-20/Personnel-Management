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
        <div class="user_data_container">
            <div class="top_line">
                <div class="top_line_L">
                    <h1><?php echo get_user_name($link, $UID); ?></h1>
                </div>
                <div class="top_line_R">
                    <h2>User ID = <?php echo $UID; ?></h2>
                </div>
            </div>

            <div>
                <div class="user_info_box">
                    <div class="user_column">
                        <?php $row = get_user_info($link, $UID); ?>
                            
                        <table id="user_info_table">
                            <tr>
                                <th>Organization</th>
                                <th>Paygrade</th>
                                <th>Email</th>
                                <th>Permissions</th>
                            </tr>
                            <tr>
                                <?php
                                    echo "<td class='user_cell'>".$row['group_name']."</td>";
                                    echo "<td class='user_cell'>".$row['Pay_Grade']."</td>";
                                    echo "<td class='user_cell'>".$row['Email']."</td>";
                                    echo "<td class='user_cell'>".$row['permissions']."</td>";
                                ?>
                            </tr>
                        </table>

                    </div>                 
                </div>

            </div>

            <div class="remove_button" onclick="openTab('b3');">
                Remove Person
            </div>
        </div>

    </div>

    

    


</body>
</html>