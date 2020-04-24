<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="../PM-css/styles.css">
    <link rel="stylesheet" type="text/css" href="../PM-css/home-style.css">
    <link rel="stylesheet" type="text/css" href="../PM-css/personnel-style.css">

    <!-- javascript functions for page -->
    <script type="text/javascript" src="../PM-script/personnel_script.js"></script>
    <script src="../PM-script/logout.js"></script>


    <title>Personnel Management</title>

</head>

<body>
    <!-- ensures that db_utils is loaded -->
    <?php require '../PM-extras/db_utils.php';
    if (!check_session()) header("location: login.php");
    $link = create_connection();

    //pulls columns from table for sort selection
    $result1 = get_columns($link);
    $result2 = get_columns($link);
    $first_load = true;

    //allows checkboxes to maintain value
    if (isset($_POST['checklist'])) {
        foreach ($_POST['checklist'] as $selectedbox)
            $selected[$selectedbox] = "checked";
    }

    ?>

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
            <?php if (check_session()) { ?>
                <button class="nav_button nav_button_others log_button" onclick="logout()">Log Out</button>
            <?php } else { ?>
                <button class="nav_button nav_button_others log_button" onclick="window.location.href = '../PM-pages/login.php';">Log In</button>
            <?php } ?>
        </div>

        <div class="home_body personnel_bg">
            <!-- Page content goes here -->
            <div id="selections">
                <form action="" method="post">
                    <!-- 3 divs that contain three columns of sort, filter, and view options -->
                    <div style="width: 33%;float: left;height: 100%;padding-right:20px;padding-top:5px;text-align:right;">

                        <!-- create dropdown boxes with retrieved column names from database -->
                        Sort by: <select name="sort_by" style="margin-bottom: 2px;">
                            <?php
                            //make sort box based on column headers
                            while ($row = $result1->fetch_assoc()) {
                                echo '<option value="' . $row['COLUMN_NAME'] . '" ' . ((isset($_POST["sort_by"]) && $_POST["sort_by"] == $row['COLUMN_NAME']) ? "selected='selected'" : "") . '>' . $row['COLUMN_NAME'] . '</option>';
                            }
                            ?>
                        </select> <br>
                        Filter by: <select name="filter_by" style="margin-bottom: 2px;">
                            <?php
                            //make filter box based on column headers
                            echo '<option value="none">None</option>';
                            while ($row = $result2->fetch_assoc()) {
                                echo '<option value="' . $row['COLUMN_NAME'] . '" ' . ((isset($_POST["filter_by"]) && $_POST["filter_by"] == $row['COLUMN_NAME']) ? "selected='selected'" : "") . '>' . $row['COLUMN_NAME'] . '</option>';
                            }
                            ?>
                        </select><br>
                        <!-- Text box for filter key -->
                        Key: <input type="text" name="filter_key" maxlength="14" style="width: 114px; margin-bottom: 2px;" value="<?php echo isset($_POST['filter_key']) ? $_POST['filter_key'] : '' ?>">
                        <br>

                        <!-- Go button to print table -->
                        <input type="submit" name="test" id="test" value="Go" /><br />

                    </div>

                    <!-- check boxes for data shown in table, PHP for holding value -->
                    <div style="width: 33%;float: left;height: 100%;padding-top:10px;">
                        <label><input type="checkbox" name="checklist[]" value="user_ID" <?php echo (isset($selected['user_ID'])      ? $selected['user_ID'] : ""); ?>>Show ID</label><br>

                        <label><input type="checkbox" name="checklist[]" value="First_Name" <?php echo (isset($selected['First_Name'])   ? $selected['First_Name'] : ""); ?>>Show First Name</label><br>

                        <label><input type="checkbox" name="checklist[]" value="Last_Name" <?php echo (isset($selected['Last_Name'])    ? $selected['Last_Name'] : ""); ?>>Show Last Name</label><br>

                        <label><input type="checkbox" name="checklist[]" value="Organization" <?php echo (isset($selected['Organization']) ? $selected['Organization'] : ""); ?>>Show Organization</label><br>
                    </div>

                    <!-- check boxes for data shown in table, PHP for holding value -->
                    <div style="width: 28%;float: left;height: 100%;padding-top:10px;">
                        <label><input type="checkbox" name="checklist[]" value="Pay_Grade" <?php echo (isset($selected['Pay_Grade']) ? $selected['Pay_Grade'] : ""); ?>>Show Pay Grade</label><br>

                        <label><input type="checkbox" name="checklist[]" value="Email" <?php echo (isset($selected['Email']) ? $selected['Email'] : ""); ?>>Show Email Address</label><br>

                        <label><input type="checkbox" name="checklist[]" value="Activation_Date" <?php echo (isset($selected['Activation_Date']) ? $selected['Activation_Date'] : ""); ?>>Show Start Date</label><br>
                    </div>
                </form>
            </div>

            <?php if ($_SESSION['permissions'] != "user") { ?>
            <div class="add_button">
                <button onclick="openAddUser()" class="nav_button">Add Person</button>
                <input type='submit' name='create_message' value='Send Message' class='nav_button' onclick='GetEmails()' />
            </div>
            <?php } ?>

            <!-- HTML to build Add User box -->
            <div id="add_user_box" class="add_user_closed">

                <h2 align="center" id="user_box_heading">Add Person</h2>
                <form method="post">
                    <div id="add_user_fields">
                        <table id="add_user_table">
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Organization</th>
                                <th>Paygrade</th>
                                <th>Email</th>
                                <th>Permissions</th>
                            </tr>
                            <tr>
                                <td><input class="user_input" type="text" name="new_firstname" required /></td>
                                <td><input class="user_input" type="text" name="new_lastname" required /></td>
                                <td>
                                    <select class="user_input" name="new_org" style="height: 29px;" required>
                                        <option value="">Select</option>
                                        <?php
                                        $group_vals = get_groupnames($link);
                                        foreach ($group_vals as $name) {
                                            echo '<option name="new_group" value="' . $name . '">' . $name . '</option>';
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td><input class="user_input" type="text" name="new_pay" style="width: 75px;" required /></td>
                                <td><input class="user_input" type="text" name="new_email" style="width: 200px;" required /></td>
                                <td>
                                    <select class="user_input" name="new_perm" style="width: 100px;height: 29px;" required>
                                        <option value="">Select</option>
                                        <option value="user">User</option>
                                        <option value="admin">Admin</option>
                                        <option value="supervisor">Supervisor</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <input class="nav_button" type="submit" name="add_user_button" style="margin-top:10px;" value="Add Person" />
                    </div>
                </form>
            </div>

            <?php // functionality for Add User Box
            if (array_key_exists('add_user_button', $_POST)) {
                $new_user[0] = (isset($_POST['new_firstname']) ? $_POST['new_firstname'] : '');
                $new_user[1] = (isset($_POST['new_lastname'])  ? $_POST['new_lastname'] : '');
                $new_user[2] = (isset($_POST['new_email'])     ? $_POST['new_email'] : '');
                $new_user[3] = (isset($_POST['new_pay'])       ? $_POST['new_pay'] : '');
                $new_user[4] = (isset($_POST['new_org'])       ? $_POST['new_org'] : '');
                $new_user[5] = (isset($_POST['new_perm'])      ? $_POST['new_perm'] : '');

                add_user($link, $new_user);
            }

            ?>

            <?php //functional code to implement checkboxes, sorting, and filtering
            //pre-defined arrays to populate $table_select based on the checkboxes
            $select_list = array("user_ID", "First_Name", "Last_Name", "Organization", "Pay_Grade", "Email", "Activation_Date");
            $table_select = array(true, true, true, true, true, true, true);

            //checks that the dropdown box has a value on button press
            if ($first_load || array_key_exists('test', $_POST)) {

                $first_load = false;
                $filter_err = false;
                //checks that value can be pulled from select and stores into $sort_value
                if (isset($_POST['sort_by'])) {
                    $sort_value = $_POST['sort_by'];
                    if (!empty($_POST['checklist'])) {
                        $sel_ind  = 0;
                        $index = 0;
                        $selected = $_POST['checklist'];
                        //loops though array of selected checkboxes and converts to a boolean array (optimized)
                        foreach ($select_list as $val) {
                            if (isset($selected[$sel_ind]) && $val == $selected[$sel_ind]) {
                                $table_select[$index] = true;
                                $sel_ind++;
                            } else {
                                $table_select[$index] = false;
                            }
                            $index++;
                        }
                    }
                } else {
                    //if fails to retrieve value, sets default to last name
                    $sort_value = 'user_ID';
                }

                $filter_value = 'none';
                $filter_key = '';
                $has_filter = false;
                //checks that filter dropdown has a value
                if (isset($_POST['filter_by'])) {
                    $filter_value = $_POST['filter_by'];
                    //checks that user is trying to filter data
                    if ($filter_value != "none") {
                        if (isset($_POST['filter_key'])) {
                            $filter_key = $_POST['filter_key'];
                            if ($filter_key == "") {
                                //if a filter category is selected but no key specified, throw error
                                $filter_err = true;
                                echo '<p style="text-align: center; color: red;">Please enter a filter key</p>';
                            } else {
                                //sets and prints filter value to page
                                $has_filter = true;
                            }
                        }
                    }
                }

                //sends sort selection and checkbox values to print function to create table
                if (!$filter_err) {
                    //adjust filter category to be valid entry for SQL query because of table JOIN
                    if ($filter_value == 'Organization') $filter_value = 'groups.group_name';

                    //build query statement to print table
                    $sql = "SELECT * FROM People INNER JOIN Groups on People.Organization = Groups.ID";

                    //if filter is specified, add to query
                    if ($filter_value != 'none') {
                        $sql = $sql . " WHERE " . $filter_value . " LIKE '%" . $filter_key . "%'";
                    }

                    //append ordering value
                    $sql = $sql . " ORDER BY " . $sort_value;

                    echo '<div class="table_wrapper">';
                    //code to print table
                    if ($res = mysqli_query($link, $sql)) {
                        //print column headers with select/dis-select all box
                        if (mysqli_num_rows($res) > 0) {
                            echo '<table class="person_table">';
                            echo "<tr>";
                            echo '<th class="person_header"><input type="checkbox" id="checkUncheckAll" onClick="CheckUncheckAll()" /></th>';
                            if ($table_select[0]) echo "<th class='person_header'>ID</th>";
                            if ($table_select[1]) echo "<th class='person_header'>First Name</th>";
                            if ($table_select[2]) echo "<th class='person_header'>Last Name</th>";
                            if ($table_select[3]) echo "<th class='person_header'>Organization</th>";
                            if ($table_select[4]) echo "<th class='person_header'>Paygrade</th>";
                            if ($table_select[5]) echo "<th class='person_header' style='width: 200px;'>Email</th>";
                            if ($table_select[6]) echo "<th class='person_header' style='width: 90px;'>Start Date</th>";
                            echo "<th class='person_header' style='width: 85px;'></th>";
                            echo "</tr>";
                            //for each row, print corresponding data to webpage
                            while ($row = mysqli_fetch_array($res)) {
                                $UID = $row['user_ID'];
                                echo "<tr class='person_row'>";
                                echo "<td class='person_data'><input class='email_check' type='checkbox' name='rowSelectCheckBox' value='" . $row['Email'] . "'/></td>";
                                if ($table_select[0]) echo "<td class='person_data'>" . $row['user_ID'] . "</td>";
                                if ($table_select[1]) echo "<td class='person_data'>" . $row['First_Name'] . "</td>";
                                if ($table_select[2]) echo "<td class='person_data'>" . $row['Last_Name'] . "</td>";
                                if ($table_select[3]) echo "<td class='person_data'>" . $row['group_name'] . "</td>";
                                if ($table_select[4]) echo "<td class='person_data'>" . $row['Pay_Grade'] . "</td>";
                                if ($table_select[5]) echo "<td class='person_data' style='width: 200px;'>" . $row['Email'] . "</td>";
                                if ($table_select[6]) echo "<td class='person_data' style='width: 90px;'>" . $row['Activation_Date'] . "</td>";
                                echo "<td class='person_data' style='width: 50px;'><button type='submit' style='margin:0;' class='trigger nav_button' data-modal-trigger='trigger-" . $row['user_ID'] . "'>View Info</button></td>";
                                echo "</tr>";
                            }
                            echo "</table>";

                            if ($_SESSION['permissions'] != "user") {
                            echo "<div class='add_button'>";
                            echo "<button onclick='GetEmails()' class='nav_button'>Send Message</button>";
                            echo "</div>";
                            }

                            mysqli_free_result($res);

                            if ($res = mysqli_query($link, $sql)) {
                                if (mysqli_num_rows($res) > 0) {
                                    while ($row = mysqli_fetch_array($res)) {
                                        $row = get_user_info($link, $row["user_ID"]); ?>

                                        <!-- use data-modal to write trigger-UID and iterate through every row of query -->
                                        <div class="modal" data-modal=<?php echo 'trigger-' . $row['user_ID'] ?>>
                                            <article class="content-wrapper">
                                                <header class="modal-header">
                                                    <h2 class="modal-user-name"><?php echo get_user_name($link, $row["user_ID"]) ?></h2>
                                                    <button class="close"></button>
                                                </header>
                                                <div class="content">
                                                    <div class="content-column">
                                                        <table align="center" id="vertical-2">
                                                            <thead>
                                                                <tr>
                                                                    <th colspan="1" align="right">User ID:</th>
                                                                </tr>
                                                                <tr>
                                                                    <th colspan="1" align="right">Organization:</th>
                                                                </tr>
                                                                <tr>
                                                                    <th colspan="1" align="right">Supervisor:</th>
                                                                </tr>
                                                                <tr>
                                                                    <th colspan="1" align="right">Email:</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td><?php echo $row["user_ID"]; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><?php echo $row["group_name"]; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><?php echo $row["supervisor_name"]; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><?php echo $row["Email"]; ?></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="content-column">
                                                        <table align="center" id="vertical-2">
                                                            <thead>
                                                                <tr>
                                                                    <th colspan="1" align="right">Pay Grade:</th>
                                                                </tr>
                                                                <tr>
                                                                    <th colspan="1" align="right">Permissions:</th>
                                                                </tr>
                                                                <tr>
                                                                    <th colspan="1" align="right">Extra Groups:</th>
                                                                </tr>
                                                                <tr>
                                                                    <th colspan="1" align="right">Start Date:</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td><?php echo $row["Pay_Grade"]; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><?php echo $row["permissions"]; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><?php echo $row["extras"]; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><?php echo $row["Activation_Date"]; ?></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <footer class="modal-footer">
                                                    <?php if ($_SESSION['permissions'] === "admin") { ?>
                                                    <button class="action" onclick="toggleConfirm(<?php echo $row['user_ID'] ?>)">Remove User</button>
                                                    <?php } ?>
                                                </footer>
                                                <div id="confirm_box_<?php echo $row["user_ID"] ?>" class="confirm_box confirm_closed">
                                                    <p style='margin-top: 15px;'>Are you sure you want to delete <?php echo get_user_name($link, $row['user_ID']) ?>? This can't be undone!</p>
                                                    <form action="" method="POST">
                                                        <button type="submit" name="confirm_remove" value="<?php echo $row['user_ID'] ?>" class="confirm_button">Confirm</button>
                                                    </form>
                                                </div>
                                            </article>
                                        </div>
            <?php
                                    }
                                }
                            }
                        }
                        //if sql query returns no results, print message
                        else {
                            echo "No matching records are found.";
                        }
                    }
                    //if query function fails, give error.
                    else {
                        echo "ERROR: Could not able to execute $sql. "
                            . mysqli_error($link);
                    }
                    echo '</div>';
                }
            }
            ?>

            <?php
            if (isset($_POST['create_message'])) {
                if (isset($_POST['rowSelectCheckBox'])) {
                    foreach ($_POST['rowSelectCheckBox'] as $select) {
                        echo $select;
                    }

                    $row_selects = $_POST['rowSelectCheckBox'];
                    if (is_array($row_selects) || is_object($row_selects)) {
                        foreach ($row_selects as $check) {
                            echo $check; 
                        }
                    } else {
                        echo $row_selects;
                    }
                }
            }
            ?>

            <br><br>

            <?php //removes user upon button press
            if (array_key_exists('confirm_remove', $_POST)) {
                remove_user($link, $_POST['confirm_remove']);
            ?>
                <script>
                    window.location.href = window.location.href;
                </script>
            <?php
            }
            ?>

        </div>



        <div class="footer">
            <nav>
                <a class='footer_link' href="../index.php">Home</a> |
                <a class='footer_link' href="../PM-pages/personnel.php">Personnel</a> |
                <a class='footer_link' href="../PM-pages/events.php">Events</a> |
                <a class='footer_link' href="../PM-pages/messaging.php">Messaging</a>
            </nav>
            <p class="footer_note">Devs: Alex Whitaker, Cainan Howard, Sammy Awad, Timothy Krenz</p>
        </div>

    </div>

    <!-- Javascript to open and close modal boxes    -->
    <script>
        const buttons = document.querySelectorAll(`button[data-modal-trigger]`);

        for (let button of buttons) {
            modalEvent(button);
        }

        function modalEvent(button) {
            button.addEventListener("click", () => {
                const trigger = button.getAttribute("data-modal-trigger");
                const modal = document.querySelector(`[data-modal=${trigger}]`);
                const contentWrapper = modal.querySelector(".content-wrapper");
                const close = modal.querySelector(".close");

                close.addEventListener("click", () => modal.classList.remove("open"));
                modal.addEventListener("click", () => modal.classList.remove("open"));
                contentWrapper.addEventListener("click", e => e.stopPropagation());

                modal.classList.toggle("open");
            });
        }
    </script>

    <!-- Stops form resubmission on page refresh -->
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>



    </div>

</body>

</html>