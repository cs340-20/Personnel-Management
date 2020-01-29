<?php  



function create_connection () {
	$link = mysqli_connect("localhost", "root", "", "Personnel"); 
  
	if ($link == false) { 
		die("ERROR: Could not connect. " .mysqli_connect_error()); 
		return NULL;
	} else {
		return $link;
	}	
}


function print_people($link, $sort_value, $table_select, $filter_value, $filter_key) { 
	if ($filter_value == 'Organization') $filter_value = 'groups.group_name';


	//build query statement to print table
	$sql = "SELECT * FROM People INNER JOIN Groups on People.Organization = Groups.ID";

	if ($filter_value != 'none') {
		$sql = $sql . " WHERE " . $filter_value . " LIKE '%" . $filter_key . "%'";
	}

	$sql = $sql . " ORDER BY " . $sort_value;


	if ($res = mysqli_query($link, $sql)) { 
		if (mysqli_num_rows($res) > 0) { 
			echo '<table id="person_table" style="border-radius: 5px;box-shadow: 5px 5px 5px #AAAAAA, -5px -5px 5px #FFFFFF">'; 
			echo "<tr>"; 
			echo "<th>Select</th>";
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
			while ($row = mysqli_fetch_array($res)) { 
				echo "<tr>"; 
				echo "<td><input type='checkbox' name='user_".$row['user_ID']."'/></td>";
				if ($table_select[0]) { echo "<td>".$row['user_ID']."</td>"; }
				if ($table_select[1]) { echo "<td>".$row['First_Name']."</td>"; } 
				if ($table_select[2]) { echo "<td>".$row['Last_Name']."</td>"; }
				if ($table_select[3]) { echo "<td>".$row['group_name']."</td>"; }
				if ($table_select[4]) { echo "<td>".$row['Pay_Grade']."</td>"; }
				if ($table_select[5]) { echo "<td>".$row['Email']."</td>"; }
				if ($table_select[6]) { echo "<td>".$row['Activation_Date']."</td>"; }
				if ($table_select[7]) { echo "<td>".$row['permissions']."</td>"; }	
				echo "<td><a href='../index.php' target='_blank'>View Info</a></td>";
				echo "</tr>"; 
			} 
			echo "</table>"; 
			mysqli_free_result($res); 
		} 
		else { 
			echo "No matching records are found."; 
		} 
	} 
	else { 
		echo "ERROR: Could not able to execute $sql. "
									.mysqli_error($link); 
	} 
	mysqli_close($link); 
}

function get_columns($link) {
	$result = $link->query("SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` 
                                    WHERE `TABLE_SCHEMA`='personnel' AND `TABLE_NAME`='people' 
									AND COLUMN_NAME NOT LIKE 'Extra%'");
									
	return $result;
}

?> 