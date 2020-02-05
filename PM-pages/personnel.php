<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../PM-css/styles.css">
    <title>Personnel</title> 

    <meta charset="UTF-8">

    <!-- javascript to control select/dis-select all box -->
    <script type="text/javascript">function CheckUncheckAll(){
        var  selectAllCheckbox=document.getElementById("checkUncheckAll");
        if(selectAllCheckbox.checked==true){
            var checkboxes =  document.getElementsByName("rowSelectCheckBox");
            for(var i=0, n=checkboxes.length;i<n;i++) {
                checkboxes[i].checked = true;
            }
        } else {
            var checkboxes =  document.getElementsByName("rowSelectCheckBox");
            for(var i=0, n=checkboxes.length;i<n;i++) {
                checkboxes[i].checked = false;
            }
        }
    }</script>

</head>
<body>

    <!-- Nav-bar links -->
    <ul>
        <li><a href="../index.php">Home</a></li>
        <li><a class="active" href="personnel.php">Personnel</a></li>
        <li><a href="events.php">Events</a></li>
        <li><a href="messaging.php">Messaging</a></li>
    </ul>

    
    <div class="page_body">
        <!-- Body structure goes here -->
        <h2>View Personnel</h2>

        <!-- ensures that db_utils is loaded -->
        <?php require '../PM-extras/db_utils.php';
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

        <!-- HTML for view, sort, and filter options -->
        <div id="selections">
            <form action="" method="post">
                <!-- 3 divs that contain three columns of sort, filter, and view options -->
                <div style="width: 33%;float: left;height: 100%;padding-right:20px;padding-top:5px;text-align:right;">
                    
                        <!-- create dropdown boxes with retrieved column names from database -->
                        Sort by: <select name="sort_by" style="margin-bottom: 2px;">
                            <?php
                            //make sort box based on column headers
                            while($row = $result1->fetch_assoc()) {
                                echo '<option value="'.$row['COLUMN_NAME'].'" '. ((isset($_POST["sort_by"]) && $_POST["sort_by"] == $row['COLUMN_NAME']) ? "selected='selected'" : "") .'>'.$row['COLUMN_NAME'].'</option>';
                            }
                            ?>
                        </select> <br>
                        Filter by: <select name="filter_by" style="margin-bottom: 2px;">
                            <?php
                            //make filter box based on column headers
                            echo '<option value="none">None</option>';
                            while($row = $result2->fetch_assoc()) {
                                echo '<option value="'.$row['COLUMN_NAME'].'" '. ((isset($_POST["filter_by"]) && $_POST["filter_by"] == $row['COLUMN_NAME']) ? "selected='selected'" : "") .'>'.$row['COLUMN_NAME'].'</option>';
                            }
                            ?>
                        </select><br>
                        <!-- Text box for filter key -->
                        Key: <input type="text" name="filter_key" style="width: 114px; margin-bottom: 2px;" 
                            value="<?php echo isset($_POST['filter_key']) ? $_POST['filter_key'] : '' ?>">
                        <br>
                        
                        <!-- Go button to print table -->
                        <input align='left' type="submit" name="display_new" value="Add Person" style="margin-right: 65px;"/><input type="submit" name="test" id="test" value="Go" /><br/>
                    
                </div>
                
                <!-- check boxes for data shown in table, PHP for holding value -->
                <div style="width: 33%;float: left;height: 100%;padding-top:10px;">
                    <label><input type="checkbox" name="checklist[]" value="user_ID" 
                        <?php echo (isset($selected['user_ID'])      ? $selected['user_ID'] : ""); ?>>Show ID</label><br>

                    <label><input type="checkbox" name="checklist[]" value="First_Name"
                        <?php echo (isset($selected['First_Name'])   ? $selected['First_Name'] : ""); ?>>Show First Name</label><br>

                    <label><input type="checkbox" name="checklist[]" value="Last_Name"    
                        <?php echo (isset($selected['Last_Name'])    ? $selected['Last_Name'] : ""); ?>>Show Last Name</label><br>

                    <label><input type="checkbox" name="checklist[]" value="Organization" 
                        <?php echo (isset($selected['Organization']) ? $selected['Organization'] : ""); ?>>Show Organization</label><br>
                </div>

                <!-- check boxes for data shown in table, PHP for holding value -->
                <div style="width: 28%;float: left;height: 100%;padding-top:10px;">   
                    <label><input type="checkbox" name="checklist[]" value="Pay_Grade"       
                        <?php echo (isset($selected['Pay_Grade']) ? $selected['Pay_Grade'] : ""); ?>>Show Pay Grade</label><br>

                    <label><input type="checkbox" name="checklist[]" value="Email"           
                        <?php echo (isset($selected['Email']) ? $selected['Email'] : ""); ?>>Show Email Address</label><br>

                    <label><input type="checkbox" name="checklist[]" value="Activation_Date" 
                        <?php echo (isset($selected['Activation_Date']) ? $selected['Activation_Date'] : ""); ?>>Show Start Date</label><br>
                        
                    <label><input type="checkbox" name="checklist[]" value="permissions"     
                        <?php echo (isset($selected['permissions']) ? $selected['permissions'] : ""); ?>>Show Permissions</label><br>
                </div>
            </form>
        </div>  


        <?php if (array_key_exists('display_new', $_POST)) {

        ?>
        <!-- HTML to build Add User box -->
        <p align="center"></p>
        <div id="add_user_box" class="elementToAnimate">
            
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
                            <td><input type="text" name="new_firstname"/></td>
                            <td><input type="text" name="new_lastname"/></td>
                            <td>
                                <select name="new_org" style="height: 21px;">
                                    <option value="none">Select</option>
                                    <?php 
                                        $group_vals = get_groupnames($link);
                                        foreach ($group_vals as $name) {
                                            echo '<option name="new_group" value="'.$name.'">'.$name.'</option>';
                                        } 
                                    ?>
                                </select>   
                            </td>
                            <td><input type="text" name="new_pay" style="width: 75px;"/></td>
                            <td><input type="text" name="new_email" style="width: 200px;"/></td>
                            <td>
                                <select name="new_perm" style="width: 100px;height: 21px;">
                                    <option value="none">Select</option>
                                    <option value="user">User</option>
                                    <option value="admin">Admin</option>
                                    <option value="supervisor">Supervisor</option>
                                </select>  
                            </td>
                        </tr>
                    </table>
                    <input type="submit" name="add_user_button" style="margin-top:5px;" value="Add Person"/>
                </div>
            </form>
        </div>

        <?php } ?>



        <?php // functionality for Add User Box
            if (array_key_exists('add_user_button', $_POST)) {
                $new_user[0] = (isset($_POST['new_firstname']) ? $_POST['new_firstname'] : '');
                $new_user[1] = (isset($_POST['new_lastname'])  ? $_POST['new_lastname'] : '');
                $new_user[2] = (isset($_POST['new_email'])     ? $_POST['new_email'] : '');
                $new_user[3] = (isset($_POST['new_pay'])       ? $_POST['new_pay'] : '');
                $new_user[4] = (isset($_POST['new_org'])       ? $_POST['new_org'] : '');
                $new_user[5] = (isset($_POST['new_perm'])      ? $_POST['new_perm'] : '');

                $add_err = false;
                foreach ($new_user as $sel) {
                    if ($sel == '') {
                        $add_err = true;
                    }
                }

                if ($add_err) {
                    echo "<p align='center' style='color:red;'>All Fields Required</p>";
                } else {
                    add_user($link, $new_user);
                }
            }

        ?>

        <?php //functional code to implement checkboxes, sorting, and filtering
            //pre-defined arrays to populate $table_select based on the checkboxes
            $select_list = array("user_ID", "First_Name", "Last_Name", "Organization", "Pay_Grade", "Email", "Activation_Date", "permissions");
            $table_select = array(true, true, true, true, true, true, true, true);

            //checks that the dropdown box has a value on button press
            if($first_load || array_key_exists('test',$_POST)) { 
                
                $first_load = false;
                $filter_err = false;
                //checks that value can be pulled from select and stores into $sort_value
                if(isset($_POST['sort_by'])) {
                    $sort_value = $_POST['sort_by'];
                    if(!empty($_POST['checklist'])){
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
                if(isset($_POST['filter_by'])) {
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

                    //code to print table
                    if ($res = mysqli_query($link, $sql)) { 
                        //print column headers with select/dis-select all box
                        if (mysqli_num_rows($res) > 0) { 
                            echo '<table id="person_table" style="border-radius: 5px;box-shadow: 5px 5px 5px #AAAAAA, -5px -5px 5px #FFFFFF; margin-top: 30px;">'; 
                            echo "<tr>"; 
                            echo '<th class="person_header"><input type="checkbox" id="checkUncheckAll" onClick="CheckUncheckAll()" /></th>';
                            if ($table_select[0]) { echo "<th class='person_header'>ID</th>"; }
                            if ($table_select[1]) { echo "<th class='person_header'>First Name</th>"; }
                            if ($table_select[2]) { echo "<th class='person_header'>Last Name</th>";  }
                            if ($table_select[3]) { echo "<th class='person_header'>Organization</th>"; }
                            if ($table_select[4]) { echo "<th class='person_header'>Paygrade</th>"; }
                            if ($table_select[5]) { echo "<th class='person_header'>Email</th>"; }
                            if ($table_select[6]) { echo "<th class='person_header'>Start Date</th>"; }
                            if ($table_select[7]) { echo "<th class='person_header'>Permissions</th>"; }
                            echo "<th class='person_header'></th>";
                            echo "</tr>"; 
                            //for each row, print corresponding data to webpage
                            while ($row = mysqli_fetch_array($res)) { 
                                $UID = $row['user_ID']; 
                                echo "<tr class='person_row'>"; 
                                echo "<td class='person_data'><input type='checkbox' name='rowSelectCheckBox' value='".$row['user_ID']."'/></td>";
                                if ($table_select[0]) { echo "<td class='person_data'>".$row['user_ID']."</td>"; }
                                if ($table_select[1]) { echo "<td class='person_data'>".$row['First_Name']."</td>"; }
                                if ($table_select[2]) { echo "<td class='person_data'>".$row['Last_Name']."</td>"; }
                                if ($table_select[3]) { echo "<td class='person_data'>".$row['group_name']."</td>"; }
                                if ($table_select[4]) { echo "<td class='person_data'>".$row['Pay_Grade']."</td>"; }
                                if ($table_select[5]) { echo "<td class='person_data'>".$row['Email']."</td>"; }
                                if ($table_select[6]) { echo "<td class='person_data'>".$row['Activation_Date']."</td>"; }
                                if ($table_select[7]) { echo "<td class='person_data'>".$row['permissions']."</td>"; }	
                                echo "<td class='person_data'><a class='user_link' href='user_data.php?user_ID=" .$UID. "' target='_blank'>View Info</a></td>";
                                echo "</tr>"; 
                            } 
                            echo "</table>"; 
                            mysqli_free_result($res); 
                        } 
                        //if sql query returns no results, print message
                        else { 
                            echo "No matching records are found."; 
                        } 
                    } 
                    //if query function fails, give error.
                    else { 
                        echo "ERROR: Could not able to execute $sql. "
                                                    .mysqli_error($link); 
                    } 
                }
            } 
        ?>

        <br><br><br>

    </div>

</body>
</html>