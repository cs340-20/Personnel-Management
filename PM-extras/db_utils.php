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

function add_user($link, $new_user) {
	$date = date("Y-m-d");
	
	if ($result = mysqli_query($link, "SELECT people.user_ID FROM people")) {
		$last = -1;
		while ($row = mysqli_fetch_array($result)) {
			if ($row[0] != ($last + 1)) {
				$num = $last + 1;
				break;
			} else {
				$last = $row[0];
			}
		}
		$num = $last + 1;
	}

	if ($result = mysqli_query($link, "SELECT groups.ID FROM groups WHERE groups.group_name='".$new_user[4]."'")) {
		$row = mysqli_fetch_array($result);
		$org_id = $row[0];
	}

	if (!mysqli_query($link, 'INSERT INTO personnel.people (user_ID, First_Name, Last_name, Email, Activation_Date, Pay_Grade, Organization, permissions) 
								VALUES ('.$num.', "'.$new_user[0].'", "'.$new_user[1].'", "'.$new_user[2].'", "'.$date.'", "'.$new_user[3].'", "'.$org_id.'", "'.$new_user[5].'")')) {
		echo "insert failed";
	}

}

function remove_user($link, $remove_ID) {
	$remove_query = "DELETE FROM people WHERE people.user_ID = ". $remove_ID;

	if (mysqli_query($link, $remove_query)) {
	} else {
		echo "Failed to remove user " .$remove_ID;
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
		echo "ERROR: Could not execute sql query."
									.mysqli_error($link); 
	}

	return $full_name;
}

function get_groupnames($link) {
	if ($result = mysqli_query($link, "SELECT group_name FROM groups")) {
		while ($row = mysqli_fetch_array($result)) {
			$names[] = $row[0];
		}

	} else {
		echo "ERROR: Could not get group names.";
	}
	return $names;
}

function get_columns($link) {
	$result = $link->query("SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` 
                                    WHERE `TABLE_SCHEMA`='personnel' AND `TABLE_NAME`='people' 
									AND COLUMN_NAME NOT LIKE 'Extra%'");
									
	return $result;
}

function get_user_info($link, $UID) {
	$res = mysqli_query($link, "SELECT * FROM people JOIN groups ON people.Organization = groups.ID WHERE user_ID = ". $UID);
	$row = mysqli_fetch_array($res);

	$row["supervisor_name"] = get_user_name($link, $row["supervisor_ID"]);

	$get_gps = mysqli_query($link, "SELECT ID, group_name FROM groups");
	while ($gp_row = mysqli_fetch_array($get_gps)) {
		$gp_names[$gp_row["ID"]] = $gp_row["group_name"];
	}

	$extras = "";

	if ($row['Extra_1'] != 0) {
		$extras	= $extras . $gp_names[$row["Extra_1"]];
	}
	if ($row['Extra_2'] != 0) {
		if ($extras != "") $extras = $extras . ", ";
		$extras	= $extras . $gp_names[$row["Extra_2"]];
	}
	if ($row['Extra_3'] != 0) {
		if ($extras != "") $extras = $extras . ", ";
		$extras	= $extras . $gp_names[$row["Extra_3"]];
	}
	if ($row['Extra_4'] != 0) {
		if ($extras != "") $extras = $extras . ", ";
		$extras	= $extras . $gp_names[$row["Extra_4"]];
	}
	if ($row['Extra_5'] != 0) {
		if ($extras != "") $extras = $extras . ", ";
		$extras	= $extras . $gp_names[$row["Extra_5"]];
	}

	if ($extras == "") $row["extras"] = "None";
		else $row["extras"] = $extras;

	return $row;
}

?> 