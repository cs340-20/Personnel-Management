<!DOCTYPE html>
<html>
<head>
    <!--Refrence to a stylesheet from the ../PM-css/styles.css file -->
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
        <li><a href="personnel.php">personnel</a></li>
        <li><a class="active" href="events.php">Events</a class="active"></li>
        <li><a href="messaging.php">Messaging</a></li>
    </ul>

    <div class="page_body">
        <!-- Body structure goes here -->
        <h2>Events</h2>

        <div class="event_input">
        <form method="post">
            <input type="text" name="event_name" required>
            <input type="date" name="event_date" value="<?php echo date('Y-m-d'); ?>" required>
            <input type="submit" name="add_event" value="Add Event">
        </form>
        </div>

        <?php
        if (array_key_exists("add_event", $_POST)) {
            
            $sql_add_event = $link->prepare("INSERT INTO events (events.name, events.date, events.attendance) VALUES (?,?, '0')");
            $sql_add_event->bind_param("ss", $event_name, $event_date);

            $event_date = date('Y-m-d', strtotime($_POST['event_date']));
            $event_name = $_POST['event_name'];

            $sql_add_event->execute();
            $sql_add_event->close();


        }
        ?>

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