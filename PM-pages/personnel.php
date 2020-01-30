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
        ?>

        <!-- contains sort and filter options -->
        <div id="selections">
            <form action="" method="post">
                <!-- 3 divs that contain three columns of sort, filter, and view options -->
                <div style="width: 33%;float: left;height: 100%;padding-right:20px;padding-top:5px;text-align:right;">
                    
                        <!-- create dropdown boxes with retrieved column names from database -->
                        Sort by: <select name="sort_by" style="margin-bottom: 2px;">
                            <?php
                            while($row = $result1->fetch_assoc()) {
                                echo '<option value="'.$row['COLUMN_NAME'].'">'.$row['COLUMN_NAME'].'</option>';
                            }
                            ?>
                        </select> <br>
                        Filter by: <select name="filter_by" style="margin-bottom: 2px;">
                            <?php
                            echo '<option value="none">None</option>';
                            while($row = $result2->fetch_assoc()) {
                                echo '<option value="'.$row['COLUMN_NAME'].'">'.$row['COLUMN_NAME'].'</option>';
                            }
                            ?>
                        </select><br>
                        <!-- Text box for filter key -->
                        Key: <input type="text" name="filter_key" style="width: 114px; margin-bottom: 2px;">
                        <br>
                        
                        <!-- Go button to print table -->
                        <input type="submit" name="test" id="test" value="Go" /><br/>
                    
                </div>
                
                <!-- check boxes for data shown in table -->
                <div style="width: 33%;float: left;height: 100%;padding-top:10px;">
                    <input type="checkbox" name="checklist[]" value="user_ID"      checked><label>Show ID</label><br>
                    <input type="checkbox" name="checklist[]" value="First_Name"   checked><label>Show First Name</label><br>
                    <input type="checkbox" name="checklist[]" value="Last_Name"    checked><label>Show Last Name</label><br>
                    <input type="checkbox" name="checklist[]" value="Organization" checked><label>Show Organization</label><br>
                </div>

                <!-- check boxes for data shown in table -->
                <div style="width: 28%;float: left;height: 100%;padding-top:10px;">   
                    <input type="checkbox" name="checklist[]" value="Pay_Grade"       checked><label>Show Pay Grade</label><br>
                    <input type="checkbox" name="checklist[]" value="Email"           checked><label>Show Email Address</label><br>
                    <input type="checkbox" name="checklist[]" value="Activation_Date" checked><label>Show Start Date</label><br>
                    <input type="checkbox" name="checklist[]" value="permissions"     checked><label>Show Permissions</label><br>
                </div>
            </form>
        </div>  



        <?php //functional code to implement checkboxes, sorting, and filtering
            //pre-defined arrays to populate $table_select based on the checkboxes
            $select_list = array("user_ID", "First_Name", "Last_Name", "Organization", "Pay_Grade", "Email", "Activation_Date", "permissions");
            if ($first_load) $table_select = array(true, true, true, true, true, true, true, true);

            //checks that the dropdown box has a value
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
                            if ($val == $selected[$sel_ind]) {
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

                //print sort and filter data for user
                echo '<br><p align="center">Sorted by: ' .$sort_value. "</p>";
                if ($has_filter) echo '<p align="center">Filtered by: ' .$filter_value. " - " .$filter_key. "</p>";

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
                        echo '<table id="person_table" style="border-radius: 5px;box-shadow: 5px 5px 5px #AAAAAA, -5px -5px 5px #FFFFFF">'; 
                        echo "<tr>"; 
                        echo '<th><input type="checkbox" id="checkUncheckAll" onClick="CheckUncheckAll()" /></th>;';
                        if ($table_select[0] == 1) { echo "<th>ID</th>"; }
                        if ($table_select[1]) { echo "<th>First Name</th>"; }
                        if ($table_select[2]) { echo "<th>Last Name</th>";  }
                        if ($table_select[3]) { echo "<th>Organization</th>"; }
                        if ($table_select[4]) { echo "<th>Paygrade</th>"; }
                        if ($table_select[5]) { echo "<th>Email</th>"; }
                        if ($table_select[6]) { echo "<th>Start Date</th>"; }
                        if ($table_select[7]) { echo "<th>Permissions</th>"; }
                        echo "<th></th>";
                        echo "</tr>"; 
                        //for each row, print corresponding data to webpage
                        while ($row = mysqli_fetch_array($res)) { 
                            $UID = $row['user_ID'];
                            echo "<tr>"; 
                            echo "<td><input type='checkbox' name='rowSelectCheckBox' value='".$row['user_ID']."'/></td>";
                            if ($table_select[0]) { echo "<td>".$row['user_ID']."</td>"; }
                            if ($table_select[1]) { echo "<td>".$row['First_Name']."</td>"; } 
                            if ($table_select[2]) { echo "<td>".$row['Last_Name']."</td>"; }
                            if ($table_select[3]) { echo "<td>".$row['group_name']."</td>"; }
                            if ($table_select[4]) { echo "<td>".$row['Pay_Grade']."</td>"; }
                            if ($table_select[5]) { echo "<td>".$row['Email']."</td>"; }
                            if ($table_select[6]) { echo "<td>".$row['Activation_Date']."</td>"; }
                            if ($table_select[7]) { echo "<td>".$row['permissions']."</td>"; }	
                            echo "<td><a href='user_data.php?user_ID=" .$UID. "' target='_blank'>View Info</a></td>";
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
    </div>
</body>
</html>