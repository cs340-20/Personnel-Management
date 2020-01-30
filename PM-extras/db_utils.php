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

function get_user_name($link, $user_ID) {
	$full_name = "";

	$query = "SELECT Last_Name, First_Name FROM People WHERE People.user_ID = " . $user_ID;

	if ($result = mysqli_query($link, $query)) {

		$row = mysqli_fetch_array($result);

		$full_name = $row['Last_Name'] . ", " . $row['First_Name'];

		//echo $full_name;

	} else {
		echo "ERROR: Could not able to execute $sql. "
									.mysqli_error($link); 
	}
	mysqli_close($link); 

	return $full_name;
}



function get_columns($link) {
	$result = $link->query("SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` 
                                    WHERE `TABLE_SCHEMA`='personnel' AND `TABLE_NAME`='people' 
									AND COLUMN_NAME NOT LIKE 'Extra%'");
									
	return $result;
}

?> 