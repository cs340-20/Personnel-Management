<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="../PM-css/styles.css">
    <link rel="stylesheet" type="text/css" href="../PM-css/home-style.css">
    <link rel="stylesheet" type="text/css" href="../PM-css/event-style.css">

    <!-- javascript functions for page -->
    <script type="text/javascript" src="../PM-script/event_script.js"></script>

    <!-- javascript functions for page -->


    <title>Personnel Management</title>

</head>

<body>
    <?php require '../PM-extras/db_utils.php';
    $link = create_connection();
    update_att_events($link);
    ?>

    <!-- HTML for nav links and logo -->
    <div class="page_container">
        <div class="nav_bar">
            <div class="nav_stack nav_logo">
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

        <div class="home_body events_bg">
            <!-- Page content goes here -->

            <div class="event_col_l">

                <div class="add_button"><button onclick="openAddEvent()" class="nav_button">Add Event</button></div>

                <div class="event_input add_event_closed" id="add_event_container">
                    <h2 class="add_event_header">Add Event</h2>
                    <form method="post">
                        <table id="add_event_table">
                            <tr>
                                <th>Name</th>
                                <th>Date</th>
                            </tr>
                            <tr>
                                <td><input class="add_event_box" type="text" name="event_name" required></td>
                                <td><input class="add_event_box" type="date" name="event_date" value="<?php echo date('Y-m-d'); ?>" required></td>
                            </tr>
                        </table>
                        <input class="nav_button" type="submit" name="add_event" value="Add Event">
                    </form>
                </div>

                <?php
                //add event to table
                if (array_key_exists("add_event", $_POST)) {
                    $event_date = date('Y-m-d', strtotime($_POST['event_date']));
                    $event_name = $_POST['event_name'];

                    add_event($link, $event_name, $event_date);
                }
                ?>

                <div class="table_wrapper">

                    <?php
                    $sql = "SELECT * FROM events";


                    //code to print table
                    if ($res = mysqli_query($link, $sql)) {
                        //print column headers with select/dis-select all box
                        if (mysqli_num_rows($res) > 0) {
                            echo '<table class="person_table">';
                            echo '<caption class="event_table_caption">Future Events</caption>';
                            echo "<tr>";
                            echo "<th class='person_header'>ID</th>";
                            echo "<th class='person_header'>Event Name</th>";
                            echo "<th class='person_header'>Date</th>";
                            echo "<th class='person_header'>Attendance</th>";
                            echo "<th class='person_header'></th>";
                            echo "</tr>";
                            //for each row, print corresponding data to webpage
                            while ($row = mysqli_fetch_array($res)) {
                                if ($row['date'] < date("Y-m-d")) {
                                    echo "<tr class='person_row'>";
                                    echo "<td class='person_data'>" . $row['event_ID'] . "</td>";
                                    echo "<td class='person_data'>" . $row['name'] . "</td>";
                                    echo "<td class='person_data'>" . $row['date'] . "</td>";
                                    echo "<td class='person_data'>" . $row['attendance'] . "</td>";
                                    echo "<td class='person_data' style='padding: 0;'><button class='nav_button' id='view-" . $row['event_ID'] . "' onclick='trigger(" . $row['event_ID'] . ")' style='width: 80px;'>View</button></td>";
                                    echo "</tr>";
                                }
                            }
                            echo "</table>";



                            $res = mysqli_query($link, $sql);

                            echo '<table class="person_table">';
                            echo '<caption class="event_table_caption">Past Events</caption>';
                            echo "<tr>";
                            echo "<th class='person_header'>ID</th>";
                            echo "<th class='person_header'>Event Name</th>";
                            echo "<th class='person_header'>Date</th>";
                            echo "<th class='person_header'>Attendance</th>";
                            echo "<th class='person_header'></th>";
                            echo "</tr>";
                            //for each row, print corresponding data to webpage
                            while ($row = mysqli_fetch_array($res)) {
                                if ($row['date'] > date("Y-m-d")) {
                                    echo "<tr class='person_row'>";
                                    echo "<td class='person_data'>" . $row['event_ID'] . "</td>";
                                    echo "<td class='person_data'>" . $row['name'] . "</td>";
                                    echo "<td class='person_data'>" . $row['date'] . "</td>";
                                    echo "<td class='person_data'>" . $row['attendance'] . "</td>";
                                    echo "<td class='person_data' style='padding: 0;'><button class='nav_button' id='view-" . $row['event_ID'] . "' onclick='trigger(" . $row['event_ID'] . ")' style='width: 80px;'>View</button></td>";
                                    echo "</tr>";
                                }
                            }
                            echo "</table>";
                        } else {
                            echo "No results found";
                        }
                    }

                    ?>

                </div>

            </div>

            <div class="event_col_r">
                <div class="event_col_buf">
                    <div id="att-def" class="event_data_wrapper event_open event_fade" style="transform: rotate(0);">
                        <h2>Select event to view</h2>
                    </div>

                    <?php
                    $events = get_event_list($link);
                    foreach ($events as $ev) {


                        echo "<div id='att-" . $ev . "' class='event_data_wrapper' style='transition: transform 1s;'>";
                        echo "<div class='att_table_wrapper'>";
                        $res = get_event_att($link, $ev);

                        $name = (get_event_name($link, $ev));

                        echo "<form method='POST'>";
                        echo "<h2>".$name['name']."</h2>";

                        echo '<table class="person_table">';
                        echo "<tr>";
                        echo "<th class='person_header'>Name</th>";
                        echo "<th class='person_header'>Status</th>";
                        echo "</tr>";
                        // //for each row, print corresponding data to webpage
                        $UID_list = get_UID_list($link);
                        foreach ($UID_list as $UID) {
                            echo "<tr class='person_row'>";
                            echo "<td class='person_data'>" . get_user_name($link, $UID) . "</td>";
                            echo "<td class='person_data'>";
                            echo "<select name='att-".$ev."-".$UID."'>";
                            echo "<option".(($res[build_col_name($link, $UID)] == 'U') ? " selected" : "") ." value='U'>Unassigned</option>";
                            echo "<option".(($res[build_col_name($link, $UID)] == 'P') ? " selected" : "") ." value='P'>Present</option>";
                            echo "<option".(($res[build_col_name($link, $UID)] == 'L') ? " selected" : "") ." value='L'>Late</option>";
                            echo "<option".(($res[build_col_name($link, $UID)] == 'A') ? " selected" : "") ." value='A'>Absent</option>";
                            echo "</select>";
                            echo "</td>";
                            echo "</tr>";
                        }

                        echo "</table>";

                        echo "<input type='submit' value='Update' class='nav_button' name='update-".$ev."'/></form>";


                        if (array_key_exists('update-'.$ev, $_POST)) {
                            $att_set = [];
                            foreach ($UID_list as $UID) {
                                $att_set[strval($UID)] = $_POST['att-'.$ev.'-'.$UID];
                            }
                            set_event_att($link, $ev, $att_set);
                            echo "<meta http-equiv='refresh' content='0'>";
                        }


                        echo "</div>";
                        echo "</div>";

                    }
                    ?>
                </div>
            </div>

        </div>



        <!-- <div class="footer">
            <nav>
                <a class='footer_link' href="../index.php">Home</a> |
                <a class='footer_link' href="../PM-pages/personnel.php">Personnel</a> |
                <a class='footer_link' href="../PM-pages/events.php">Events</a> |
                <a class='footer_link' href="../PM-pages/messaging.php">Messaging</a>
            </nav>
            <p class="footer_note">Devs: Alex Whitaker, Cainan Howard, Sammy Awad, Timothy Krenz</p>
        </div> -->

    </div>

    <!-- Javascript to open and close modal boxes    -->
    <script>
        function trigger(view_ID) {
            var att_box = document.getElementById("att-" + view_ID);

            var box_list = document.getElementsByClassName("event_data_wrapper");
            for (var i = 0; i < box_list.length; i++) {
                box_list[i].classList.remove('event_open');
            }

            att_box.classList.add('event_open');

        }
    </script>
</body>

</html>