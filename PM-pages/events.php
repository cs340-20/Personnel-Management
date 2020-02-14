<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../PM-css/styles.css">
    <link rel="stylesheet" type="text/css" href="../PM-css/event-style.css">
    <title>Events</title> 

</head>
<body>

    <?php require '../PM-extras/db_utils.php';
    $link = create_connection();
    ?>

    <!-- Nav-bar links -->
    <ul>
        <li><a href="../index.php">Home</a></li>
        <li><a href="personnel.php">Personnel</a></li>
        <li><a class="active" href="events.php">Events</a class="active"></li>
        <li><a href="messaging.php">Messaging</a></li>
    </ul>

    <div class="page_body">
        <!-- Body structure goes here -->
        <h2>Events</h2>
        <div class="event_table_wrappper">

        <?php
            $sql = "SELECT * FROM events";


            //code to print table
            if ($res = mysqli_query($link, $sql)) {
                //print column headers with select/dis-select all box
                if (mysqli_num_rows($res) > 0) {
                    echo '<table class="event_table">';
                    echo "<tr>";
                    echo "<th class='event_header'>ID</th>";
                    echo "<th class='event_header'>Event Name</th>";
                    echo "<th class='event_header'>Date</th>";
                    echo "<th class='event_header'>Attendance</th>";
                    echo "</tr>";
                    //for each row, print corresponding data to webpage
                    while ($row = mysqli_fetch_array($res)) {
                        echo "<tr class='event_row'>";
                        echo "<td class='event_data'>" . $row['event_ID'] . "</td>";
                        echo "<td class='event_data'>" . $row['name'] . "</td>";
                        echo "<td class='event_data'>" . $row['date'] . "</td>";
                        echo "<td class='event_data'>" . $row['attendance'] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No results found";
                }
            }



?>
        </div>
    </div>






</body>
</html>
