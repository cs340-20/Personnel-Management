<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../PM-css/styles.css">
    <title>Personnel</title> 

    <meta charset="UTF-8">

    <style>
        table {
            border: 1px solid #CCCCCC;
            border-collapse: collapse;
            
            margin-left: auto;
            margin-right: auto;
        }
        
        th, td {
            text-align: left;
            padding: 8px 15px 8px 15px;
        }
        
        tr:nth-child(even){background-color: #E1E1E1}
        tr:nth-child(odd) {background-color: #F2F2F2}
        
        th {
        background-color: rgb(117, 117, 117);
        color: white;
        }

        #selections { 
           margin-left:auto;
           margin-right:auto;
           width: 55%;
           height: 100px;
           border-radius: 5px;
           box-shadow: 5px 5px 5px #AAAAAA, -5px -5px 5px #FFFFFF
        }


        
    </style>

</head>
<body>

    <!-- Nav-bar links -->
    <ul>
        <li><a href="../index.php">Home</a></li>
        <li><a class="active" href="personnel.php">Personnel</a></li>
        <li><a href="events.php">Events</a></li>
        <li><a href="messaging.php">Messaging</a></li>
    </ul>

    
    <div style="margin-left:15%;margin-right:5%;padding:1px 16px;height:1000px;">
        <!-- Body structure goes here -->
        <h2>View Personnel</h2>

        <!-- ensures that db_utils is loaded -->
        <?php require '../PM-extras/db_utils.php';
            $link = create_connection();

            //pulls columns from table for sort selection
            $result1 = get_columns($link);
            $result2 = get_columns($link);
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
                    <input type="checkbox" name="checklist[]" value="user_ID" checked><label>Show ID</label><br>
                    <input type="checkbox" name="checklist[]" value="First_Name" checked><label>Show First Name</label><br>
                    <input type="checkbox" name="checklist[]" value="Last_Name" checked><label>Show Last Name</label><br>
                    <input type="checkbox" name="checklist[]" value="Organization" checked><label>Show Organization</label><br>
                </div>

                <!-- check boxes for data shown in table -->
                <div style="width: 28%;float: left;height: 100%;padding-top:10px;">   
                    <input type="checkbox" name="checklist[]" value="Pay_Grade" checked><label>Show Pay Grade</label><br>
                    <input type="checkbox" name="checklist[]" value="Email" checked><label>Show Email Address</label><br>
                    <input type="checkbox" name="checklist[]" value="Activation_Date" checked><label>Show Start Date</label><br>
                    <input type="checkbox" name="checklist[]" value="permissions" checked><label>Show Permissions</label><br>
                </div>
            </form>
        </div>  



        <?php
            //pre-defined arrays to populate $table_select based on the checkboxes
            $select_list = array("user_ID", "First_Name", "Last_Name", "Organization", "Pay_Grade", "Email", "Activation_Date", "permissions");
            $table_select = array(false, false, false, false, false, false, false, false);

            //checks that the dropdown box has a value
            if(array_key_exists('test',$_POST)) { 
                $filter_err = false;
                //checks that value can be pulled from select and stores into $sort_value
                if(isset($_POST['sort_by'])) {
                    $sort_value = $_POST['sort_by'];
                    if(!empty($_POST['checklist'])){
                        $sel_ind  = 0; 
                        $selected = $_POST['checklist'];

                        //loops though array of selected checkboxes and converts to a boolean array
                        foreach ($selected as $sel_val) {
                            for ($i = 0; $i < 8; $i++) {
                                if (strcmp($sel_val, $select_list[$i]) === 0) {
                                    $table_select[$i] = true;
                                    continue;
                                } 
                            }
                        }
                        
                    }
                } else {
                    //if fails to retrieve value, sets default to last name
                    echo '<p align="center">Sorted by: Last Name</p></br>';
                    $sort_value = 'Last_Name';
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
                if (!$filter_err) print_people($link, $sort_value, $table_select, $filter_value, $filter_key);
            } 
        ?>

    </div>

</body>
</html>